# Flutter Admin Architecture Blueprint

## 1. Product Goals
- Mirror every Laravel admin route defined under the `admin` prefix in `routes/web.php`, including dashboard, catalog, inventory, POS, advertising, reporting, and settings features.
- Provide a dedicated admin API surface (separate from Blade views) built on Laravel Sanctum for token-based authentication.
- Deliver both online and offline modes in the Flutter app, with a deterministic sync & conflict policy so data captured offline (especially POS sales) is never lost.

## 2. System Architecture
### Backend (Laravel 10)
- **API Layer**: REST endpoints under `/api/admin/*`, grouped by module, powered by controllers in `app/Http/Controllers/Api/Admin`.
- **Auth & Roles**: Sanctum personal-access tokens; middleware to ensure admin-only access while reusing upcoming role/permission tables.
- **Transformers**: Laravel API Resources to keep payloads consistent with mobile needs (nested relations, computed fields, pagination metadata).
- **Background Jobs**: Queued exports (CSV/PDF) and heavy reports to keep mobile responses snappy.

### Mobile (Flutter)
- **Architecture Pattern**: Feature-first directory structure with presentation (Widgets + `Riverpod`/`Bloc`), domain (use cases), and data (repositories).
- **Networking**: `Dio` (retry, interceptors, logging) with `Chopper`-style generated clients for type-safe endpoints.
- **Local Cache**: `Drift` database (or `Hive` for simple key-value) mirroring backend tables required for offline work; `Isar` optional for tree data (categories).
- **Sync Engine**: Background isolates scheduled via `workmanager` to push/pull deltas when connectivity resumes.

### Data Sync Flow
1. User action produces domain event.
2. Repository writes to Drift within a transaction (marked `pending_sync`).
3. Sync engine batches pending ops and POSTs/PUTs them to the API.
4. Server responds with authoritative record + `updated_at`/`version`.
5. Local cache upserts data; conflicts resolved per-entity rules (e.g., server-wins for catalog, client-wins for queued POS sales unless server rejects).

## 3. Database Mapping
| Module | Laravel Tables | Notes / Needed Additions |
| --- | --- | --- |
| Auth & Roles | `users`, `roles`, `permissions`, pivot tables | Ensure admin roles seeded; expose token issuance endpoints. |
| Catalog | `brands`, `categories`, `products` (+ SEO/GST fields) | Need `product_images` table or reuse JSON `images`; consider `product_prices` history table. |
| Inventory | `branches`, `registers`, `suppliers`, `purchases` | Add `purchase_items` (product_id, qty, unit_cost), `stock_adjustments`. |
| POS & Sales | `sales`, `registers`, `users` | Add `sale_items`, `payments` tables for detailed receipts. |
| Advertising | `ad_placements`, `ad_campaigns` | Include media asset references + scheduling metadata. |
| Reports | Virtual; aggregates from `sales`, `purchases`, `products` | Consider materialized snapshot tables for performance. |
| Settings | `settings` (key/value JSON) | Ensure system tasks (backup, cache clear) are logged. |

### Mobile Local Tables (Drift)
- `sync_queue` (id, entity_type, payload, operation, status, last_error).
- Mirrors for major entities: `brands`, `categories`, `products`, `branches`, `suppliers`, `purchases`, `purchases_items`, `sales`, `sale_items`, `settings`.
- `dashboard_metrics_cache` keyed by date range for offline dashboards.

## 4. Flutter Project Structure
```
/mobile_admin
  lib/
    core/            # theme, localization, routing, http client, error types
    data/
      sources/api/   # endpoint definitions
      sources/local/ # Drift DAOs, Hive boxes
      repositories/  # module-specific repos
    domain/
      models/        # freezed data classes mirroring API payloads
      usecases/
    features/
      auth/
      dashboard/
      catalog/
      inventory/
      pos/
      advertising/
      reports/
      settings/
    sync/
      queue_manager.dart
      conflict_policies.dart
```
- Adopt `go_router` for navigation to keep deep-link friendly.
- Shared UI kit in `core/widgets` for cards, tables, filters, badges that match the Blade admin design.

## 5. API Strategy
- **Base URL**: `https://{domain}/api/admin`.
- **Versioning**: Use `/v1` prefix to allow future changes without breaking the app.
- **Pagination**: Cursor-based (`?page[size]=20&page[cursor]=...`) for better offline merging; fallback to Laravel's paginator for quick start.
- **Filtering/Search**: Accept query params mirroring existing web filters (e.g., `/catalog/products?brand_id=&status=&search=`).
- **File Uploads**: Use multipart endpoints for product images, ad creatives, and settings (logo/favicon).
- **Exports**: Trigger asynchronous jobs returning export IDs; mobile polls `/exports/{id}` for completion then downloads file.

## 6. Offline Storage & Sync
- **Write-ahead cache**: Every mutation stored locally with `uuid` so the UI responds instantly.
- **Conflict Rules**:
  - Catalog/Inventory: server authoritative; if conflict, notify user to refresh.
  - POS Sales: client authoritative until server accepts/rejects; duplicates prevented via `client_reference`.
  - Settings/Reports: online-only actions blocked offline with contextual messaging.
- **Retry Policy**: Exponential backoff per entity; give user ability to manually retry or discard.
- **Audit Trail**: Keep `sync_audit` table for debugging (timestamp, action, result).

## 7. Module Breakdown
### Auth Module
- Endpoints: `/auth/login`, `/auth/logout`, `/auth/token/refresh`, `/auth/profile`.
- Flutter: login screen, 2FA/biometric unlock, session guard provider, offline fallback (cached token with short TTL).

### Dashboard
- Metrics from aggregated endpoints `/dashboard/summary`, `/dashboard/recent-orders`, `/dashboard/low-stock`.
- Cache snapshots offline; highlight staleness with timestamp badges.

### Catalog
- CRUD endpoints for brands, categories, products.
- Support media uploads, bulk status updates, exports trigger.
- Offline drafts stored until connectivity returns; diff view before sync.

### Inventory
- Purchases: CRUD + receive/cancel actions; requires nested items payload.
- Transfers & stock adjustments: endpoints for move/adjust operations.
- Branch/register management for POS tie-in.

### POS
- Search endpoints (`/pos/products`, `/pos/customers`) support barcode/keyword.
- Sale creation posts cart lines + payments; offline queue ensures store mode.
- Optional peripherals (scanner, printer) handled via platform channels.

### Advertising
- Manage placements (slots) and campaigns (creative + schedule).
- Include status transitions (draft, scheduled, running, paused, archived).

### Reports
- Data endpoints for sales, inventory valuation, tax/GST, advertising ROI.
- Export endpoints returning CSV/PDF references for download.

### Settings
- General store profile, currency, SMTP, payments, SMS, maintenance utilities (backup, cache clear, system update).
- Some actions (backup, artisan commands) remain online-only with explicit warnings.

## 8. Non-Functional Requirements
- **Security**: Enforce HTTPS, rotate tokens, lock device after inactivity, encrypt local sensitive data.
- **Observability**: Add Sentry (Flutter + Laravel) plus structured logs for sync failures.
- **Performance**: Lazy-load large lists, use pagination/infinite scroll, prefetch frequently used datasets (e.g., top products).
- **Localization**: structure strings for future multi-language support.
- **CI/CD**: GitHub Actions (Laravel tests + Flutter analyze/test) plus fastlane pipelines for Android/iOS distribution.

This blueprint addresses the first implementation step by mapping the existing Laravel admin surface to a concrete Flutter + API architecture while planning the necessary database artifacts and sync strategy.

