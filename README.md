# Web Development 2 Boilerplate

A full-stack web application, featuring a PHP REST API backend and a Vue 3 frontend.

## 🏗️ Architecture

This project consists of two main components:

- **Backend**: PHP REST API following MVC architecture patterns
- **Frontend**: Vue 3 application with Vite and Fontawesome

## 📁 Project Structure

```
web_development_2_boilerplate/
├── backend/          # PHP REST API
│   ├── app/          # Application code
│   ├── docker-compose.yml
│   └── README.md     # Backend documentation
└── frontend/         # Vue 3 application
    ├── src/          # Source code
    └── README.md     # Frontend documentation
```

## Features

### Frontend
- User authentication (login & register) with JWT
- Materials listing and details (fetched from backend API)
- Orders overview and management (for managers)
- User management (for admins/managers)
- Dashboard with statistics (items, orders, users)
- Responsive design with Vue 3 and Pinia state management
- Error and loading state handling
- Ordering materials and checking its status

### Backend
- RESTful API built with PHP
- JWT authentication for protected routes
- User registration and login with password hashing
- CRUD operations for materials, orders, users, and order items
- Database connection via PDO (MariaDB/MySQL)
- CORS enabled for frontend-backend communication
- Routing with Bramus Router

## 🚀 Quick Start

### Prerequisites

- **Docker and Docker Compose** (for backend)
- **Node.js** ^20.19.0 or >=22.12.0 (for frontend)
- **npm** or **yarn**

### Backend Setup

1. Navigate to the backend directory:

```bash
cd backend
```

2. Start Docker containers:

```bash
docker-compose up --build
```

The API will be available at **http://localhost/api**

For detailed backend documentation, see [backend/README.md](./backend/README.md)

### Frontend Setup

1. Navigate to the frontend directory:

```bash
cd frontend
```

2. Install dependencies:

```bash
npm install
```

3. Start the development server:

```bash
npm run dev
```

The frontend will be available at **http://localhost:5173** (or the port shown in terminal)

For detailed frontend documentation, see [frontend/README.md](./frontend/README.md)

### User Credentials (for testing)

| Name    | Email               | Password    | Role   |
|---------|---------------------|-------------|--------|
| Alice   | alice@example.com   | secret123   | admin  |
| Bob     | bob@example.com     | secret123   | user   |
| Charlie | charlie@example.com | secret123   | user   |

> **Note:** If you register a new user via the frontend, use the same email and password for login.

### Known Issues

- Ensure that the backend is running and accessible at the correct base URL (`http://localhost/api/`).
- Double-check CORS and Docker/Nginx configuration if you encounter connection problems.

### More Information

For the full development history, you can check the repository for this project via de link below:

https://github.com/ayazspv/WebDev2-2526
