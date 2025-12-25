#!/bin/bash

# iRoom Quick Start Script for Local Development
# This script helps you get started with the iRoom project

echo "========================================="
echo "iRoom - Local Development Quick Start"
echo "========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.0 or higher."
    exit 1
fi

echo "✓ PHP is installed: $(php -v | head -n 1)"

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL is not installed. Please install MySQL or MariaDB."
    exit 1
fi

echo "✓ MySQL is installed: $(mysql --version)"
echo ""

# Check if connectDB.php exists
if [ ! -f "connectDB.php" ]; then
    echo "⚠️  connectDB.php not found. Creating from template..."
    if [ -f "connectDBTEMPLATE.php" ]; then
        cp connectDBTEMPLATE.php connectDB.php
        echo "✓ Created connectDB.php from template"
        echo "⚠️  Please edit connectDB.php with your database credentials"
    else
        echo "❌ connectDBTEMPLATE.php not found"
    fi
else
    echo "✓ connectDB.php exists"
fi

echo ""
echo "========================================="
echo "Setup Options"
echo "========================================="
echo ""
echo "1. Setup Database (run createDB.php)"
echo "2. Start PHP Built-in Server"
echo "3. View Setup Guide"
echo "4. Exit"
echo ""
read -p "Select an option (1-4): " option

case $option in
    1)
        echo ""
        echo "Setting up database..."
        echo "⚠️  Make sure you've updated database credentials in createDB.php"
        read -p "Continue? (y/n): " confirm
        if [ "$confirm" = "y" ]; then
            php createDB.php
            if [ $? -eq 0 ]; then
                echo "✓ Database setup completed successfully!"
            else
                echo "❌ Database setup failed. Please check your credentials and try again."
            fi
        fi
        ;;
    2)
        echo ""
        echo "Starting PHP built-in server..."
        echo "Server will run at: http://localhost:8000"
        echo "Press Ctrl+C to stop the server"
        echo ""
        php -S localhost:8000
        ;;
    3)
        echo ""
        if [ -f "SETUP_GUIDE.md" ]; then
            cat SETUP_GUIDE.md
        else
            echo "❌ SETUP_GUIDE.md not found"
        fi
        ;;
    4)
        echo "Goodbye!"
        exit 0
        ;;
    *)
        echo "Invalid option"
        exit 1
        ;;
esac
