<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/opengen.jpg') }}">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 0 20px;
            padding-top: 70px;
        }

        .navbar {
            padding: 1rem 2rem;
            min-height: 70px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 500;
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
            padding: 0.8rem 1.2rem !important;
            font-size: 1rem;
        }

        .nav-link.active {
            color: white !important;
            font-weight: 500;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #fff;
        }

        .nav-link:hover {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Mobile Responsiveness */
        @media (max-width: 991px) {
            .navbar {
                padding: 0.8rem 1rem;
            }

            .navbar-collapse {
                background: #343a40;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 0.5rem;
            }

            .nav-link {
                padding: 0.8rem !important;
                border-radius: 0.25rem;
            }

            .nav-link.active::after {
                display: none;
            }

            .nav-link.active {
                background: rgba(255, 255, 255, 0.1);
            }

            .navbar-toggler {
                border: none;
                padding: 0.5rem;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }
        }

        /* Adjust body padding for new navbar height */
        body {
            padding-top: 90px;
        }

        .container {
            max-width: 1400px;
            padding: 0;
        }

        .stat-card {
            transition: transform 0.2s;
            height: 100%;
            min-height: 120px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .chart-container {
            position: relative;
            height: 250px;
            margin-bottom: 20px;
        }

        .table {
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            white-space: nowrap;
            padding: 12px 15px;
        }
        
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .badge {
            font-weight: 500;
            font-size: 0.8rem;
        }

        .text-nowrap {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .pagination {
            margin: 20px 0 0 0;
        }

        @media (max-width: 768px) {
            body {
                padding: 0 10px;
            }
            
            .container {
                padding: 0 5px;
            }
            
            .table {
                font-size: 0.75rem;
            }
            
            .table td, .table th {
                padding: 8px;
            }
        }

        /* Force scrollbar to always show to prevent layout shift */
        html {
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-chart-line me-2"></i>OpenGen Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.credits') ? 'active' : '' }}" href="{{ route('admin.credits') }}">
                            <i class="fas fa-coins"></i> Manage Credits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.chat-history') ? 'active' : '' }}" href="{{ route('admin.chat-history') }}">
                            <i class="fas fa-history"></i> Chat History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('chat.index') ? 'active' : '' }}" href="{{ route('chat.index') }}">
                            <i class="fas fa-comments"></i> Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="container mt-5">
        <!-- Stats Cards Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Total Users</h6>
                                <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Free Users</h6>
                                <h3 class="mb-0">{{ $stats['free_users'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-crown fa-2x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Premium Users</h6>
                                <h3 class="mb-0">{{ $stats['premium_users'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-dollar-sign fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Total Revenue</h6>
                                <h3 class="mb-0">${{ number_format($stats['total_income'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>User Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monthly Growth</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>All Users
                </h5>
                <span class="badge bg-primary">{{ $users->total() }} Total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px">Avatar</th>
                                <th style="width: 15%">Name</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Prompts</th>
                                <th style="width: 15%">Joined</th>
                                <th style="width: 15%">Subscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <img src="{{ $user->avatar 
                                            ? '/images/' . $user->avatar 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                             alt="Avatar" 
                                             class="rounded-circle"
                                             width="35" 
                                             height="35">
                                    </td>
                                    <td class="text-nowrap">
                                        {{ Str::limit($user->name, 20) }}
                                        @if($user->is_admin)
                                            <span class="badge bg-danger ms-1">Admin</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ Str::limit($user->email, 25) }}</td>
                                    <td>
                                        @if($user->is_premium)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-crown me-1"></i>Premium
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Free</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->prompts_remaining < 3 ? 'danger' : 'success' }}">
                                            {{ $user->prompts_remaining }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="text-nowrap">
                                        @if($user->subscription_expires_at)
                                            @if($user->subscription_expires_at->isPast())
                                                <span class="text-danger">Expired</span>
                                            @else
                                                {{ $user->subscription_expires_at->format('M d, Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center p-3 border-top">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Charts configuration code remains the same
        const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
        new Chart(userDistributionCtx, {
            type: 'pie',
            data: {
                labels: ['Free Users', 'Premium Users'],
                datasets: [{
                    data: [{{ $stats['free_users'] }}, {{ $stats['premium_users'] }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const monthlyGrowthCtx = document.getElementById('monthlyGrowthChart').getContext('2d');
        new Chart(monthlyGrowthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['monthly_labels']) !!},
                datasets: [{
                    label: 'Total Users',
                    data: {!! json_encode($stats['monthly_users']) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1,
                    fill: false
                }, {
                    label: 'Premium Users',
                    data: {!! json_encode($stats['monthly_premium_users']) !!},
                    borderColor: 'rgba(255, 206, 86, 1)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html> 