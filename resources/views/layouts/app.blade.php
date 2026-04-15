<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ITP System') - Mini LNG 36 TEU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0e27;
            --bg-secondary: #111638;
            --bg-card: rgba(22, 28, 66, 0.7);
            --bg-card-hover: rgba(30, 38, 85, 0.8);
            --accent-blue: #3b82f6;
            --accent-cyan: #06b6d4;
            --accent-purple: #8b5cf6;
            --accent-green: #10b981;
            --accent-orange: #f59e0b;
            --accent-red: #ef4444;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: rgba(99, 102, 241, 0.2);
            --glass-bg: rgba(15, 23, 42, 0.6);
            --glass-border: rgba(99, 102, 241, 0.15);
            --shadow-glow: 0 0 30px rgba(59, 130, 246, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--bg-secondary);
            border-right: 1px solid var(--glass-border);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--glass-border);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: white;
        }

        .sidebar-logo .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .sidebar-logo .logo-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            padding: 8px 12px;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(6, 182, 212, 0.1));
            color: var(--accent-cyan);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .nav-item i { width: 20px; text-align: center; font-size: 15px; }

        /* User info at bottom */
        .sidebar-footer {
            padding: 16px 16px;
            border-top: 1px solid var(--glass-border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background: var(--bg-card);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-name { font-size: 13px; font-weight: 600; }
        .user-role { font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }

        /* Main content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 24px 32px;
        }

        /* Top bar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .topbar h1 {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .topbar .breadcrumb {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .topbar .breadcrumb a {
            color: var(--accent-blue);
            text-decoration: none;
        }

        .topbar .breadcrumb a:hover { text-decoration: underline; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--accent-green), #059669);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--accent-red), #dc2626);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #d97706);
            color: white;
        }

        .btn-sm { padding: 7px 14px; font-size: 12px; }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: var(--shadow-glow);
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        /* Stat cards */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-value { font-size: 28px; font-weight: 800; }
        .stat-label { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* Tables */
        .table-container {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--glass-border);
            text-align: left;
        }

        tbody td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.07);
        }

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
        }

        /* Badge */
        .badge {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-blue { background: rgba(59, 130, 246, 0.15); color: var(--accent-blue); }
        .badge-green { background: rgba(16, 185, 129, 0.15); color: var(--accent-green); }
        .badge-orange { background: rgba(245, 158, 11, 0.15); color: var(--accent-orange); }
        .badge-red { background: rgba(239, 68, 68, 0.15); color: var(--accent-red); }
        .badge-purple { background: rgba(139, 92, 246, 0.15); color: var(--accent-purple); }
        .badge-cyan { background: rgba(6, 182, 212, 0.15); color: var(--accent-cyan); }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg-primary);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .form-error {
            color: var(--accent-red);
            font-size: 12px;
            margin-top: 4px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--accent-green);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--accent-red);
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--bg-secondary);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            width: 90%;
            max-width: 560px;
            max-height: 85vh;
            overflow-y: auto;
            padding: 28px;
            animation: modalIn 0.3s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .modal-close:hover {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        /* Accordion */
        .accordion-item {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .accordion-header {
            padding: 14px 18px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
        }

        .accordion-header:hover { background: var(--bg-card-hover); }

        .accordion-header .title {
            font-weight: 600;
            font-size: 14px;
        }

        .accordion-header .subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .accordion-header .chevron {
            color: var(--text-muted);
            transition: transform 0.3s ease;
        }

        .accordion-item.open .accordion-header .chevron {
            transform: rotate(180deg);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-item.open .accordion-body {
            max-height: 2000px;
        }

        .accordion-content {
            padding: 0 18px 18px;
        }

        /* Inspection row */
        .inspection-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            border-radius: 8px;
            background: rgba(10, 14, 39, 0.5);
            margin-bottom: 6px;
        }

        .inspection-row .code { font-weight: 600; font-size: 13px; color: var(--accent-cyan); }
        .inspection-row .desc { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

        /* Tabs */
        .tab-container {
            display: flex;
            gap: 4px;
            background: var(--bg-card);
            padding: 4px;
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            width: fit-content;
            margin-bottom: 24px;
        }

        .tab-btn {
            padding: 9px 20px;
            border-radius: 9px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            color: white;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .tab-btn:hover:not(.active) {
            color: var(--text-primary);
            background: rgba(59, 130, 246, 0.1);
        }

        /* Status badges */
        .status-pending { background: rgba(245, 158, 11, 0.15); color: var(--accent-orange); }
        .status-progress { background: rgba(59, 130, 246, 0.15); color: var(--accent-blue); }
        .status-approve { background: rgba(16, 185, 129, 0.15); color: var(--accent-green); }
        .status-rejected { background: rgba(239, 68, 68, 0.15); color: var(--accent-red); }

        /* Photo preview */
        .photo-preview {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            margin-top: 8px;
        }

        /* Animations */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in { animation: fadeIn 0.4s ease; }

        /* Responsive */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 150;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--bg-secondary);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            font-size: 18px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 16px; padding-top: 60px; }
            .menu-toggle { display: flex; }
            .card-grid { grid-template-columns: 1fr; }
        }

        /* Logout button */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            color: var(--accent-red);
            background: rgba(239, 68, 68, 0.1);
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            margin-top: 8px;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i { font-size: 48px; color: var(--text-muted); margin-bottom: 16px; }
        .empty-state p { color: var(--text-muted); font-size: 15px; }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile menu toggle -->
    <button class="menu-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="logo-icon">ITP</div>
                <div>
                    <div class="logo-text">ITP System</div>
                    <div class="logo-sub">Mini LNG 36 TEU</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->isAdmin())
                <div class="nav-label">Admin Panel</div>
                <a href="/admin/dashboard" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="/admin/users" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Kelola User
                </a>
            @else
                <div class="nav-label">Navigation</div>
                <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->nama }}</div>
                    <div class="user-role">{{ auth()->user()->getRoleName() }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="main-content fade-in">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
