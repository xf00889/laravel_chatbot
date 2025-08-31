# OpenGen AI Chatbot

<p align="center">
  <img src="public/images/opengen.jpg" alt="OpenGen Logo" width="200">
</p>

<p align="center">
  <strong>A powerful AI chatbot application built with Laravel and OpenAI GPT-3.5 Turbo</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.1+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/OpenAI-GPT--3.5--Turbo-green.svg" alt="OpenAI Model">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License">
</p>

## About OpenGen

OpenGen is an intelligent AI chatbot application that provides users with conversational AI capabilities powered by OpenAI's GPT-3.5 Turbo model. The application features a modern web interface, user authentication, subscription management, and integrated payment processing.

### Key Features

- **🤖 AI-Powered Conversations**: Leverages OpenAI GPT-3.5 Turbo for intelligent responses
- **💬 Conversation History**: Maintains context across chat sessions
- **👤 User Authentication**: Secure user registration and login system
- **💳 Subscription Management**: Tiered access with free and premium plans
- **💰 Payment Integration**: Support for both PayPal and Stripe payments
- **📱 Responsive Design**: Modern, mobile-friendly interface
- **🔒 Secure**: Built with Laravel's security best practices

### Subscription Plans

- **Free Plan**: 10 prompts per day
- **Premium Plan**: 100 prompts per day ($9.99/month)

## Technology Stack

- **Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend**: Blade templates with Bootstrap CSS
- **Database**: MySQL/PostgreSQL (configurable)
- **AI Service**: OpenAI GPT-3.5 Turbo API
- **Payment Processing**:
  - PayPal (via srmklive/paypal)
  - Stripe (via stripe/stripe-php)
- **Authentication**: Laravel Breeze
- **Testing**: PHPUnit

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL database
- OpenAI API key
- PayPal Developer Account (optional)
- Stripe Account (optional)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/xf00889/laravel_chatbot
   cd chatbot_project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure environment variables**
   Edit `.env` file with your settings:
   ```env
   # Database
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   # OpenAI API
   OPENAI_API_KEY=your_openai_api_key

   # PayPal (optional)
   PAYPAL_MODE=sandbox
   PAYPAL_SANDBOX_CLIENT_ID=your_paypal_client_id
   PAYPAL_SANDBOX_CLIENT_SECRET=your_paypal_client_secret

   # Stripe (optional)
   STRIPE_KEY=your_stripe_publishable_key
   STRIPE_SECRET=your_stripe_secret_key
   ```

6. **Database setup**
   ```bash
   php artisan migrate
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Configuration

### OpenAI Setup

1. Create an account at [OpenAI](https://platform.openai.com/)
2. Generate an API key from the API section
3. Add the key to your `.env` file as `OPENAI_API_KEY`

### Payment Gateway Setup

#### PayPal Configuration
1. Create a PayPal Developer account
2. Create a new application in the PayPal Developer Dashboard
3. Add your credentials to the `.env` file

#### Stripe Configuration
1. Create a Stripe account
2. Get your API keys from the Stripe Dashboard
3. Add your credentials to the `.env` file

## Usage

1. **User Registration**: Users can create accounts through the registration page
2. **Chat Interface**: Authenticated users can access the chat interface
3. **Conversations**: Users can have multiple conversation threads
4. **Subscription**: Users can upgrade to premium for more prompts
5. **Payment**: Secure payment processing through PayPal or Stripe

## API Endpoints

### Chat Routes
- `GET /chat` - Chat interface
- `POST /chat/send` - Send message to AI

### Subscription Routes
- `GET /subscription` - Subscription management
- `POST /subscription/paypal/create` - Create PayPal order
- `POST /subscription/create-stripe-session` - Create Stripe session

### Authentication Routes
- `GET /login` - Login page
- `POST /login` - Process login
- `GET /register` - Registration page
- `POST /register` - Process registration

## File Structure

```
app/
├── Http/Controllers/
│   ├── ChatController.php          # Chat functionality
│   └── SubscriptionController.php  # Payment processing
├── Models/
│   ├── User.php                    # User model with subscription logic
│   └── ChatMessage.php             # Chat message model
└── Services/
    └── OpenAIService.php           # OpenAI API integration

resources/views/
├── chat/
│   └── index.blade.php             # Main chat interface
└── subscription/
    └── index.blade.php             # Subscription management

routes/
├── web.php                         # Web routes
└── auth.php                        # Authentication routes
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Testing

Run the test suite:

```bash
php artisan test
```

## Security

- All user inputs are validated and sanitized
- CSRF protection enabled
- SQL injection prevention through Eloquent ORM
- Secure password hashing
- API rate limiting implemented

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

Developed by NORSU-BSC InfoTech Students led by Sir Ronard.

## Support

For support, please contact the development team or create an issue in the repository.
