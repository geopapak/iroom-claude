# iRoom 2.0 - Deployment Guide

Complete guide to run the migrated Spring Boot + React application.

## 📋 Prerequisites

Before you begin, ensure you have:

- **Java 17** or higher
- **Maven 3.6+**
- **Node.js 18+** and npm
- **MySQL 8.0+** (already set up from PHP version)
- **Git**

## 🚀 Quick Start (5 Minutes)

### Step 1: Clone and Navigate

```bash
git clone <your-repo-url>
cd iroom-claude
```

### Step 2: Database Configuration

The application uses your **existing MySQL database** - no migration needed!

Edit `backend/src/main/resources/application.properties`:

```properties
spring.datasource.url=jdbc:mysql://localhost:3306/iRoom
spring.datasource.username=iroom
spring.datasource.password=YOUR_PASSWORD
```

### Step 3: Start the Backend

```bash
cd backend
mvn clean install
mvn spring-boot:run
```

Backend will start on: `http://localhost:8080`

You should see:
```
Started IroomApplication in X.XXX seconds
```

### Step 4: Start the Frontend

In a **new terminal**:

```bash
cd frontend
npm install
npm run dev
```

Frontend will start on: `http://localhost:3000`

### Step 5: Login

Open your browser to: `http://localhost:3000`

**Default credentials:**
- Email: `admin@admin.gr`
- Password: `admin`

## 📱 Available Dashboards

Based on user type, you'll be redirected to:

- **Admin** → `/admin` - System administration
- **Secretariat** → `/secretariat` - Full schedule management
- **Professor** → `/professor` - View schedule, book rooms
- **Student** → `/student` - View personalized schedule

## 🔧 Detailed Setup

### Backend Configuration

#### Database Setup

Your existing MySQL database works as-is! The Spring Boot entities map directly to your existing tables.

#### JWT Configuration

For production, change the JWT secret in `application.properties`:

```properties
jwt.secret=YourVerySecureRandomStringAtLeast256BitsLong
jwt.expiration=86400000
```

Generate a secure secret:
```bash
openssl rand -base64 64
```

#### CAS/SSO Configuration (Optional)

If you want to enable CAS/SSO login:

```properties
cas.server-url-prefix=https://sso.uowm.gr
cas.server-login-url=https://sso.uowm.gr/login
cas.client-host-url=https://your-domain.gr
```

### Frontend Configuration

#### API Endpoint

The frontend is configured to proxy API calls to `http://localhost:8080`.

If your backend runs elsewhere, update `frontend/vite.config.js`:

```javascript
server: {
  proxy: {
    '/api': {
      target: 'http://your-backend-url:8080',
      changeOrigin: true
    }
  }
}
```

#### Build for Production

```bash
cd frontend
npm run build
```

This creates optimized files in `frontend/dist/`

## 🌐 Production Deployment

### Backend (Spring Boot)

#### Build JAR

```bash
cd backend
mvn clean package -DskipTests
```

This creates: `target/iroom-2.0.0.jar`

#### Run in Production

```bash
java -jar target/iroom-2.0.0.jar \
  --spring.profiles.active=prod \
  --server.port=8080
```

#### As a Service (systemd)

Create `/etc/systemd/system/iroom-backend.service`:

```ini
[Unit]
Description=iRoom Backend
After=syslog.target network.target

[Service]
User=iroom
ExecStart=/usr/bin/java -jar /opt/iroom/iroom-2.0.0.jar
SuccessExitStatus=143

[Install]
WantedBy=multi-user.target
```

Enable and start:
```bash
sudo systemctl enable iroom-backend
sudo systemctl start iroom-backend
sudo systemctl status iroom-backend
```

### Frontend (React)

#### Option 1: Nginx

Build the frontend:
```bash
cd frontend
npm run build
```

Nginx configuration (`/etc/nginx/sites-available/iroom`):

```nginx
server {
    listen 80;
    server_name iroom.yourdomain.gr;

    root /var/www/iroom/frontend/dist;
    index index.html;

    # Frontend
    location / {
        try_files $uri $uri/ /index.html;
    }

    # Backend API
    location /api {
        proxy_pass http://localhost:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/iroom /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### Option 2: Serve with Node

```bash
cd frontend
npm install -g serve
serve -s dist -p 3000
```

#### Option 3: Deploy to Vercel/Netlify

Frontend can be deployed to Vercel or Netlify:

```bash
# Vercel
npm install -g vercel
cd frontend
vercel

# Netlify
npm install -g netlify-cli
cd frontend
netlify deploy --prod
```

Update API base URL in `frontend/src/services/api.js` to your backend domain.

### Docker Deployment (Optional)

#### Backend Dockerfile

Create `backend/Dockerfile`:

```dockerfile
FROM eclipse-temurin:17-jdk-alpine
WORKDIR /app
COPY target/iroom-2.0.0.jar app.jar
EXPOSE 8080
ENTRYPOINT ["java", "-jar", "app.jar"]
```

#### Frontend Dockerfile

Create `frontend/Dockerfile`:

```dockerfile
FROM node:18-alpine as build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM nginx:alpine
COPY --from=build /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
```

#### Docker Compose

Create `docker-compose.yml`:

```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: iRoom
      MYSQL_USER: iroom
      MYSQL_PASSWORD: iroom
    ports:
      - "3306:3306"
    volumes:
      - mysql-data:/var/lib/mysql

  backend:
    build: ./backend
    ports:
      - "8080:8080"
    depends_on:
      - mysql
    environment:
      SPRING_DATASOURCE_URL: jdbc:mysql://mysql:3306/iRoom
      SPRING_DATASOURCE_USERNAME: iroom
      SPRING_DATASOURCE_PASSWORD: iroom

  frontend:
    build: ./frontend
    ports:
      - "80:80"
    depends_on:
      - backend

volumes:
  mysql-data:
```

Run:
```bash
docker-compose up -d
```

## 🔒 Security Checklist

Before going to production:

- [ ] Change default admin password
- [ ] Generate secure JWT secret (256+ bits)
- [ ] Enable HTTPS (Let's Encrypt recommended)
- [ ] Configure CORS for production domain only
- [ ] Update database credentials
- [ ] Set up firewall rules
- [ ] Enable MySQL SSL connection
- [ ] Configure CAS/SSO properly
- [ ] Set up backup system
- [ ] Configure logging levels
- [ ] Enable rate limiting
- [ ] Review Spring Security settings

## 🧪 Testing the Application

### Test Backend

```bash
# Health check
curl http://localhost:8080/actuator/health

# Test login
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@admin.gr","password":"admin"}'
```

### Test Frontend

1. Open `http://localhost:3000`
2. Login with admin credentials
3. Check each dashboard:
   - Admin dashboard
   - Secretariat dashboard (test notifications)
   - Professor dashboard
   - Student dashboard

## 🐛 Troubleshooting

### Backend Issues

**Problem:** Port 8080 already in use

```bash
# Find process
lsof -i :8080

# Kill process
kill -9 <PID>

# Or change port in application.properties
server.port=8081
```

**Problem:** Database connection error

- Check MySQL is running: `systemctl status mysql`
- Verify credentials in `application.properties`
- Test connection: `mysql -u iroom -p iRoom`

**Problem:** JWT errors

- Ensure jwt.secret is at least 256 bits
- Check token in browser localStorage
- Verify Authorization header format

### Frontend Issues

**Problem:** API calls fail with CORS error

- Check CORS configuration in `backend/src/main/resources/application.properties`
- Ensure frontend origin is in `cors.allowed-origins`

**Problem:** npm install fails

```bash
# Clear cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

**Problem:** White screen after login

- Check browser console for errors
- Verify API endpoint configuration
- Check if backend is running

## 📊 Monitoring

### Backend Logs

```bash
# View logs
tail -f logs/spring-boot-application.log

# With systemd
journalctl -u iroom-backend -f
```

### Database Monitoring

```bash
# MySQL processlist
mysql -u root -p -e "SHOW PROCESSLIST;"

# Slow queries
mysql -u root -p -e "SHOW VARIABLES LIKE 'slow_query%';"
```

## 🔄 Updating the Application

```bash
# Pull latest changes
git pull origin main

# Update backend
cd backend
mvn clean install
sudo systemctl restart iroom-backend

# Update frontend
cd frontend
npm install
npm run build
# Copy dist/ to production server
```

## 📈 Performance Optimization

### Backend

- Enable Hibernate query caching
- Configure connection pooling (HikariCP is default)
- Enable GZIP compression
- Set up CDN for static assets

### Frontend

- Use production build (`npm run build`)
- Enable CDN for Material-UI
- Implement lazy loading for routes
- Add service worker for caching

## 📞 Support

For issues:
1. Check this deployment guide
2. Review application logs
3. Check `MIGRATION_SUMMARY.md` for architecture details
4. Review `README_NEW.md` for complete documentation

## ✅ Post-Deployment Checklist

- [ ] Backend running and accessible
- [ ] Frontend running and accessible
- [ ] Login works for all user types
- [ ] Database connection successful
- [ ] Notifications working (check 5-second polling)
- [ ] Schedule grid displays correctly
- [ ] HTTPS enabled (production)
- [ ] Backups configured
- [ ] Monitoring set up
- [ ] Documentation updated

---

**Congratulations!** Your iRoom application is now running on modern Spring Boot + React architecture! 🎉
