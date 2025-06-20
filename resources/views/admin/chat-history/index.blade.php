<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat History - OpenGen Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/opengen.jpg') }}">
    <style>
        /* Force scrollbar to always show to prevent layout shift */
        html {
            overflow-y: scroll;
        }

        body {
            background-color: #f8f9fa;
            padding: 0 20px;
            padding-top: 90px;
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

        .container {
            max-width: 1400px;
            padding: 0;
        }

        .chat-message {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .message-content {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .response-content {
            background: #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .timestamp {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

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

            .nav-link.active::after {
                display: none;
            }

            .nav-link.active {
                background: rgba(255, 255, 255, 0.1);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="user_id" class="form-label">Filter by User</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Chat History -->
        @foreach($chatHistory as $chat)
            <div class="chat-message">
                <div class="user-info">
                    <img src="{{ $chat->user->avatar 
                        ? '/images/' . $chat->user->avatar 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($chat->user->name) }}" 
                         class="user-avatar" 
                         alt="User Avatar">
                    <div>
                        <h6 class="mb-0">{{ $chat->user->name }}</h6>
                        <small class="text-muted">{{ $chat->user->email }}</small>
                    </div>
                    <div class="ms-auto timestamp">
                        {{ $chat->created_at->format('M d, Y H:i') }}
                    </div>
                </div>
                <div class="message-content">
                    <strong>User Message:</strong>
                    <p class="mb-0">{{ $chat->message }}</p>
                </div>
                <div class="response-content">
                    <strong>AI Response:</strong>
                    <p class="mb-0">{{ $chat->response }}</p>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $chatHistory->withQueryString()->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 