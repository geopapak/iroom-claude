# Windows MySQL Setup Guide for iRoom

## Error You're Seeing

```
Error creating bean with name 'userRepository':
Cannot resolve reference to bean 'jpaSharedEM_entityManagerFactory'
```

**Cause:** Spring Boot cannot connect to MySQL database.

---

## ✅ Solution 1: Docker Desktop (Recommended)

### Prerequisites
- Install Docker Desktop for Windows: https://www.docker.com/products/docker-desktop/

### Steps

1. **Start Docker Desktop**
   - Find "Docker Desktop" in Start menu
   - Wait for Docker to fully start (whale icon in system tray)

2. **Start MySQL Container**
   ```bash
   # Open PowerShell in project directory
   cd C:\Users\geo_p\OneDrive\Υπολογιστής\Vertoyo\mantis\vdp-war\iroom-claude

   # Start MySQL
   docker compose up -d mysql

   # Verify it's running
   docker ps
   ```

3. **Verify MySQL is Ready**
   ```bash
   # Wait 10 seconds, then test connection
   docker exec -it iroom-mysql mysql -uiroom -piroom -e "SELECT 'Connected!' AS status;"
   ```

4. **Run Spring Boot**
   ```bash
   cd backend
   mvn spring-boot:run
   ```

---

## ✅ Solution 2: XAMPP (Easiest for Windows)

### Download and Install

1. **Download XAMPP:** https://www.apachefriends.org/download.html
2. **Install XAMPP** - Use default settings
3. **Start XAMPP Control Panel** from Start menu

### Configure MySQL

1. **Start MySQL** in XAMPP Control Panel (click "Start" button)

2. **Open phpMyAdmin**
   - Click "Admin" button next to MySQL in XAMPP
   - Or visit: http://localhost/phpmyadmin

3. **Create Database**
   - Click "New" in left sidebar
   - Database name: `iRoom`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. **Create User**
   - Click "User accounts" tab
   - Click "Add user account"
   - Username: `iroom`
   - Host: `localhost`
   - Password: `iroom`
   - Check "Grant all privileges on database iRoom"
   - Click "Go"

5. **Run Spring Boot**
   ```bash
   cd backend
   mvn spring-boot:run
   ```

---

## ✅ Solution 3: Native MySQL Installation

### Download and Install

1. **Download MySQL Installer**
   - Visit: https://dev.mysql.com/downloads/installer/
   - Download "mysql-installer-community-8.0.x.msi"

2. **Run Installer**
   - Choose "Developer Default" or "Server only"
   - Set root password (remember it!)
   - Keep default port: 3306
   - Configure as Windows Service (auto-start)

### Configure Database

1. **Open MySQL Command Line Client**
   - Find in Start menu: "MySQL 8.0 Command Line Client"
   - Enter root password

2. **Run Setup Commands**
   ```sql
   CREATE DATABASE iRoom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'iroom'@'localhost' IDENTIFIED BY 'iroom';
   GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';
   FLUSH PRIVILEGES;
   SHOW DATABASES;
   EXIT;
   ```

3. **Test Connection**
   ```bash
   # Open new Command Prompt
   mysql -u iroom -piroom -e "SHOW DATABASES;"
   ```

4. **Run Spring Boot**
   ```bash
   cd backend
   mvn spring-boot:run
   ```

---

## 🔧 Troubleshooting

### Issue: "Access denied for user 'iroom'@'localhost'"

**Fix:**
```sql
# Open MySQL as root
mysql -u root -p

# Reset user
DROP USER IF EXISTS 'iroom'@'localhost';
CREATE USER 'iroom'@'localhost' IDENTIFIED BY 'iroom';
GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';
FLUSH PRIVILEGES;
```

### Issue: "Unknown database 'iRoom'"

**Fix:**
```sql
# Create database
mysql -u root -p -e "CREATE DATABASE iRoom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Issue: "Port 3306 already in use"

**Check what's using port 3306:**
```bash
# PowerShell
netstat -ano | findstr :3306
```

**Solutions:**
1. Stop other MySQL/MariaDB services in Windows Services
2. Or change port in `application.properties`:
   ```properties
   spring.datasource.url=jdbc:mysql://localhost:3307/iRoom?useSSL=false&serverTimezone=UTC
   ```

### Issue: Flyway Migration Errors

**Option 1: Disable Flyway temporarily**

Edit `backend/src/main/resources/application.properties`:
```properties
# Change this line:
spring.flyway.enabled=false
```

**Option 2: Check Flyway status**
```bash
cd backend
mvn flyway:info
```

### Issue: Still getting EntityManagerFactory errors

**Check connection manually:**
```bash
# Test MySQL connection
mysql -u iroom -piroom -h localhost -P 3306 iRoom -e "SELECT 1;"
```

**If connection works but Spring Boot fails:**

1. **Check application.properties** has correct values:
   ```properties
   spring.datasource.url=jdbc:mysql://localhost:3306/iRoom?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true
   spring.datasource.username=iroom
   spring.datasource.password=iroom
   ```

2. **Clean and rebuild:**
   ```bash
   cd backend
   mvn clean install
   mvn spring-boot:run
   ```

3. **Check Java version:**
   ```bash
   java -version
   # Should be Java 17 or higher
   ```

---

## 📋 Quick Checklist

Before running Spring Boot, verify:

- [ ] MySQL is installed and running
  - Docker: `docker ps | grep mysql`
  - XAMPP: Check XAMPP Control Panel
  - Native: Check Windows Services for "MySQL80"

- [ ] Database `iRoom` exists
  ```bash
  mysql -u iroom -piroom -e "SHOW DATABASES LIKE 'iRoom';"
  ```

- [ ] User `iroom` has access
  ```bash
  mysql -u iroom -piroom -e "SELECT 'Success!';"
  ```

- [ ] Port 3306 is accessible
  ```bash
  telnet localhost 3306
  # Or: Test-NetConnection localhost -Port 3306
  ```

- [ ] Java 17+ is installed
  ```bash
  java -version
  ```

- [ ] Maven is working
  ```bash
  mvn -version
  ```

---

## 🚀 Recommended Setup (Step by Step)

**For quickest setup on Windows, use XAMPP:**

```bash
# 1. Download and install XAMPP
# https://www.apachefriends.org/download.html

# 2. Start XAMPP Control Panel
# Click Start for MySQL

# 3. Open phpMyAdmin (http://localhost/phpmyadmin)
# Create database: iRoom
# Create user: iroom / iroom with all privileges

# 4. Navigate to project
cd C:\Users\geo_p\OneDrive\Υπολογιστής\Vertoyo\mantis\vdp-war\iroom-claude

# 5. Build and run backend
cd backend
mvn clean install
mvn spring-boot:run

# 6. In new terminal, run frontend
cd frontend
npm install
npm run dev
```

**Access:**
- Frontend: http://localhost:3000
- Backend: http://localhost:8080
- phpMyAdmin: http://localhost/phpmyadmin

---

## 💡 Tips

1. **Always start MySQL before Spring Boot**
2. **Check MySQL is running** before each startup
3. **Use phpMyAdmin** (XAMPP) or **MySQL Workbench** for easy database management
4. **Import existing data** if you have a database dump
5. **Disable Flyway** if you just want to test the connection first

---

## Need More Help?

Run this diagnostic command and share the output:

```bash
# PowerShell diagnostic
echo "=== Java Version ===" && java -version
echo ""
echo "=== Maven Version ===" && mvn -version
echo ""
echo "=== MySQL Check ===" && mysql -u iroom -piroom -e "SELECT VERSION();" 2>&1
echo ""
echo "=== Port 3306 Check ===" && netstat -ano | findstr :3306
```
