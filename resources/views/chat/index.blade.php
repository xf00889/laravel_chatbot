<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Chat with OpenGen</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="icon" type="image/jpeg" href="{{ asset('images/opengen.jpg') }}">
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
    }

    .chat-container {
        height: 100vh;
        display: flex;
    }

    .sidebar {
        width: 300px;
        background: #ffffff;
        color: #333333;
        border-right: 1px solid #dee2e6;
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        position: relative;
    }

    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f8f9fa;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 2rem;
    }

    .message {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        max-width: 80%;
        align-items: flex-start;
        position: relative;
    }

    .user-message {
        margin-left: auto;
        flex-direction: row-reverse;
    }

    .message-content {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .message-bubble {
        padding: 1rem 1.25rem;
        border-radius: 15px;
        background: #fff;
        word-wrap: break-word;
        width: auto;
        max-width: 100%;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .user-message .message-bubble {
        background: #007bff;
        color: white;
        margin-left: auto;
    }

    .bot-message .message-bubble {
        background: #fff;
        color: #2c3e50;
        margin-right: auto;
    }

    .message-sender {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
        color: #6c757d;
        text-align: left;
    }

    .user-message .message-sender {
        text-align: right;
    }

    .bot-message .message-sender {
        text-align: left;
    }

    .input-area {
        padding: 1.5rem;
        background: #fff;
        border-top: 1px solid #dee2e6;
    }

    .input-area .position-relative {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
    }

    .input-area textarea {
        flex: 1;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1rem;
        font-size: 0.95rem;
        resize: none;
        margin-bottom: 0;
    }

    .input-area .btn-primary {
        height: 45px;
        width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .profile-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f3f5;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .bot-message .user-avatar {
        border-color: #e9ecef;
    }

    .user-message .user-avatar {
        border-color: #007bff;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            left: -300px;
            top: 0;
            bottom: 0;
            width: 85%;
            max-width: 300px;
            z-index: 1050;
            transition: all 0.3s ease;
            background: #fff;
            padding-top: 20px;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            margin-left: 0;
            padding-left: 70px;
        }

        .sidebar.active + .main-content #sidebar-toggle {
            left: auto;
        }

        #sidebar-toggle.active {
            left: auto;
        }

        .sidebar {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .sidebar h3 {
            padding: 0 20px;
            margin-top: 10px;
        }

        .message {
            max-width: 95%;
            gap: 0.5rem;
        }

        .message-content {
            max-width: calc(100% - 45px);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
        }

        .message-bubble {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .code-block {
            margin: 0.25rem 0;
            font-size: 0.85rem;
        }

        .code-header {
            padding: 6px 10px;
            font-size: 0.8rem;
        }

        .code-block pre {
            padding: 0.75rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .copy-button {
            padding: 2px 6px;
            font-size: 0.75rem;
        }

        .chat-messages {
            padding: 1rem;
        }

        .input-area {
            padding: 1rem;
        }

        .input-area textarea {
            padding: 0.75rem;
            font-size: 0.9rem;
        }
    }

    /* Hide toggle button on larger screens */
    @media (min-width: 769px) {
        #sidebar-toggle {
            display: none;
        }
    }

    .profile-card .text-muted {
        color: #6c757d !important;
    }

    .btn-outline-light {
        color: #333333;
        border-color: #dee2e6;
    }

    .btn-outline-light:hover {
        background-color: #f8f9fa;
        color: #007bff;
        border-color: #007bff;
    }

    .border-secondary {
        border-color: #dee2e6 !important;
    }

    .prompts-counter {
        background: #ffffff;
        color: #333333;
        border: 1px solid #dee2e6;
    }

    .low-prompts {
        color: #dc3545;
        background: rgba(220, 53, 69, 0.1);
    }

    .sidebar .btn-outline-light {
        color: #007bff;
        border-color: #007bff;
    }

    .sidebar .btn-outline-light:hover {
        background: #007bff;
        color: #ffffff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: #ffffff;
    }

    .typing-indicator {
        display: none;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
        padding: 8px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        width: fit-content;
    }

    .typing-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #666;
        animation: typingDot 1.4s infinite;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typingDot {
        0%, 100% { opacity: 0.7; }
        50% { opacity: 0.2; }
    }

    .message-bubble .typing-dots {
        margin: 0;
        min-width: 0;
    }

    .typing-indicator .message-bubble {
        padding: 0.5rem 1rem;
    }

    .typing-indicator .message-content {
        width: auto;
    }

    .subscription-status {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
    }

    .premium-badge {
        color: #ffd700;
        font-weight: 500;
        text-align: center;
        margin-bottom: 5px;
    }

    .sidebar-buttons {
        padding: 0 1rem;
    }

    #delete-history {
        transition: all 0.3s ease;
        background-color: #dc3545;
        border: none;
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    #delete-history:hover {
        background-color: #bb2d3b;
        transform: translateY(-1px);
    }

    #delete-history:active {
        transform: translateY(1px);
    }

    #sidebar-toggle {
        position: fixed;
        top: 15px;
        left: 15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #343a40;
        border: 2px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 1050;
    }

    @media (max-width: 768px) {
        #sidebar-toggle {
            display: flex !important; /* Force display on mobile */
        }

        .sidebar {
            position: fixed;
            left: -300px;
            top: 0;
            bottom: 0;
            width: 300px;
            z-index: 1050;
            transition: all 0.3s ease;
            background: #fff;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            margin-left: 0;
            padding-left: 70px;
        }

        /* Move toggle button when sidebar is active */
        .sidebar.active ~ .main-content #sidebar-toggle {
            left: 315px;
        }
    }

    #sidebar-toggle:hover {
        background-color: #4a4f55;
        transform: scale(1.05);
    }

    #sidebar-toggle:active {
        transform: scale(0.95);
    }

    #sidebar-toggle i {
        color: white;
        font-size: 1.2rem;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1045;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.active {
        display: block;
        opacity: 1;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        position: relative;
    }

    .code-block {
        background: #2d2d2d;
        border-radius: 8px;
        margin: 0.5rem 0;
        overflow: hidden;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .code-header {
        background: #1e1e1e;
        color: #e0e0e0;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-family: monospace;
        border-bottom: 1px solid #3d3d3d;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .code-block pre {
        margin: 0;
        padding: 1rem;
        color: #ffffff;
        overflow-x: auto;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .code-block code {
        font-family: 'Consolas', 'Monaco', monospace;
        font-size: 0.9rem;
    }

    .copy-button {
        background: transparent;
        border: none;
        color: #e0e0e0;
        cursor: pointer;
        padding: 4px 8px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }

    .copy-button:hover {
        color: #fff;
    }

    .copy-button i {
        font-size: 0.9rem;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .message {
            max-width: 95%;
        }

        .message-bubble {
            padding: 0.875rem 1rem;
            font-size: 0.9rem;
        }

        .code-block {
            font-size: 0.85rem;
        }

        .code-header {
            padding: 6px 10px;
            font-size: 0.8rem;
        }

        .code-block pre {
            padding: 0.875rem;
        }

        .copy-button {
            padding: 3px 6px;
            font-size: 0.75rem;
        }

        .user-avatar img {
            width: 30px;
            height: 30px;
        }

        .message-sender {
            font-size: 0.8rem;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .message {
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .message-bubble {
            padding: 0.75rem 0.875rem;
            font-size: 0.85rem;
        }

        .code-block code {
            font-size: 0.8rem;
        }

        .gap-2 {
            gap: 0.375rem !important;
        }
    }
</style>
</head>
<body>
    <div class="chat-container">
        <button id="sidebar-toggle" class="d-md-none">
            <i class="fas fa-bars"></i>
        </button>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3 class="mb-0">OpenGen Chat</h3>
            </div>
            
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="user-avatar">
                        @if(auth()->user()->avatar)
                            <img src="/images/{{ auth()->user()->avatar }}" alt="User Avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" alt="User Avatar">
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                </div>
                <div class="small text-muted">
                    <div>Member since: {{ auth()->user()->created_at->format('M Y') }}</div>
                    <div>Messages: {{ auth()->user()->chatMessages()->count() }}</div>
                    <div class="prompts-counter {{ auth()->user()->prompts_remaining < 3 ? 'low-prompts' : '' }}">
                        Prompts remaining: {{ auth()->user()->prompts_remaining }}
                    </div>
                    
                    @if(auth()->user()->is_premium)
                        <div class="subscription-status mt-2">
                            <div class="premium-badge">
                                <i class="fas fa-crown me-1"></i> Premium Member
                            </div>
                            <div class="small mt-1">
                                @if(auth()->user()->subscription_expires_at)
                                    <div class="text-success">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ auth()->user()->subscription_expires_at->diffForHumans(['parts' => 2]) }} remaining
                                    </div>
                                    <div class="text-muted">
                                        Expires: {{ auth()->user()->subscription_expires_at->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <button type="button" 
                                class="btn btn-warning btn-sm w-100 mt-3" 
                                data-bs-toggle="modal" 
                                data-bs-target="#upgradeModal">
                            <i class="fas fa-crown me-1"></i> Upgrade to Premium
                        </button>
                    @endif
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm w-100 mt-2">
                    <i class="fas fa-user-edit me-1"></i> Edit Profile
                </a>

                <!-- Add the Admin Dashboard button only for admin users -->
                @if(auth()->user()->is_admin)
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark btn-sm w-100 mt-2">
                        <i class="fas fa-chart-line me-1"></i> Admin Dashboard
                    </a>
                @endif
            </div>

            <!-- Move the delete button from its current location to just above the logout button -->
            <div class="mt-auto">
                <hr class="border-secondary">
                <button id="delete-history" class="btn btn-danger w-100 mb-2 d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-trash-alt"></i>
                    Clear Chat History
                </button>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="btn btn-outline-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <div class="main-content">
            <div class="chat-messages" id="chat-messages">
                @foreach($messages as $conversationId => $conversationMessages)
                    @foreach($conversationMessages as $message)
                        <div class="message user-message">
                            <div class="user-avatar">
                                @if(auth()->user()->avatar)
                                    <img src="/images/{{ auth()->user()->avatar }}" alt="User Avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" alt="User Avatar">
                                @endif
                            </div>
                            <div class="message-content">
                                <div class="message-sender">You</div>
                                <div class="message-bubble">{{ $message->message }}</div>
                            </div>
                        </div>
                        <div class="message bot-message">
                            <div class="user-avatar">
                                <img src="{{ asset('images/opengen.jpg') }}" alt="OpenGen Avatar">
                            </div>
                            <div class="message-content">
                                <div class="message-sender">OpenGen</div>
                                <div class="message-bubble">
                                    @php
                                        $pattern = '/```([a-zA-Z]*)\n([\s\S]*?)```/';
                                        $response = $message->response;
                                        $parts = preg_split($pattern, $response, -1, PREG_SPLIT_DELIM_CAPTURE);
                                        
                                        for ($i = 0; $i < count($parts); $i++) {
                                            if ($i % 3 == 0) {
                                                // Regular text
                                                echo nl2br(e($parts[$i]));
                                            } elseif ($i % 3 == 1) {
                                                // Language identifier
                                                $language = $parts[$i];
                                                $uniqueId = 'code-' . uniqid();
                                                echo '<div class="code-block">';
                                                echo '<div class="code-header">';
                                                echo '<span>' . e($language ?: 'plaintext') . '</span>';
                                                echo '<button class="copy-button" onclick="copyCode(\'' . $uniqueId . '\')">';
                                                echo '<i class="fas fa-copy"></i><span>Copy</span>';
                                                echo '</button>';
                                                echo '</div>';
                                            } else {
                                                // Code block
                                                echo '<pre><code id="' . $uniqueId . '">' . e($parts[$i]) . '</code></pre>';
                                                echo '</div>';
                                            }
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <div class="typing-indicator" id="typing-indicator">
                    <div class="message bot-message">
                        <div class="user-avatar">
                            <img src="{{ asset('images/opengen.jpg') }}" alt="OpenGen Avatar">
                        </div>
                        <div class="message-content">
                            <div class="message-sender">OpenGen</div>
                            <div class="typing-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="input-area">
                <form id="chat-form" class="container-fluid">
                    <div class="position-relative">
                        <textarea id="message" class="form-control" rows="2" placeholder="Message OpenGen..."></textarea>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay"></div>

    <!-- Upgrade Modal -->
    <div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upgradeModalLabel">
                        <i class="fas fa-crown text-warning me-2"></i>Upgrade to Premium
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="display-6 mb-3">$9.99/month</h3>
                        <p class="lead">Unlock Premium Features!</p>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-0">100 Prompts Daily</h5>
                                    <small class="text-muted">Instead of just 10 prompts</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-0">Priority Support</h5>
                                    <small class="text-muted">Get help when you need it</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-0">Advanced Features</h5>
                                    <small class="text-muted">Access to premium features</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <a href="{{ route('subscription.index') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fab fa-paypal me-2"></i>Upgrade Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message');
    const messagesDiv = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    let currentConversationId = null;

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        // Disable form and show typing indicator
        form.classList.add('opacity-50');
        input.disabled = true;
        typingIndicator.style.display = 'block';
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    message,
                    conversation_id: currentConversationId 
                })
            });

            const data = await response.json();

            if (data.success) {
                // Set the conversation ID for future messages
                currentConversationId = data.message.conversation_id;
                
                // Add messages to chat
                addMessage('You', data.message.message, 'user');
                addMessage('OpenGen', data.message.response, 'bot');
                
                // Update prompts counter
                const promptsCounter = document.querySelector('.prompts-counter');
                promptsCounter.textContent = `Prompts remaining: ${data.prompts_remaining}`;
                
                if (data.prompts_remaining < 3) {
                    promptsCounter.classList.add('low-prompts');
                }

                // Clear input
                input.value = '';
                input.style.height = 'auto';
            } else {
                if (data.error === 'no_prompts') {
                    const upgradeModal = new bootstrap.Modal(document.getElementById('upgradeModal'));
                    upgradeModal.show();
                } else {
                    addMessage('System', data.message, 'error');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            const errorMessage = error.response?.data?.message || 'An error occurred while sending the message.';
            addMessage('System', `Error: ${errorMessage}`, 'error');
        } finally {
            form.classList.remove('opacity-50');
            input.disabled = false;
            typingIndicator.style.display = 'none';
            input.focus();
        }
    });

    function addMessage(sender, content, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        
        const avatarSrc = type === 'user' 
            ? '{{ auth()->user()->avatar 
                ? "/images/" . auth()->user()->avatar 
                : "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) }}'
            : '{{ asset("images/opengen.jpg") }}';
        
        // Parse code blocks in the content
        let formattedContent = content;
        if (type === 'bot') {
            const codeBlockRegex = /```([a-zA-Z]*)\n([\s\S]*?)```/g;
            let lastIndex = 0;
            let parts = [];
            let match;

            while ((match = codeBlockRegex.exec(content)) !== null) {
                // Add text before code block
                if (match.index > lastIndex) {
                    parts.push(content.substring(lastIndex, match.index));
                }

                // Generate unique ID for this code block
                const uniqueId = 'code-' + Math.random().toString(36).substr(2, 9);
                const language = match[1] || 'plaintext';
                const code = match[2];

                // Create code block HTML
                const codeBlockHtml = `
                    <div class="code-block">
                        <div class="code-header">
                            <span>${language}</span>
                            <button class="copy-button" onclick="copyCode('${uniqueId}')">
                                <i class="fas fa-copy"></i>
                                <span>Copy</span>
                            </button>
                        </div>
                        <pre><code id="${uniqueId}">${code.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</code></pre>
                    </div>
                `;
                parts.push(codeBlockHtml);

                lastIndex = codeBlockRegex.lastIndex;
            }

            // Add remaining text after last code block
            if (lastIndex < content.length) {
                parts.push(content.substring(lastIndex));
            }

            formattedContent = parts.join('').replace(/\n/g, '<br>');
        }

        messageDiv.innerHTML = `
            <div class="user-avatar">
                <img src="${avatarSrc}" alt="${type === 'user' ? 'User' : 'OpenGen'} Avatar" 
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${type === 'user' ? '{{ urlencode(auth()->user()->name) }}' : 'OpenGen'}';">
            </div>
            <div class="message-content">
                <div class="message-sender">${sender}</div>
                <div class="message-bubble">${formattedContent}</div>
            </div>
        `;
        
        // Insert message before typing indicator
        typingIndicator.insertAdjacentElement('beforebegin', messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        // Initialize copy buttons for new message
        messageDiv.querySelectorAll('.copy-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const codeId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
                copyCode(codeId);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const mainContent = document.querySelector('.main-content');
        
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            sidebarToggle.classList.toggle('active');
            
            // Toggle body scroll
            if (window.innerWidth <= 768) {
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking a link
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Close sidebar when pressing escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                toggleSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                sidebarToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Add delete history functionality
    document.getElementById('delete-history').addEventListener('click', async function() {
        if (!confirm('Are you sure you want to delete all chat history? This action cannot be undone.')) {
            return;
        }

        try {
            const response = await fetch('/chat/delete-history', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                // Clear the messages div but keep the typing indicator
                const typingIndicator = document.getElementById('typing-indicator');
                messagesDiv.innerHTML = '';
                messagesDiv.appendChild(typingIndicator);
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                messagesDiv.insertBefore(alert, typingIndicator);

                // Auto dismiss the alert after 3 seconds
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150); // Remove after fade animation
                }, 3000);
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show';
            alert.innerHTML = `
                <i class="fas fa-exclamation-circle me-2"></i>Failed to delete chat history
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            messagesDiv.insertBefore(alert, document.getElementById('typing-indicator'));

            // Auto dismiss the error alert after 3 seconds
            setTimeout(() => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }, 3000);
        }
    });

    // Add copy functionality
    function copyCode(elementId) {
        const codeElement = document.getElementById(elementId);
        if (!codeElement) return;
        
        const text = codeElement.textContent;
        
        navigator.clipboard.writeText(text).then(() => {
            const button = codeElement.closest('.code-block').querySelector('.copy-button');
            const icon = button.querySelector('i');
            const span = button.querySelector('span');
            
            // Change to check icon and text temporarily
            icon.className = 'fas fa-check';
            span.textContent = 'Copied!';
            button.style.color = '#4CAF50';
            
            // Revert back after 2 seconds
            setTimeout(() => {
                icon.className = 'fas fa-copy';
                span.textContent = 'Copy';
                button.style.color = '';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Failed to copy code to clipboard');
        });
    }
    </script>
</body>
</html>