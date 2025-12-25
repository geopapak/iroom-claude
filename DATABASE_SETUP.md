# Database Setup Guide for iRoom

## Problem

You're seeing this error:
```
com.mysql.cj.jdbc.exceptions.CommunicationsException: Communications link failure
```

This means the Spring Boot application cannot connect to MySQL.

## Solutions

### Option 1: Docker (Recommended - Fastest Setup)

**Prerequisites:**
- Docker installed on your system

**Steps:**

```bash
# 1. Start MySQL using Docker
./start-mysql-docker.sh

# 2. (Optional) Start phpMyAdmin for database management
docker compose up -d phpmyadmin

# 3. Import your existing database (if you have a dump file)
docker exec -i iroom-mysql mysql -uiroom -piroom iRoom < your_database_dump.sql

# 4. Run the Spring Boot application
cd backend
mvn spring-boot:run
```

**Docker Commands:**

```bash
# Start MySQL
docker compose up -d mysql

# Stop MySQL
docker compose down

# View MySQL logs
docker logs iroom-mysql -f

# Access MySQL CLI
docker exec -it iroom-mysql mysql -uiroom -piroom iRoom

# Restart MySQL
docker compose restart mysql

# Remove MySQL (WARNING: deletes all data)
docker compose down -v
```

**phpMyAdmin Access:**
- URL: http://localhost:8081
- Username: `iroom`
- Password: `iroom`

---

### Option 2: Install MySQL Natively on Ubuntu

**Steps:**

```bash
# 1. Install MySQL Server
sudo apt update
sudo apt install mysql-server -y

# 2. Start MySQL service
sudo systemctl start mysql
sudo systemctl enable mysql

# 3. Check MySQL is running
sudo systemctl status mysql

# 4. Secure MySQL (set root password, remove test databases)
sudo mysql_secure_installation

# 5. Create database and user
sudo mysql << 'EOF'
CREATE DATABASE IF NOT EXISTS iRoom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'iroom'@'localhost' IDENTIFIED BY 'iroom';
GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';
FLUSH PRIVILEGES;
EOF

# 6. Test connection
mysql -u iroom -piroom -e "SHOW DATABASES;"

# 7. Import existing database (if you have a dump)
mysql -u iroom -piroom iRoom < your_database_dump.sql

# 8. Run Spring Boot application
cd backend
mvn spring-boot:run
```

**MySQL Service Commands:**

```bash
# Start MySQL
sudo systemctl start mysql

# Stop MySQL
sudo systemctl stop mysql

# Restart MySQL
sudo systemctl restart mysql

# Check status
sudo systemctl status mysql

# View logs
sudo journalctl -u mysql -f

# Access MySQL CLI
mysql -u iroom -piroom iRoom
```

---

### Option 3: Use Existing MySQL Server

If you already have MySQL running on a different host or port:

**1. Update `application.properties`:**

```properties
# For remote MySQL server
spring.datasource.url=jdbc:mysql://your-mysql-host:3306/iRoom?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true
spring.datasource.username=your-username
spring.datasource.password=your-password
```

**2. For different port:**

```properties
# If MySQL runs on port 3307 instead of 3306
spring.datasource.url=jdbc:mysql://localhost:3307/iRoom?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true
```

**3. Test connection:**

```bash
mysql -h your-mysql-host -P 3306 -u your-username -p
```

---

## Troubleshooting

### Error: "Access denied for user 'iroom'@'localhost'"

**Solution:**

```bash
# Reset user permissions
sudo mysql -e "DROP USER IF EXISTS 'iroom'@'localhost';"
sudo mysql -e "CREATE USER 'iroom'@'localhost' IDENTIFIED BY 'iroom';"
sudo mysql -e "GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

### Error: "Unknown database 'iRoom'"

**Solution:**

```bash
# Create the database
sudo mysql -e "CREATE DATABASE iRoom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Error: "Can't connect to local MySQL server through socket"

**Solutions:**

```bash
# Check if MySQL is running
sudo systemctl status mysql

# If not running, start it
sudo systemctl start mysql

# If using Docker, check container status
docker ps -a | grep mysql
```

### Error: "Port 3306 already in use" (Docker)

**Solutions:**

```bash
# Find what's using port 3306
sudo lsof -i :3306

# Option 1: Stop the existing MySQL
sudo systemctl stop mysql

# Option 2: Change Docker port in docker-compose.yml
# Change "3306:3306" to "3307:3306"
# Then update application.properties to use port 3307
```

### Flyway Migration Issues

If Flyway complains about schema version:

```bash
# Connect to MySQL
mysql -u iroom -piroom iRoom

# Check Flyway history
SELECT * FROM flyway_schema_history;

# If you need to repair Flyway
cd backend
mvn flyway:repair

# If you need to reset Flyway (WARNING: deletes migration history)
DROP TABLE flyway_schema_history;
```

---

## Importing Existing Database

If you have an existing iRoom database dump:

**Option 1: Using Docker:**

```bash
# Make sure MySQL container is running
docker compose up -d mysql

# Import the dump
docker exec -i iroom-mysql mysql -uiroom -piroom iRoom < path/to/your_dump.sql

# Verify import
docker exec -it iroom-mysql mysql -uiroom -piroom -e "SHOW TABLES FROM iRoom;"
```

**Option 2: Using Native MySQL:**

```bash
# Import the dump
mysql -u iroom -piroom iRoom < path/to/your_dump.sql

# Verify import
mysql -u iroom -piroom -e "SHOW TABLES FROM iRoom;"
```

---

## Verifying Database Connection

**Test from command line:**

```bash
# Test connection
mysql -u iroom -piroom -h localhost -P 3306 -e "SELECT 'Connection successful!' AS status;"

# List all tables
mysql -u iroom -piroom iRoom -e "SHOW TABLES;"

# Check table structure
mysql -u iroom -piroom iRoom -e "DESCRIBE User;"
```

**Test from Spring Boot:**

```bash
cd backend

# This will show connection attempts in the logs
mvn spring-boot:run | grep -i "database\|mysql\|flyway"
```

---

## Database Configuration Files

**Current configuration:**
- File: `backend/src/main/resources/application.properties`
- Database: `iRoom`
- Host: `localhost`
- Port: `3306`
- Username: `iroom`
- Password: `iroom`

**To change database credentials:**

Edit `application.properties`:
```properties
spring.datasource.url=jdbc:mysql://localhost:3306/iRoom?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true
spring.datasource.username=your-username
spring.datasource.password=your-password
```

Or use environment variables:
```bash
export DB_URL="jdbc:mysql://localhost:3306/iRoom"
export DB_USERNAME="iroom"
export DB_PASSWORD="iroom"

# Update application.properties to use env variables:
# spring.datasource.url=${DB_URL}
# spring.datasource.username=${DB_USERNAME}
# spring.datasource.password=${DB_PASSWORD}
```

---

## Quick Start (Docker - Recommended)

```bash
# One-line startup
./start-mysql-docker.sh && cd backend && mvn spring-boot:run
```

## Quick Start (Native MySQL)

```bash
# Install and setup MySQL
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo mysql -e "CREATE DATABASE IF NOT EXISTS iRoom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'iroom'@'localhost' IDENTIFIED BY 'iroom';"
sudo mysql -e "GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Run application
cd backend && mvn spring-boot:run
```

---

## Need Help?

1. **Check MySQL is running:**
   ```bash
   # Docker
   docker ps | grep mysql

   # Native
   sudo systemctl status mysql
   ```

2. **Check connection parameters:**
   ```bash
   cat backend/src/main/resources/application.properties | grep datasource
   ```

3. **View application logs:**
   ```bash
   cd backend
   mvn spring-boot:run 2>&1 | tee app.log
   ```

4. **Test database exists:**
   ```bash
   mysql -u iroom -piroom -e "SHOW DATABASES LIKE 'iRoom';"
   ```
