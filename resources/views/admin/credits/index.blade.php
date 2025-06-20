<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage User Credits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            min-width: 160px;
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

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .credit-input {
            width: 100px;
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

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Manage User Credits
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Current Credits</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="{{ $user->avatar 
                                            ? '/images/' . $user->avatar 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                             alt="Avatar" 
                                             class="rounded-circle me-2"
                                             width="35" 
                                             height="35">
                                        {{ $user->name }}
                                        @if($user->is_admin)
                                            <span class="badge bg-danger ms-1">Admin</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
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
                                        <span class="badge bg-{{ $user->prompts_remaining < 3 ? 'danger' : 'success' }} credits-display-{{ $user->id }}">
                                            {{ $user->prompts_remaining }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="number" 
                                                   class="form-control form-control-sm credit-input" 
                                                   value="{{ $user->prompts_remaining }}"
                                                   min="0"
                                                   id="credits-{{ $user->id }}">
                                            <button class="btn btn-primary btn-sm update-credits" 
                                                    data-user-id="{{ $user->id }}">
                                                Update
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center p-3 border-top">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.update-credits').forEach(button => {
            button.addEventListener('click', async function() {
                const userId = this.dataset.userId;
                const creditsInput = document.getElementById(`credits-${userId}`);
                const newCredits = creditsInput.value;

                try {
                    const response = await fetch(`/admin/credits/update/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            prompts: newCredits
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update the credits display
                        const displayElement = document.querySelector(`.credits-display-${userId}`);
                        displayElement.textContent = data.new_value;
                        displayElement.className = `badge bg-${data.new_value < 3 ? 'danger' : 'success'} credits-display-${userId}`;

                        // Show success alert
                        alert('Credits updated successfully');
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    alert('Failed to update credits');
                    console.error('Error:', error);
                }
            });
        });
    </script>
</body>
</html> 