<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade to Premium</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .payment-button {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .paypal-button {
            background-color: #0070ba;
            color: white;
            border: none;
        }
        .paypal-button:hover {
            background-color: #005ea6;
            color: white;
        }
        .stripe-button {
            background-color: #635bff;
            color: white;
            border: none;
        }
        .stripe-button:hover {
            background-color: #4b44eb;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">
                            <i class="fas fa-crown text-warning me-2"></i>Upgrade to Premium
                        </h2>

                        <div class="pricing-details text-center mb-4">
                            <h1 class="display-4 mb-3">$9.99</h1>
                            <p class="lead mb-4">Monthly Premium Subscription</p>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    100 Prompts Daily
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Priority Support
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Advanced Features
                                </li>
                            </ul>
                        </div>

                        <div class="payment-methods">
                            <!-- PayPal Button -->
                            <form action="{{ route('subscription.paypal.create') }}" method="POST">
                                @csrf
                                <button type="submit" class="payment-button paypal-button">
                                    <i class="fab fa-paypal"></i>
                                    Pay with PayPal
                                </button>
                            </form>

                            <!-- Stripe Button -->
                            <button id="stripe-button" class="payment-button stripe-button">
                                <i class="fab fa-stripe"></i>
                                Pay with Stripe
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const stripeButton = document.getElementById('stripe-button');

        stripeButton.addEventListener('click', async () => {
            try {
                const response = await fetch('{{ route('subscription.stripe.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Redirect to Stripe Checkout
                const result = await stripe.redirectToCheckout({
                    sessionId: data.id
                });

                if (result.error) {
                    alert(result.error.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        });
    </script>
</body>
</html> 