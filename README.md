# ShopEase - Point of Sale System

A full-featured Point of Sale (POS) e-commerce application built with Laravel, featuring admin management, user shopping, and social authentication.

## Features

### User Features
- **Product Browsing**: View products with details, ratings, and reviews
- **Shopping Cart**: Add/remove items, manage quantities
- **Order Management**: Create orders, view order history, make payments
- **Product Ratings & Comments**: Rate and review products
- **Contact System**: Send inquiries and feedback
- **AI Chatbot**: Get product recommendations and support
- **Social Login**: Sign in with Google and GitHub

### Admin Features
- **Dashboard**: Overview of store statistics
- **Category Management**: Create, edit, delete product categories
- **Product Management**: Full CRUD operations for products
- **Order Management**: View, confirm, and reject orders
- **Payment Management**: Manage payment methods and histories
- **User Management**: Manage admin and customer accounts

### Role-Based Access
- **Super Admin**: Full system access, user management, payment configuration
- **Admin**: Product, category, and order management
- **User**: Shopping, cart, orders, and profile management

## Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Breeze + Socialite (Google, GitHub)
- **Frontend**: Blade Templates, Bootstrap, Custom CSS
- **Session**: Database-backed sessions

## Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+
- Node.js (optional, for asset compilation)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ShopEase
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install (optional)
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   ```
   
   Update `.env` with your database and social login credentials:
   ```env
   APP_URL=http://localhost:8000
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=8889
   DB_DATABASE=point_of_sale
   DB_USERNAME=root
   DB_PASSWORD=root
   
   GOOGLE_CLIENT_ID=your-google-client-id
   GOOGLE_CLIENT_SECRET=your-google-client-secret
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

7. **Set up OAuth Redirect URIs in Google Cloud Console**
   ```
   http://localhost:8000/auth/google/callback
   ```

## Social Login Setup

### Google OAuth
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API
4. Go to Credentials → OAuth 2.0 Client IDs
5. Add authorized redirect URI: `http://localhost:8000/auth/google/callback`
6. Copy Client ID and Secret to `.env`

## Project Structure

```
ShopEase/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── User/           # User-facing controllers
│   │   │   └── SocialLoginController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── SuperAdminMiddleware.php
│   │       ├── UserMiddleware.php
│   │       └── AuthenticatedLoginMiddleware.php
│   └── Models/
├── routes/
│   ├── web.php                 # Main web routes
│   ├── admin.php                # Admin routes
│   ├── user.php                 # User routes
│   └── auth.php                 # Authentication routes
├── resources/
│   └── views/
│       ├── admin/               # Admin layouts and views
│       └── user/                # User-facing views
└── config/
    └── services.php             # OAuth configurations
```

## Routes Overview

### Public Routes
- `/login`, `/register` - Authentication
- `/auth/{provider}/redirect` - Social login redirect
- `/auth/{provider}/callback` - Social login callback

### User Routes (requires `user` role)
- `/user/home` - User dashboard
- `/user/product/details/{id}` - Product details
- `/user/cart/page` - Shopping cart
- `/user/order/*` - Order management

### Admin Routes (requires `admin` role)
- `/admin/dashboard` - Admin dashboard
- `/admin/category/*` - Category management
- `/admin/product/*` - Product management
- `/admin/order/*` - Order management

### Super Admin Routes (requires `superadmin` role)
- `/admin/account/*` - Account management
- `/admin/payment/*` - Payment configuration

## License

This project is open-sourced software.
