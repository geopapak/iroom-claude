#!/bin/bash

echo "========================================="
echo "iRoom - Quick Start (React + Spring Boot)"
echo "========================================="
echo ""

ERRORS=0

# Check Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Install from https://docs.docker.com/get-docker/"
    ERRORS=1
else
    echo "✓ Docker: $(docker --version)"
fi

# Check Java
if ! command -v java &> /dev/null; then
    echo "❌ Java 17+ is not installed. Install from https://adoptium.net/"
    ERRORS=1
else
    echo "✓ Java: $(java -version 2>&1 | head -n 1)"
fi

# Check Maven
if ! command -v mvn &> /dev/null; then
    echo "❌ Maven is not installed. Install from https://maven.apache.org/"
    ERRORS=1
else
    echo "✓ Maven: $(mvn -version 2>&1 | head -n 1)"
fi

# Check Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js 18+ is not installed. Install from https://nodejs.org/"
    ERRORS=1
else
    echo "✓ Node.js: $(node --version)"
fi

echo ""

if [ $ERRORS -ne 0 ]; then
    echo "Please install the missing prerequisites and try again."
    exit 1
fi

# Step 1: Start MySQL
echo "Step 1: Starting MySQL with Docker..."
docker compose up -d mysql

if [ $? -ne 0 ]; then
    echo "❌ Failed to start MySQL. Check Docker logs: docker logs iroom-mysql"
    exit 1
fi

echo "Waiting for MySQL to be ready..."
elapsed=0
until docker inspect --format='{{.State.Health.Status}}' iroom-mysql 2>/dev/null | grep -q "healthy"; do
    sleep 2
    elapsed=$((elapsed + 2))
    if [ $elapsed -ge 60 ]; then
        echo "❌ MySQL did not start in time. Check logs: docker logs iroom-mysql"
        exit 1
    fi
    echo -n "."
done
echo ""
echo "✓ MySQL is ready on localhost:3306"
echo ""

# Step 2: Install frontend dependencies
echo "Step 2: Installing frontend dependencies..."
cd frontend && npm install --silent
if [ $? -ne 0 ]; then
    echo "❌ npm install failed"
    exit 1
fi
cd ..
echo "✓ Frontend dependencies installed"
echo ""

echo "========================================="
echo "Setup complete! Start the application:"
echo "========================================="
echo ""
echo "Terminal 1 - Backend:"
echo "  cd backend && mvn spring-boot:run"
echo ""
echo "Terminal 2 - Frontend:"
echo "  cd frontend && npm run dev"
echo ""
echo "Then open: http://localhost:3000"
echo ""
echo "Default login:"
echo "  Email:    admin@admin.gr"
echo "  Password: admin"
echo ""
echo "Optional - phpMyAdmin:"
echo "  docker compose up -d phpmyadmin"
echo "  Open: http://localhost:8081"
echo ""
