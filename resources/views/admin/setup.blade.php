@extends('layouts.auth')

@section('title', 'Database Setup')

@section('content')
<div class="login-container">
  <div class="login-header">
    <div class="mb-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="mb-2">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
      </svg>
    </div>
    <h2 class="fw-bold mb-2">Database Setup</h2>
    <p class="mb-0 opacity-75">Setup database and admin user</p>
  </div>
  
  <div class="login-body">
    <div id="setup-status" class="mb-4">
      <!-- Status messages will appear here -->
    </div>

    <div class="d-grid gap-3">
      <button type="button" class="btn btn-outline-primary" onclick="testConnection()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
        Test Database Connection
      </button>
      
      <button type="button" class="btn btn-primary" onclick="setupDatabase()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
        </svg>
        Setup Database (MySQL)
      </button>
      
      <button type="button" class="btn btn-info" onclick="setupSQLite()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
        Setup SQLite (Fallback)
      </button>
      
      <button type="button" class="btn btn-success" onclick="createAdmin()">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        Create Admin User
      </button>
    </div>

    <div class="mt-4">
      <h6 class="fw-semibold mb-2">Admin Credentials:</h6>
      <div class="bg-light p-3 rounded">
        <p class="mb-1"><strong>Email:</strong> admin@electro.com</p>
        <p class="mb-0"><strong>Password:</strong> password</p>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('admin.login') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Go to Login
      </a>
    </div>
  </div>
</div>

<script>
function showStatus(message, type = 'info') {
  const statusDiv = document.getElementById('setup-status');
  const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
  statusDiv.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
}

function testConnection() {
  showStatus('Testing database connection...', 'info');
  
  fetch('{{ route("admin.test-db") }}')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showStatus(`✅ ${data.message}<br>Database: ${data.database}`, 'success');
      } else {
        showStatus(`❌ ${data.message}`, 'error');
      }
    })
    .catch(error => {
      showStatus(`❌ Connection failed: ${error.message}`, 'error');
    });
}

function setupDatabase() {
  showStatus('Setting up database tables...', 'info');
  
  fetch('{{ route("admin.setup-database") }}')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showStatus(`✅ ${data.message}<br>Admin credentials: ${data.admin_credentials.email} / ${data.admin_credentials.password}`, 'success');
      } else {
        showStatus(`❌ ${data.message}`, 'error');
      }
    })
    .catch(error => {
      showStatus(`❌ Setup failed: ${error.message}`, 'error');
    });
}

function setupSQLite() {
  showStatus('Setting up SQLite database...', 'info');
  
  fetch('{{ route("admin.setup-sqlite") }}')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showStatus(`✅ ${data.message}<br>Database: SQLite`, 'success');
      } else {
        showStatus(`❌ ${data.message}`, 'error');
      }
    })
    .catch(error => {
      showStatus(`❌ SQLite setup failed: ${error.message}`, 'error');
    });
}

function createAdmin() {
  showStatus('Creating admin user...', 'info');
  
  fetch('{{ route("admin.create-admin") }}')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showStatus(`✅ ${data.message}<br>User: ${data.user.name} (${data.user.email})`, 'success');
      } else {
        showStatus(`❌ ${data.message}`, 'error');
      }
    })
    .catch(error => {
      showStatus(`❌ Admin creation failed: ${error.message}`, 'error');
    });
}
</script>
@endsection
