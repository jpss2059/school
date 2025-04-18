<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Result Management System') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #343a40;
            color: #fff;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main-content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-weight: 600;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }
        .table th {
            background-color: #f8f9fa;
        }
    </style>
    @yield('styles')
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">
            JP SECONDARY SCHOOL
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <span class="nav-link px-3">User: {{ auth()->user()->name ?? 'Admin' }} | Today's: {{ date('Y/m/d') }} | F/Year: {{ date('Y') }}</span>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                                <i class="bi bi-people me-2"></i> Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('examinations.*') ? 'active' : '' }}" href="{{ route('examinations.index') }}">
                                <i class="bi bi-calendar-check me-2"></i> Examinations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marks.*') ? 'active' : '' }}" href="{{ route('marks.index') }}">
                                <i class="bi bi-pencil-square me-2"></i> Marks Entry
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#reportsCollapse" role="button" aria-expanded="false" aria-controls="reportsCollapse">
                                <i class="bi bi-file-earmark-text me-2"></i> Reports <i class="bi bi-chevron-down float-end"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsCollapse">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('reports.progress-card') ? 'active' : '' }}" href="{{ route('reports.progress-card') }}">
                                            <i class="bi bi-card-checklist me-2"></i> Progress Report Card
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('reports.marks-ledger') ? 'active' : '' }}" href="{{ route('reports.marks-ledger') }}">
                                            <i class="bi bi-journal-text me-2"></i> Marks Ledger
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('reports.marks-analysis') ? 'active' : '' }}" href="{{ route('reports.marks-analysis') }}">
                                            <i class="bi bi-bar-chart me-2"></i> Marks Analysis
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('reports.subject-printing') ? 'active' : '' }}" href="{{ route('reports.subject-printing') }}">
                                            <i class="bi bi-printer me-2"></i> Subject Printing
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#settingsCollapse" role="button" aria-expanded="false" aria-controls="settingsCollapse">
                                <i class="bi bi-gear me-2"></i> Settings <i class="bi bi-chevron-down float-end"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('settings.*') ? 'show' : '' }}" id="settingsCollapse">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.academic-year') ? 'active' : '' }}" href="{{ route('settings.academic-year') }}">
                                            <i class="bi bi-calendar me-2"></i> Academic Year
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.examination') ? 'active' : '' }}" href="{{ route('settings.examination') }}">
                                            <i class="bi bi-calendar-check me-2"></i> Examination
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.subject') ? 'active' : '' }}" href="{{ route('settings.subject') }}">
                                            <i class="bi bi-book me-2"></i> Subject/Cr/Hour
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.percent-other') ? 'active' : '' }}" href="{{ route('settings.percent-other') }}">
                                            <i class="bi bi-percent me-2"></i> Percent/Other
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.remarks') ? 'active' : '' }}" href="{{ route('settings.remarks') }}">
                                            <i class="bi bi-chat-square-text me-2"></i> Remarks
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.consider') ? 'active' : '' }}" href="{{ route('settings.consider') }}">
                                            <i class="bi bi-check-square me-2"></i> Consider
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.extra-activities') ? 'active' : '' }}" href="{{ route('settings.extra-activities') }}">
                                            <i class="bi bi-activity me-2"></i> Extra Activities
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('settings.marks-convert') ? 'active' : '' }}" href="{{ route('settings.marks-convert') }}">
                                            <i class="bi bi-arrow-left-right me-2"></i> Marks Convert
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @yield('scripts')
</body>
</html>
