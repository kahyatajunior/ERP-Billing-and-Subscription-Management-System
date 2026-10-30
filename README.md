# ERP Billing and Subscription Management System

A Laravel-based enterprise resource planning (ERP) application for managing organizations, customers, subscriptions, invoices, and payments.

## Overview

This system helps track customer accounts, recurring service subscriptions, invoicing, and outstanding balances in one place. It is designed for businesses that need a central billing workflow with customer statements and payment tracking.

## How it works

The application follows a simple ERP flow:

- Organizations represent the business units or companies being managed.
- Customers belong to an organization and can have multiple subscriptions.
- Service plans define the billing structure.
- Subscriptions connect a customer to a plan and track activation, billing dates, and status.
- The billing engine generates invoices from active subscriptions.
- Payments are recorded and applied to invoices, reducing the outstanding balance.
- The dashboard summarizes customer, subscription, and invoice counts, plus total outstanding amounts.

Core modules include:

- Customer management
- Subscription management
- Invoice generation and viewing
- Payment recording and allocation
- Customer statement tracking
- Basic accounting data models for journals, invoices, and chart of accounts

## Tech stack

- PHP 8.2
- Laravel 12
- SQLite by default (can be configured in `.env`)
- Vite for front-end assets
- Tailwind CSS

## Prerequisites

Before running the application, make sure you have:

- PHP 8.2 or newer
- Composer
- Node.js and npm
- A local database available (SQLite is configured by default)

## How to run it

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Create the environment file:

   ```bash
   copy .env.example .env
   ```

   On Linux/macOS:

   ```bash
   cp .env.example .env
   ```

3. Generate the application key:

   ```bash
   php artisan key:generate
   ```

4. Run database migrations:

   ```bash
   php artisan migrate
   ```

5. Install front-end dependencies and build the assets:

   ```bash
   npm install
   npm run build
   ```

6. Start the application:

   ```bash
   php artisan serve
   ```

   Then open the app in your browser at:

   ```text
   http://localhost:8000
   ```

## Optional development mode

To run the app with the Laravel development workflow and asset watcher together:

```bash
composer run dev
```

This starts the app with the usual development stack for local work.

## Project scripts

Useful project commands:

```bash
php artisan test
php artisan migrate
php artisan serve
npm run dev
```

## License

This project is open source and uses the MIT license.
