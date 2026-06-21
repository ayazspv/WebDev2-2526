# Articles API

A RESTful API for managing articles built with PHP, following MVC architecture patterns.

## Project Structure

```
backend/
├── app/
│   ├── public/
│   │   └── index.php          # Entry point and route dispatcher
│   └── src/
│       ├── Controllers/        # Request handlers
│       ├── Services/           # Business logic layer
│       ├── Repositories/       # Data access layer
│       ├── Models/             # Data models
│       ├── Framework/          # Base controller class and other general framework code
│       └── Data/               # SQL data storage
├── docker-compose.yml          # Docker services configuration
├── nginx.conf                  # Nginx configuration
├── PHP.Dockerfile              # PHP Docker image configuration
```

## Getting Started

### Prerequisites

- Docker and Docker Compose

### Installation

1. Clone the repository:

```bash
cd backend
```

2. Start the Docker containers:

```bash
docker-compose up --build
```

### Running the Application

The application will be available at:

- **API**: http://localhost
- **phpMyAdmin**: http://localhost:8080

## Docker Services

- **nginx**: Web server (port 80)
- **php**: PHP-FPM service
- **mysql**: MariaDB database (port 3306)
  - Username: `dbmanager`
  - Password: `dbpassword`
  - Database: `CircuTrade`
- **phpmyadmin**: Database management interface (port 8080)
