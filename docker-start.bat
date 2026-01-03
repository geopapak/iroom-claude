@echo off
REM iRoom Docker Start Script for Windows
REM This script starts the MySQL database in Docker

echo Starting iRoom MySQL Docker containers...
echo.

REM Check if Docker is running
docker info >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker is not running. Please start Docker Desktop and try again.
    pause
    exit /b 1
)

REM Start containers
docker-compose up -d

if errorlevel 0 (
    echo.
    echo Containers started successfully!
    echo.
    echo Container Status:
    docker-compose ps
    echo.
    echo Waiting for MySQL to be ready this may take 30 seconds...
    echo.
    timeout /t 30 /nobreak >nul
    echo.
    echo MySQL is ready!
    echo.
    echo Connection Details:
    echo    MySQL:      localhost:3306
    echo    Database:   iRoom
    echo    Username:   iroom
    echo    Password:   iroom
    echo.
    echo phpMyAdmin: http://localhost:8081
    echo.
    echo You can now start the backend:
    echo    cd backend
    echo    mvn spring-boot:run
    echo.
) else (
    echo.
    echo ERROR: Failed to start containers. Check the error message above.
    pause
    exit /b 1
)

pause
