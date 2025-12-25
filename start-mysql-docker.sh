#!/bin/bash

echo "=========================================="
echo "iRoom - Starting MySQL with Docker"
echo "=========================================="
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed!"
    echo ""
    echo "Install Docker with:"
    echo "  curl -fsSL https://get.docker.com -o get-docker.sh"
    echo "  sudo sh get-docker.sh"
    echo "  sudo usermod -aG docker $USER"
    echo "  newgrp docker"
    exit 1
fi

# Check if docker-compose is available
if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose is not installed!"
    echo ""
    echo "Install Docker Compose with:"
    echo "  sudo apt install docker-compose-plugin -y"
    exit 1
fi

echo "✅ Docker is installed"
echo ""

# Start MySQL container
echo "Starting MySQL container..."
docker compose up -d mysql

echo ""
echo "Waiting for MySQL to be ready..."
sleep 10

# Check if MySQL is running
if docker ps | grep -q iroom-mysql; then
    echo ""
    echo "=========================================="
    echo "✅ MySQL is running!"
    echo "=========================================="
    echo ""
    echo "Connection details:"
    echo "  Host: localhost"
    echo "  Port: 3306"
    echo "  Database: iRoom"
    echo "  Username: iroom"
    echo "  Password: iroom"
    echo ""
    echo "Optional: Start phpMyAdmin for database management:"
    echo "  docker compose up -d phpmyadmin"
    echo "  Then visit: http://localhost:8081"
    echo ""
    echo "View MySQL logs:"
    echo "  docker logs iroom-mysql -f"
    echo ""
    echo "Stop MySQL:"
    echo "  docker compose down"
    echo ""
else
    echo ""
    echo "❌ MySQL failed to start. Check logs:"
    echo "  docker logs iroom-mysql"
    exit 1
fi
