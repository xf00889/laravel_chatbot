<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenGen AI - Advanced Conversational AI Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #10B981;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            min-height: 80vh;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIj48ZGVmcz48cGF0dGVybiBpZD0icGF0dGVybiIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cmVjdCB3aWR0aD0iMiIgaGVpZ2h0PSIyIiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==');
            opacity: 0.1;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
        }

        .feature-card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .ai-animation {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            animation: pulse 4s infinite;
            opacity: 0.2;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.2); opacity: 0.3; }
            100% { transform: scale(1); opacity: 0.2; }
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: glow 3s infinite;
        }

        @keyframes glow {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* Update login button hover styles */
        .login-btn {
            color: #fff !important;
            border: 2px solid #fff;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-color: #fff !important;
        }

        /* Team card styles */
        .team-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-avatar img {
            border: 3px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .team-card:hover .team-avatar img {
            transform: scale(1.05);
        }

        .social-links a {
            font-size: 1.2rem;
            transition: opacity 0.3s ease;
        }

        .social-links a:hover {
            opacity: 0.8;
        }

        .team-member {
            transition: transform 0.3s ease;
        }

        .team-img {
            width: 192px;  /* w-48 equivalent */
            height: 192px; /* h-48 equivalent */
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .team-tooltip {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            text-align: center;
        }

        .team-member:hover {
            transform: translateY(-5px);
        }

        .team-member:hover .team-tooltip {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .team-img {
                width: 150px;
                height: 150px;
            }
            
            .member-slider {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        @media (max-width: 991px) {  /* Mobile view */
            .navbar-nav .nav-item {
                margin: 5px 0;
            }
            
            .navbar-nav .btn {
                display: block;
                margin: 8px 0;
                width: 100%;
            }

            .login-btn {
                margin-bottom: 10px !important;
            }
        }

        @media (min-width: 992px) {  /* Web view */
            .navbar-nav .nav-item .btn {
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .me-lg-2 {
                margin-right: 15px !important;
            }
        }

        /* Floating animation for the main image */
        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Floating elements styling */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .floating-dot {
            position: absolute;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: floatingDot 4s ease-in-out infinite;
        }

        .floating-circle {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: floatingCircle 5s ease-in-out infinite;
        }

        @keyframes floatingDot {
            0% { transform: translate(0, 0); opacity: 0.5; }
            50% { transform: translate(10px, -10px); opacity: 1; }
            100% { transform: translate(0, 0); opacity: 0.5; }
        }

        @keyframes floatingCircle {
            0% { transform: scale(1) rotate(0deg); opacity: 0.3; }
            50% { transform: scale(1.2) rotate(180deg); opacity: 0.6; }
            100% { transform: scale(1) rotate(360deg); opacity: 0.3; }
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .hero-section {
                text-align: center;
                padding: 6rem 0 3rem; /* Increased top padding to account for fixed navbar */
                min-height: auto;
            }
            
            .hero-section .display-4 {
                font-size: 2.5rem; /* Smaller heading on mobile */
            }
            
            .hero-section .lead {
                font-size: 1.1rem; /* Smaller paragraph on mobile */
            }
            
            .hero-section img {
                max-width: 60% !important; /* Smaller image on mobile */
                margin: 2rem auto !important; /* Center image with margin */
            }
            
            .floating-elements {
                display: none; /* Hide floating elements on mobile for better performance */
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem; /* Slightly smaller buttons on mobile */
                font-size: 1rem;
            }
        }

        /* Additional breakpoint for very small devices */
        @media (max-width: 576px) {
            .hero-section {
                padding: 5rem 0 2rem;
            }
            
            .hero-section .display-4 {
                font-size: 2rem;
            }
            
            .hero-section img {
                max-width: 80% !important;
            }
            
            .hero-section .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }
        }

        /* Ensure the image maintains aspect ratio */
        .hero-section img {
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        /* Optimize floating animation for mobile */
        @media (max-width: 991px) {
            .floating-animation {
                animation: floatingMobile 2s ease-in-out infinite;
            }

            @keyframes floatingMobile {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/opengen.jpg') }}" alt="OpenGen Logo" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <span class="fw-bold">OpenGen AI</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('chat.index') }}">Go to Chat</a>
                        </li>
                    @else
                        <li class="nav-item me-lg-2 mb-2 mb-lg-0">  <!-- Added margin end for web view -->
                            <a class="btn btn-outline-light ms-2 login-btn w-100" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2 w-100" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white d-flex align-items-center">
        <div class="ai-animation"></div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0"> <!-- Added margin bottom for mobile -->
                    <h1 class="display-4 fw-bold mb-4">Experience Next-Gen AI Conversations</h1>
                    <p class="lead mb-4">Unlock the power of advanced AI with OpenGen. Engage in meaningful conversations, get instant answers, and explore endless possibilities.</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start"> <!-- Center buttons on mobile -->
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-glow">Get Started</a>
                        <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 d-block"> <!-- Changed from d-none d-lg-block to d-block -->
                    <div class="position-relative text-center text-lg-start"> <!-- Added text-center for mobile -->
                        <img src="{{ asset('images/opengenwall.png') }}" 
                             alt="AI Chat Illustration" 
                             class="img-fluid floating-animation"
                             style="max-width: 80%; height: auto; margin: 0 auto;"> <!-- Added margin auto for centering -->
                        <div class="floating-elements">
                            <div class="floating-dot" style="top: 20%; left: 10%;"></div>
                            <div class="floating-dot" style="top: 60%; left: 80%;"></div>
                            <div class="floating-dot" style="top: 80%; left: 30%;"></div>
                            <div class="floating-circle" style="top: 30%; right: 20%;"></div>
                            <div class="floating-circle" style="top: 70%; left: 20%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Powerful AI Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-brain fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Advanced AI</h5>
                            <p class="card-text">Powered by state-of-the-art language models for natural conversations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-bolt fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Real-time Responses</h5>
                            <p class="card-text">Get instant, accurate responses to your questions and prompts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Secure & Private</h5>
                            <p class="card-text">Your conversations are protected with enterprise-grade security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5">Meet Our Team</h2>
            <div class="row justify-content-center">
                <div class="member-slider d-flex flex-wrap justify-content-center gap-4">
                    <!-- Team Member 1 -->
                    <div class="team-member position-relative">
                        <img src="{{ asset('images/M1.jpg') }}" alt="Member 1" class="rounded-circle team-img">
                        <div class="team-tooltip">
                            Back-End Programmer - Juby Neil Cisneros Valiao
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="team-member position-relative">
                        <img src="{{ asset('images/BOSS2.jpg') }}" alt="Member 2" class="rounded-circle team-img">
                        <div class="team-tooltip">
                            Front-End Programmer - John Kenneth Bayadog Salgado
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="team-member position-relative">
                        <img src="{{ asset('images/BOSS3.jpg') }}" alt="Member 3" class="rounded-circle team-img">
                        <div class="team-tooltip">
                            Graphic Designer - RossVan T. Baling
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="team-member position-relative">
                        <img src="{{ asset('images/m16.jpg') }}" alt="Member 4" class="rounded-circle team-img">
                        <div class="team-tooltip">
                            Product Designer - Daryl Lloyd Tano
                        </div>
                    </div>

                    <!-- Team Member 5 -->
                    <div class="team-member position-relative">
                        <img src="{{ asset('images/m10.jpg') }}" alt="Member 5" class="rounded-circle team-img">
                        <div class="team-tooltip">
                            UI/UX Specialist - Nick Justin Diacamos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Experience the Future?</h2>
            <p class="lead mb-4">Join thousands of users already benefiting from OpenGen AI.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-glow">Start Free Trial</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>OpenGen AI</h5>
                    <p>Advanced Conversational AI Platform</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>