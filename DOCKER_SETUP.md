# Docker Setup Guide for iRoom

This guide explains how to run the iRoom application using Docker for the MySQL database.

## Prerequisites

- Docker installed ([Download Docker](https://www.docker.com/products/docker-desktop))
- Docker Compose installed (included with Docker Desktop)

## Quick Start

### 1. Stop XAMPP MySQL (if running)

If you're currently using XAMPP, **stop the MySQL service** to free up port 3306:
- Open XAMPP Control Panel
- Click "Stop" next to MySQL

### 2. Start Docker MySQL

From the project root directory, run:

```bash
docker-compose up -d
```

This command will:
- Download the MySQL 8.0 image (first time only)
- Create and start the MySQL container
- Create and start the phpMyAdmin container
- Create a persistent volume for database data

### 3. Verify Containers are Running

```bash
docker-compose ps
```

You should see both `iroom-mysql` and `iroom-phpmyadmin` containers running.

### 4. Wait for MySQL to be Ready

The MySQL container has a health check that ensures it's fully ready. Wait about 30 seconds after starting, then check:

```bash
docker-compose ps
```

The mysql service should show as "healthy" in the status.

### 5. Start the Backend

```bash
cd backend
mvn spring-boot:run
```

Flyway will automatically:
- Create the database schema
- Run all migrations
- Insert default data

### 6. Start the Frontend

```bash
cd frontend
npm run dev
```

## Accessing Services

### MySQL Database
- **Host:** localhost
- **Port:** 3306
- **Database:** iRoom
- **Username:** iroom
- **Password:** iroom
- **Root Password:** root

### phpMyAdmin (Web UI for MySQL)
- **URL:** http://localhost:8081
- **Server:** mysql
- **Username:** iroom
- **Password:** iroom

You can use phpMyAdmin to:
- Browse database tables
- Run SQL queries
- Import/Export data
- View Flyway migration history

## Common Docker Commands

### Start containers (detached mode)
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose stop
```

### Stop and remove containers
```bash
docker-compose down
```

### Stop and remove containers + volumes (⚠️ deletes all data)
```bash
docker-compose down -v
```

### View container logs
```bash
# All logs
docker-compose logs

# Follow logs in real-time
docker-compose logs -f

# MySQL logs only
docker-compose logs mysql

# phpMyAdmin logs only
docker-compose logs phpmyadmin
```

### Restart containers
```bash
docker-compose restart
```

### View running containers
```bash
docker-compose ps
```

### Execute MySQL commands directly
```bash
# Connect to MySQL CLI
docker exec -it iroom-mysql mysql -u root -proot iRoom

# Or as iroom user
docker exec -it iroom-mysql mysql -u iroom -piroom iRoom
```

## Troubleshooting

### Port 3306 is already in use

**Error:** `Bind for 0.0.0.0:3306 failed: port is already allocated`

**Solution:** Another MySQL instance is running. Stop it:
- **XAMPP:** Stop MySQL in XAMPP Control Panel
- **Windows Services:** Stop MySQL service
- **Linux/Mac:** `sudo systemctl stop mysql` or `brew services stop mysql`

### Container won't start

Check logs:
```bash
docker-compose logs mysql
```

### Database connection refused

Wait 30 seconds for MySQL to fully initialize, then check health:
```bash
docker-compose ps
```

If still failing, restart:
```bash
docker-compose restart mysql
```

### Reset database (start fresh)

```bash
# Stop and remove everything including data
docker-compose down -v

# Start again
docker-compose up -d

# Wait for MySQL to be ready (30 seconds)
# Then restart backend to run Flyway migrations
```

### Can't access phpMyAdmin

1. Check if container is running:
   ```bash
   docker-compose ps
   ```

2. Check logs:
   ```bash
   docker-compose logs phpmyadmin
   ```

3. Wait for MySQL to be healthy (phpMyAdmin depends on it)

4. Try restarting:
   ```bash
   docker-compose restart phpmyadmin
   ```

## Data Persistence

The database data is stored in a Docker volume named `iroom_mysql_data`. This means:

✅ **Data persists** when you stop/restart containers
✅ **Data persists** when you run `docker-compose down`
❌ **Data is deleted** when you run `docker-compose down -v`

### Backup Database

```bash
# Create backup
docker exec iroom-mysql mysqldump -u root -proot iRoom > backup.sql

# Restore backup
docker exec -i iroom-mysql mysql -u root -proot iRoom < backup.sql
```

## Switching Back to XAMPP

If you want to switch back to XAMPP:

1. Stop Docker containers:
   ```bash
   docker-compose down
   ```

2. Start XAMPP MySQL

3. The application.properties is already configured for localhost:3306, so it will work with both!

## Benefits of Docker Setup

✅ **Consistent Environment** - Same MySQL version for all developers
✅ **Easy Setup** - One command to start database
✅ **Isolated** - Doesn't interfere with system MySQL
✅ **phpMyAdmin Included** - Web UI for database management
✅ **Data Persistence** - Data survives container restarts
✅ **Version Control** - docker-compose.yml in git
✅ **Production-like** - Closer to deployment environment

## Configuration Files

- **docker-compose.yml** - Defines MySQL and phpMyAdmin services
- **backend/src/main/resources/application.properties** - Database connection settings

Database settings are already configured correctly:
```properties
spring.datasource.url=jdbc:mysql://localhost:3306/iRoom
spring.datasource.username=iroom
spring.datasource.password=iroom
```

## Next Steps

After starting Docker MySQL:

1. **Register a new admin user** - Use the "Εγγραφή" tab on login page
2. **Or login with default admin** - Check if admin@iroom.gr exists in database
3. **Create departments** - Add university departments
4. **Create users** - Use "Δημιουργία Χρήστη" button in admin dashboard
5. **Import existing data** - Use phpMyAdmin if you have existing data

## Support

If you encounter issues:

1. Check container logs: `docker-compose logs`
2. Verify containers are healthy: `docker-compose ps`
3. Try restarting: `docker-compose restart`
4. Reset everything: `docker-compose down -v && docker-compose up -d`
