# SmartBudget Community

A lightweight personal budget management web application for tracking income and expenses with real-time balance updates.

## Features

- **User Registration & Authentication** — Secure signup/login with bcrypt password hashing
- **Auto Account Creation** — Default checking account created on registration
- **Transaction Tracking** — Add income (revenu) or expenses (depense) with descriptions
- **Real-Time Balance** — Account balance updates automatically with each transaction
- **Transaction History** — View the 10 most recent transactions sorted by date
- **Dashboard** — Balance overview, quick-add form, and transaction table

## Technologies

| Technology | Usage |
|------------|-------|
| PHP | Server-side logic, authentication, CRUD |
| MySQL/MariaDB | Database |
| HTML5 | Page templates |
| Bootstrap 5.3.0 | UI framework (CDN) |
| PDO | Database abstraction layer |

## Database Schema

| Table | Description |
|-------|-------------|
| `users` | User accounts (id, name, email, bcrypt password) |
| `comptes` | Bank accounts per user (label, balance) |
| `transactions` | Income/expense records (type, amount, description, date) |

## Requirements

- PHP 7.0+ with PDO MySQL extension
- MySQL/MariaDB
- Apache/Nginx (XAMPP recommended)

## Setup

1. Create a MySQL database named `smartbudget_db`
2. Create the required tables (`users`, `comptes`, `transactions`)
3. Update `db.php` with your database credentials
4. Place the project in your web server's document root
5. Navigate to `index.php` in your browser
