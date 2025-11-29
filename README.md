# Handshake Backend

Backend for the Handshake bartering mobile app, built with Laravel 10 and Filament 3.

## Requirements

- PHP 8.1+
- Composer
- MySQL

## Installation

1. **Clone the repository**
   ```bash
   git clone <repo-url>
   cd handshake
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your database credentials.

4. **Generate Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Create Admin User**
   ```bash
   php artisan make:filament-user
   ```

7. **Serve the Application**
   ```bash
   php artisan serve
   ```

## Admin Panel

Access the Filament admin panel at: `http://localhost:8000/admin`

## API Documentation

A Postman collection is included in the root directory: `handshake_postman_collection.json`.
Import this file into Postman to test the API endpoints.

### Base URL
`http://localhost:8000`

### Authentication
The API uses Laravel Sanctum.
1. Register a user via `POST /api/v1/auth/register`.
2. Login via `POST /api/v1/auth/login` to get an access token.
3. Use the token in the `Authorization` header: `Bearer <token>`.

## Features

- **User Management**: Profile, Ratings, Favorites, Wants.
- **Items**: CRUD, Search, Filtering, Media.
- **Barters**: Request, Accept, Reject, Cancel, Rate.
- **Payments**: Structure for payment processing.
- **Subscriptions**: Plans and user subscriptions.
- **Chat**: Messaging between barter parties.
- **Admin**: Full management via Filament.
