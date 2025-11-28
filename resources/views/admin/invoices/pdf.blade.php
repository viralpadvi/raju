<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice {{ $sale->invoice_number ?? $sale->sale_number }}</title>
  <style>
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #0f172a; margin: 0; padding: 30px; }
    .invoice-card { border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; }
    .invoice-header { display:flex; justify-content:space-between; gap:2rem; border-bottom:1px solid #e2e8f0; padding-bottom:1.5rem; margin-bottom:1.5rem; }
    .invoice-header h2 { margin:0 0 5px; }
    .invoice-header p { margin:0 0 4px; }
    .invoice-meta { margin-bottom: 1.5rem; }
    .invoice-meta h6 { margin-bottom: .5rem; letter-spacing: 1px; text-transform: uppercase; color:#94a3b8; }
    .invoice-meta p { margin: 0 0 4px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px 10px; border: 1px solid #e2e8f0; }
    th { background: #f8fafc; font-size: 11px; letter-spacing:.8px; text-transform: uppercase; color:#475569; }
    .table-responsive { margin-bottom: 1.25rem; }
    .table-borderless td { border:none; padding:6px 0; }
    .table-borderless tr.total-row td { border-top:2px solid #e2e8f0; font-weight:700; font-size:13px; }
    .invoice-footer { border-top:1px dashed #cbd5f5; padding-top:1rem; margin-top:1rem; color:#64748b; }
  </style>
</head>
<body>
  @include('admin.invoices.template', ['sale' => $sale, 'settings' => $settings])
</body>
</html>


