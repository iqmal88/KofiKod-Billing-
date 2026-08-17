<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'KAK Office')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font (Outfit is highly modern and elegant) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #FBFBFA;
            --sidebar-bg: #1E291B; /* Deep Elegant Forest Green */
            --sidebar-hover: #2D3E29;
            --accent-brown: #8C6D53; /* Soft Earth/Warm Brown */
            --text-dark: #2C302E;
        }

        body {
            margin: 0;
            background: var(--bg-main);
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
        }

        /* Desktop Sidebar Structure */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: #F4F6F4;
            overflow-y: auto;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-header p {
            margin: 0;
            color: var(--accent-brown);
            font-size: 13px;
            font-weight: 500;
        }

        .sidebar .nav-link, .offcanvas .nav-link {
            color: #D1D7D1;
            padding: 12px 20px;
            margin: 4px 16px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar .nav-link:hover, .offcanvas .nav-link:hover {
            background: var(--sidebar-hover);
            color: #FFF;
        }

        .sidebar .nav-link.active, .offcanvas .nav-link.active {
            background: var(--accent-brown);
            color: #FFF;
        }

        .sidebar i, .offcanvas i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .topbar {
            background: #FFF;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #ECEBE9;
        }

        .page-content {
            padding: 30px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent-brown);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        /* Toast / Alert Customization */
        .alert-success {
            background-color: #EBF5EC;
            border-color: #D1E7DD;
            color: #21512A;
            border-radius: 10px;
        }

        /* Mobile Layout Breakpoints */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .topbar {
                padding: 0 20px;
            }
            .page-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Mobile Offcanvas Navigation Menu (Drawer) -->
    <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="mobileSidebar" style="background: var(--sidebar-bg); width: 260px;">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <div>
                <h4>KAK Office</h4>
                <p>Business Management</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-0 py-3">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('company-settings.index') }}" class="nav-link {{ request()->routeIs('company-settings.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Company
            </a>
            <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Clients
            </a>
            <a href="{{ route('quotations.index') }}" class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Quotations
            </a>
            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Invoices
            </a>
            <a href="{{ route('receipts.index') }}" class="nav-link {{ request()->routeIs('receipts.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Receipts
            </a>
            <a href="{{ route('change-requests.index') }}" class="nav-link {{ request()->routeIs('change-requests.*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Change Requests
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </div>
    </div>

    <!-- Desktop Sidebar Menu -->
    <div class="sidebar d-none d-lg-block">
        <div class="sidebar-header">
            <h4>KAK Office</h4>
            <p>Business Management</p>
        </div>
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('company-settings.index') }}" class="nav-link {{ request()->routeIs('company-settings.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Company
            </a>
            <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Clients
            </a>
            <a href="{{ route('quotations.index') }}" class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Quotations
            </a>
            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Invoices
            </a>
            <a href="{{ route('receipts.index') }}" class="nav-link {{ request()->routeIs('receipts.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Receipts
            </a>
            <a href="{{ route('change-requests.index') }}" class="nav-link {{ request()->routeIs('change-requests.*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Change Requests
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </div>
    </div>

    <!-- Main Content Frame Window -->
    <div class="main-content">
        <div class="topbar">
            <!-- Left Side: Mobile Menu Button & Title -->
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-3 border" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="mb-0 fw-bold d-none d-sm-block text-dark">
                    @yield('title', 'Dashboard')
                </h5>
            </div>

            <!-- Right Side: User Dropdown Option -->
            <div class="dropdown">
                <button class="btn btn-white border-0 d-flex align-items-center bg-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar me-2 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline text-secondary fw-medium fs-7">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2 py-2">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2 text-muted"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger py-2" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Inner Application Target Content Window -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>