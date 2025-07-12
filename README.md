# ReWear - Community Clothing Exchange Platform

## Overview
ReWear is a Laravel-based web platform that enables users to exchange unused clothing through direct swaps or a point-based redemption system. The platform promotes sustainable fashion and reduces textile waste by encouraging users to reuse wearable garments.

## Features

### Core Functionality
- **User Authentication**: Email/password signup and login
- **Item Management**: Upload, edit, and manage clothing listings
- **Swap System**: Direct item swaps and points-based redemption
- **Admin Panel**: Content moderation and platform management
- **Points Economy**: Gamified system to encourage participation

### User Features
- Profile management with points tracking
- Item upload with multiple images
- Advanced search and filtering
- Swap request management
- Transaction history

### Admin Features
- Item approval/rejection workflow
- User management
- Platform statistics and monitoring
- Content moderation tools

## Technology Stack
- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Blade templates, Tailwind CSS, Alpine.js
- **Database**: MySQL/PostgreSQL
- **File Storage**: Local/S3 compatible
- **Testing**: PHPUnit with Feature and Unit tests

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or PostgreSQL

### Setup Steps

1. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

2. **Environment configuration**:
   ```bash
   php artisan key:generate
   # Update .env with your database credentials
   ```

3. **Database setup**:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Storage and assets**:
   ```bash
   php artisan storage:link
   npm run dev
   ```

5. **Start development server**:
   ```bash
   php artisan serve
   ```

## Default Accounts

### Admin Access
- **Email**: admin@rewear.com
- **Password**: 123456789

### Demo User
- **Email**: alice@example.com
- **Password**: 123456789

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
