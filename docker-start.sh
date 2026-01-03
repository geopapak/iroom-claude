#!/bin/bash

# iRoom Docker Start Script
# This script starts the MySQL database in Docker

echo "🐳 Starting iRoom MySQL Docker containers..."
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker and try again."
    exit 1
fi

# Start containers
docker-compose up -d

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Docker containers started successfully!"
    echo ""
    echo "📊 Container Status:"
    docker-compose ps
    echo ""
    echo "⏳ Waiting for MySQL to be ready (this may take 30 seconds)..."
    echo ""

    # Wait for MySQL to be healthy
    timeout=60
    elapsed=0
    while [ $elapsed -lt $timeout ]; do
        if docker inspect --format='{{.State.Health.Status}}' iroom-mysql 2>/dev/null | grep -q "healthy"; then
            echo "✅ MySQL is ready!"
            echo ""
            echo "📝 Connection Details:"
            echo "   MySQL:      localhost:3306"
            echo "   Database:   iRoom"
            echo "   Username:   iroom"
            echo "   Password:   iroom"
            echo ""
            echo "🌐 phpMyAdmin: http://localhost:8081"
            echo ""
            echo "🚀 You can now start the backend:"
            echo "   cd backend && mvn spring-boot:run"
            echo ""
            exit 0
        fi
        sleep 2
        elapsed=$((elapsed + 2))
        echo -n "."
    done

    echo ""
    echo "⚠️  MySQL is taking longer than expected to start."
    echo "    Check status with: docker-compose logs mysql"
else
    echo ""
    echo "❌ Failed to start containers. Check the error message above."
    exit 1
fi
