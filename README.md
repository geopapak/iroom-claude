# iRoom - Room Scheduling System

University room scheduling and management system built with React + Spring Boot.

## Tech Stack

- **Frontend:** React 19, Vite, Material UI
- **Backend:** Spring Boot 3, Java 17
- **Database:** MySQL 8
- **Auth:** JWT

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/) & Docker Compose
- [Java 17+](https://adoptium.net/)
- [Maven 3.8+](https://maven.apache.org/)
- [Node.js 18+](https://nodejs.org/)

## Quick Start

### 1. Start Database (MySQL via Docker)

```bash
./start-mysql-docker.sh
# Windows: docker-start.bat
```

MySQL runs on `localhost:3306`, phpMyAdmin on `http://localhost:8081`.

### 2. Start Backend (Spring Boot)

```bash
cd backend
mvn spring-boot:run
```

Backend runs on `http://localhost:8080`.

### 3. Start Frontend (React + Vite)

```bash
cd frontend
npm install
npm run dev
```

Frontend runs on `http://localhost:3000`.

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@admin.gr | admin |

> Change the default password after first login.

## Project Structure

```
iroom-claude/
├── frontend/          # React + Vite application
│   ├── src/
│   │   ├── components/    # UI components
│   │   ├── pages/         # Page components (dashboards)
│   │   ├── services/      # API service layer
│   │   └── store/         # Zustand state management
│   └── package.json
├── backend/           # Spring Boot application
│   └── src/main/java/gr/uowm/iroom/
│       ├── controller/    # REST endpoints
│       ├── service/       # Business logic
│       ├── entity/        # JPA entities
│       ├── repository/    # Spring Data repositories
│       ├── dto/           # Request DTOs
│       ├── security/      # JWT & Spring Security
│       └── config/        # App configuration
├── docker-compose.yml     # MySQL + phpMyAdmin
└── start-mysql-docker.sh  # Helper to start DB
```

## API Endpoints

| Resource | Base URL |
|----------|----------|
| Auth | `/api/auth` |
| Users | `/api/users` |
| Departments | `/api/departments` |
| Rooms | `/api/rooms` |
| Courses | `/api/courses` |
| Equipment | `/api/equipment` |
| Schedules | `/api/schedules` |

## Database

Schema is managed with [Flyway](https://flywaydb.org/) migrations located in `backend/src/main/resources/db/migration/`.
