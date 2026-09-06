# Law Firm Management System

A backend-focused Law Firm Management System built with **Core PHP, OOP, MySQL, PDO, and a custom MVC architecture**.

The system manages **clients, cases, hearings, appointments, documents, and users**, with role-based access control and secure backend operations.

---

## Key Features

- 🔐 Authentication & Role-Based Authorization
- 👥 User & Client Management
- ⚖️ Case Management with Status History
- 📅 Case Hearings Management
- 🗓️ Appointments Management
- 📄 Case Documents & Secure File Handling
- 🔎 AJAX Search, Filtering & Pagination for Cases
- 🛡️ CSRF Protection, Input Validation & Prepared Statements

---

## Roles & Access Control

- **Admin** — Full system access and user management
- **Lawyer** — Access to assigned cases and their related hearings
- **Staff** — Access to clients, cases, hearings, appointments, and documents according to permissions

> Authorization is enforced server-side, not only through the UI.

---

## Architecture

The application follows a custom MVC architecture with **Service and Repository layers**:

```text
Request
  ↓
Router
  ↓
Middleware
  ↓
Controller
  ↓
Service
  ↓
Repository
  ↓
PDO / MySQL
```

This separation keeps HTTP handling, business logic, and database operations organized and maintainable.

---

## Security

The project implements:

- PDO Prepared Statements
- Password Hashing & Verification
- CSRF Protection
- Session ID Regeneration
- Server-side Authorization
- Input & File Validation
- Case-level Access Control

---

## Tech Stack

**Backend:** PHP 8.2, OOP, PDO, MySQL/MariaDB

**Frontend:** HTML5, CSS3, JavaScript, Tabler UI (RTL), AJAX

**Tools:** Composer, Git, GitHub, XAMPP, phpMyAdmin

---

## Database

The database schema and demo data are included in:

```text
database/schema.sql
```

Main entities:

- Users
- Clients
- Cases
- Case Types
- Case Status History
- Hearings
- Appointments
- Documents

> The included data is for demonstration and testing purposes only.

---

## Installation

### Requirements

- PHP 8.2+
- MySQL / MariaDB
- Apache
- Composer

### Setup

```bash
git clone https://github.com/ABDOKARAM22/law-firm-management.git
cd law-firm-management
composer install
```

Create a `.env` file:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=law_firm_management
DB_USER=root
DB_PASS=
```

Create the `law_firm_management` database and import:

```text
database/schema.sql
```

Configure Apache to serve the project's `public/` directory.

---

## Future Improvements

- Production Deployment
- Expanded Automated Testing
- Advanced Reports & Dashboard Statistics
- Standalone Hearings Overview & Filtering
- Database Migrations
- CI/CD Integration

---

## Author

**Abdelrahman Karam**

PHP / Laravel Backend Developer
