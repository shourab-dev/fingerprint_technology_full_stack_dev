# Student Attendance Management System - Backend (Laravel)

A REST API built with Laravel 12 for managing student attendance records with authentication, CRUD operations, and reporting features.

## 📋 Features

-   🔐 **Authentication** - Laravel Sanctum token-based authentication
-   👥 **Student Management** - Full CRUD operations with photo uploads
-   📊 **Attendance Tracking** - Single and bulk attendance recording
-   📈 **Reports** - Monthly attendance reports with statistics
-   🚀 **Performance** - Redis caching for optimized queries
-   📧 **Notifications** - Event-driven attendance notifications
-   🛠️ **CLI Tools** - Custom Artisan commands for report generation

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

-   PHP >= 8.2
-   Composer
-   MySQL >= 8.0
-   Redis (optional, can use file cache)
-   Node.js & NPM (for asset compilation if needed)

## 🚀 Installation

### 1. Clone the Repository

git clone <your-repository-url>
cd student-attendance-backend

### 2. Install Dependencies

composer install

### 3. Environment Setup

# Copy environment file

cp .env.example .env

# Generate application key

php artisan key:generate

### 4. Configure Environment Variables

Edit `.env` file with your database and application settings:
env
APP_NAME="Student Attendance System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_attendance
DB_USERNAME=root
DB_PASSWORD=your_password

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

FILESYSTEM_DISK=public

SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
SESSION_DRIVER=cookie
SESSION_DOMAIN=localhost

### 5. Create Database

php artisan migrate

### 6. Run Database Seeder

php artisan db:seed

### 7. Create Storage Link

php artisan storage:link

**Default credentials after seeding:**

-   Email: `admin@gmail.com`
-   Password: `password`

### 9. Clear cache, routes, views

php artisan optimize:clear

### 10. Start the Server

php artisan serve
Your API will be available at `http://localhost:8000`

## 🔧 Additional Setup

### Redis Setup (Optional but Recommended)

**Ubuntu/Debian:**

sudo apt-get install redis-server
sudo service redis-server start

**macOS:**

brew install redis
brew services start redis

**Windows:**
Download from [Redis GitHub Releases](https://github.com/microsoftarchive/redis/releases)

**If not using Redis**, change in `.env`:
env
CACHE_DRIVER=file

### Queue Worker (Optional)

For background jobs and notifications:

php artisan queue:work

## 📚 API Documentation

### Authentication Endpoints

| Method | Endpoint        | Description            | Auth Required |
| ------ | --------------- | ---------------------- | ------------- |
| POST   | `/api/register` | Register new user      | No            |
| POST   | `/api/login`    | Login user             | No            |
| GET    | `/api/user`     | Get authenticated user | Yes           |
| POST   | `/api/logout`   | Logout user            | Yes           |

### Student Endpoints

| Method | Endpoint             | Description        | Auth Required |
| ------ | -------------------- | ------------------ | ------------- |
| GET    | `/api/students`      | List all students  | Yes           |
| POST   | `/api/students`      | Create student     | Yes           |
| GET    | `/api/students/{id}` | Get single student | Yes           |
| PUT    | `/api/students/{id}` | Update student     | Yes           |
| DELETE | `/api/students/{id}` | Delete student     | Yes           |

### Attendance Endpoints

| Method | Endpoint                         | Description               | Auth Required |
| ------ | -------------------------------- | ------------------------- | ------------- |
| GET    | `/api/attendance`                | List attendance records   | Yes           |
| POST   | `/api/attendance`                | Record single attendance  | Yes           |
| POST   | `/api/attendance/bulk`           | Bulk attendance recording | Yes           |
| GET    | `/api/attendance/report/monthly` | Monthly report            | Yes           |
| GET    | `/api/attendance/statistics`     | Get statistics            | Yes           |

## 🧪 Testing API

### Using cURL

**Register:**

curl -X POST http://localhost:8000/api/register \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{
"name": "John Doe",
"email": "john@example.com",
"password": "password123",
"password_confirmation": "password123"
}'

**Login:**

curl -X POST http://localhost:8000/api/login \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{
"email": "admin@example.com",
"password": "password123"
}'

**Create Student (with token):**

curl -X POST http://localhost:8000/api/students \
 -H "Authorization: Bearer YOUR_TOKEN_HERE" \
 -H "Accept: application/json" \
 -F "name=Jane Doe" \
 -F "student_id=STU001" \
 -F "class=Class 10" \
 -F "section=A"

**Bulk Attendance:**

curl -X POST http://localhost:8000/api/attendance/bulk \
 -H "Authorization: Bearer YOUR_TOKEN_HERE" \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{
"date": "2024-11-16",
"recorded_by": "Teacher Name",
"attendances": [
{"student_id": 1, "status": "present"},
{"student_id": 2, "status": "absent", "note": "Sick leave"}
]
}'

## 🎯 Custom Artisan Commands

### Generate Attendance Report

# Report for all classes

php artisan attendance:generate 2025-11

# Report for specific class

php artisan attendance:generate-report 2025-11 "Class 10"
