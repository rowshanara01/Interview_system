# 🧩 Book Sharing Platform System — Laravel + API (Passport + Swagger) And React.js For Frontend

This repository provides a backend API–driven Book Sharing Platform built with **Laravel, with a React.js frontend** consuming the APIs. Authenticated users can discover books shared by others within a configurable **radius (10 km by default)** from their **latitude/longitude** using the **Haversine formula**. The API is secured via Laravel **Passport (OAuth2 bearer tokens)** and fully documented with Swagger/OpenAPI (see /api/documentation). The system supports **role-based access (Admin/User)**, returns consistent JSON via Laravel API Resources (including distance and owner details), and ships with seed data for users and books.

---

## 🚀 Project Overview

This project was built as part of the Digital Frontier Partners interview assessment. It includes:

- **Authentication (Laravel Passport/OAuth2)**: Secure token-based auth with access tokens.
- **Role-based access**:
  - **Admin**: List users, list all books, delete books.
  - **User**: Share books and view nearby books.
- **Nearby Books feature**:
  - Geospatial search using the Haversine formula to find books shared by other users within a configurable radius (default **10 km**).
  - Radius can be adjusted via `config/app.php` → `nearby_books_radius`.
- **API Resources & responses**:
  - Consistent JSON via Laravel API Resources.
  - `BookResource` includes `distance` (km) and `user` info.
- **Documentation (Swagger/OpenAPI)**:
  - Auto-generated docs at `/api/documentation`, with Bearer token authorization.
- **Seed data**:
  - Sample users with latitude/longitude and sample books to test nearby search.
- **Frontend (React.js)**:
  - A React.js client consumes these REST endpoints.

Tech stack: Laravel, Passport (OAuth2), MySQL, Swagger (l5-swagger), React.js.

---

## 📁 Folder Structure (Highlights)

```bash
app/
├── Classes/                       # Base helpers for consistent API responses
│   ├── BaseController.php
│   ├── BaseModel.php
│   └── Helper.php
├── Http/
│   ├── Controllers/
│   │   ├── api/                   # Public API (Passport-secured)
│   │   │   ├── AuthController.php
│   │   │   └── BookController.php
│   │   └── admin/                 # Admin-only APIs (middleware: admin)
│   │       ├── BookController.php
│   │       └── UserController.php
│   ├── Requests/
│   │   └── api/                   # Request validation
│   │       ├── RegisterRequest.php
│   │       ├── LoginRequest.php
│   │       └── BookRequest.php
│   ├── Resources/                 # API Resources (transformers)
│   │   ├── api/
│   │   │   ├── BookResource.php
│   │   │   └── BookCollection.php
│   │   └── admin/
│   └── Resources/BaseCollection.php
└── Repositories/                  # Data access layer
    └── api/
        ├── AuthRepository.php
        └── BookRepository.php
config/
├── app.php                        # nearby_books_radius (configurable)
routes/
└── api.php                        # /login, /register, /books, /books/nearby, /admin/*
```

# 🧩 Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/ALBAB404/digital_frontier_partners_Interview_task.git
```
### 2️⃣ Move to Project Directory

```bash
cd digital_frontier_partners_Interview_task
```
### 3️⃣ Install PHP Dependencies

```bash
composer install
```

Could not delete C:\office files\react\it-folder\test\digital_frontier_partners_Interview_task/vendor/composer/90a4d387\swagger-api-swagger-ui-43ed706\dist\swagger-ui.css:
This can be due to an antivirus or the Windows Search Indexer locking 
the file while they are analyzed
```bash
composer require swagger-api/swagger-ui
```

### 4️⃣ Create and Configure .env
```bash
cp .env.example .env
```

### 5️⃣ Generate App Key
```bash
php artisan key:generate
```

### 6️⃣ Migrate your database
```bash
php artisan migrate:fresh --seed
```

Then configure the following in .env:
-Database connection
-Passport Secret:
-Generate it via:
```bash
php artisan passport:client --personal
```

Then it will ask:  What should we name the client? [Laravel]
```bash
Interview Task Personal Client
```

Next, it may ask:  Which user provider should this client use to retrieve users? [users]
```bash
users
```

Next, You Generate Passport Key
```bash
php artisan passport:key
```

### 7️⃣ Start the application

You can run the project using either of the following methods:

- Run Laravel backend  
```bash
php artisan serve
```

### Admin Login Credentials
User : superadmin@gmail.com
Password : 123456

### User Login Credentials
user : imalbab1@gmail.com
password : 123456

# 🧩 Environment configuration details
### Database Configuration
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digital_frontier_partners
DB_USERNAME=root
DB_PASSWORD=
```

## 📥 Downloads

- Postman Collection (v2.1): [Download JSON](https://github.com/ALBAB404/digital_frontier_partners_Interview_task/releases/download/postman/BookSharing.postman_collection.2.json)  


- Database SQL dump (MySQL):
  [Download SQL](https://github.com/ALBAB404/digital_frontier_partners_Interview_task/releases/download/postman/digital_frontier_partners.sql)


### Swagger Visit Url

```bash
http://localhost:8000/api/documentation
```

# 🧩 Optimization Techniques (Task 3)
To improve the performance of the Book Sharing Platform System, the following optimization strategies were applied:

## 1️⃣ Eager Loading (with with())
Instead of using lazy loading, I used eager loading to prevent N+1 query problems.
```bash
    public function index()
    {
        $user = auth()->user();
        $latitude = $user->latitude;
        $longitude = $user->longitude;

        $radius = config('app.nearby_books_radius', 10);

        $books = $this->model
            ->with('user')
            ->selectRaw(
                "books.*,
                (6371 * acos(cos(radians(?))
                * cos(radians(users.latitude))
                * cos(radians(users.longitude) - radians(?))
                + sin(radians(?))
                * sin(radians(users.latitude)))) AS distance",
                [$latitude, $longitude, $latitude]
            )
            ->join('users', 'users.id', '=', 'books.user_id')
            ->where('books.user_id', '!=', $user->id)
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();

        return $books;
    }

    AND 


    public function getAllBooks()
    {
        $books = $this->model->with("user:id,name")
                              ->select("id", "title", "author", "user_id")
                              ->orderBy("title", "ASC")
                              ->get();
        return $books;
    }
```
## 2️⃣ Indexing (on searchable fields)
I added database indexes on frequently queried columns such as:
```base
$table->string('title')->index();
```

## 📘 API Documentation

This project includes a full-featured RESTful API for task management, secured using JWT authentication. The API supports user registration, login, and CRUD operations for tasks.

### 🔐 Authentication Endpoints

| Method | Endpoint        | Description              | Auth Required |
| ------ | --------------- | ------------------------ | ------------- |
| POST   | `/api/register` | Register a new user      | ❌ No          |
| POST   | `/api/login`    | Login and get JWT token  | ❌ No          |

### 🔑 Passport Token Usage

After login, the token should be included in the `Authorization` header of all subsequent requests:

```http
Authorization: Bearer <your_token_here>
```

---

### 📌 Book And User Endpoints (For User)

| Method | Endpoint             | Description             | Auth Required |
| ------ | -----------------    | ----------------------- | ------------- |
| GET    | `/api/books/nearby`  | Get all Books           | ✅ Yes         |
| POST   | `/api/books`         | Create a new book       | ✅ Yes         |

### 📌 Book And User Endpoints (For Admin)

| Method | Endpoint             | Description             | Auth Required |
| ------ | -----------------    | ----------------------- | ------------- |
| GET    | `/admin/users`       | Get all users           | ✅ Yes         |
| GET    | `/admin/books`       | Get all Books           | ✅ Yes         |
| DELETE | `/admin/books/{ID}`  | Create a new book       | ✅ Yes         |

#### ✅ Sample Book Request Payload:

```json
{
    "id": 5,
    "title": "The Catcher in the Rye",
    "author": "J.D. Salinger",
    "description": "A story about teenage rebellion and angst",
    "user_id": 5,
    "distance": "3.18 km",
    "user": {
        "id": 5,
        "name": "Bob Johnson"
    }
},
```

---

### 🧾 Swagger/OpenAPI Integration

All the API endpoints are documented using **Swagger/OpenAPI**.

You can visit the documentation UI at:

```bash
http://localhost:8000/api/documentation
```

Use the **Authorize 🔐** button to input your JWT token and test the protected endpoints directly from the Swagger interface.
