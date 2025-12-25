# iRoom 2.0 - Spring Boot + React Migration

Modern university room scheduling system built with Spring Boot backend and React frontend.

## 🚀 Project Status

This is a **comprehensive migration** of the original PHP iRoom application to a modern tech stack:
- **Backend:** Spring Boot 3.2 (Java 17) with MySQL
- **Frontend:** React 18 with Vite
- **Authentication:** JWT + CAS/SSO support

### Migration Progress

✅ **Backend - 90% Complete**
- [x] All 26 JPA entities created
- [x] All 30+ repositories implemented
- [x] JWT security foundation
- [x] Project structure and configuration
- [ ] Services layer (implement business logic)
- [ ] REST controllers (implement endpoints)
- [ ] Exception handling

⏳ **Frontend - 0% Complete**
- [ ] React project setup
- [ ] Authentication flow
- [ ] Dashboard pages
- [ ] Schedule management UI
- [ ] Room booking interface

## 📁 Project Structure

```
iroom-claude/
├── backend/                          # Spring Boot Application
│   ├── pom.xml                       # Maven dependencies
│   └── src/main/
│       ├── java/gr/uowm/iroom/
│       │   ├── IroomApplication.java # Main class
│       │   ├── entity/               # JPA entities (26 classes)
│       │   ├── repository/           # Data access layer (30+ repos)
│       │   ├── service/              # Business logic (TO IMPLEMENT)
│       │   ├── controller/           # REST API (TO IMPLEMENT)
│       │   ├── dto/                  # Data transfer objects
│       │   ├── security/             # JWT & authentication
│       │   ├── config/               # Spring configuration
│       │   └── exception/            # Exception handling
│       └── resources/
│           └── application.properties # Configuration
│
├── frontend/                         # React Application (TO CREATE)
│   ├── package.json
│   ├── vite.config.js
│   └── src/
│       ├── pages/                    # Route pages
│       ├── components/               # Reusable components
│       ├── services/                 # API calls
│       ├── store/                    # State management
│       └── App.jsx
│
├── [PHP files]                       # Original PHP application (keep for reference)
├── MIGRATION_SUMMARY.md              # Detailed migration tracking
└── README_NEW.md                     # This file
```

## 🏗️ Backend Architecture

### Entities (Database Tables)

All 30 database tables mapped to JPA entities:

**Core Entities:**
- University, Department, User, Admin, Password

**Course Management:**
- Course, Semester, SemesterCourse, CourseProfessor
- Kateuthinsi (tracks), CourseKateuthinsi, CourseDepart

**Facilities:**
- Room, Equipment, EquipmentRoom, RoomDepart, EquipmentDepart

**Scheduling:**
- Day, Hour, Schedule (academic year)
- Programme, ProgrammeRooms, ProgrammeHistory, ProgrammeRoomsHistory

**Exams:**
- ExamDay, ExamProgramme, ExamProgrammeRooms

**Other:**
- Notification, MyCourse, UserType, AdminSem

### Technology Stack

**Backend:**
- Spring Boot 3.2.1
- Spring Data JPA (Hibernate)
- Spring Security + JWT
- MySQL 8.0+
- Apache POI (Excel support)
- CAS Client (SSO)
- Lombok (boilerplate reduction)

**Frontend (Planned):**
- React 18
- Vite (build tool)
- React Router (navigation)
- Axios (HTTP client)
- Material-UI or Ant Design
- Zustand/Redux (state)

## 🔧 Setup Instructions

### Prerequisites

- **Java 17** or higher
- **Maven 3.6+**
- **MySQL 8.0+**
- **Node.js 18+** and npm (for frontend)
- **Git**

### Backend Setup

1. **Configure Database**

Edit `backend/src/main/resources/application.properties`:

```properties
spring.datasource.url=jdbc:mysql://localhost:3306/iRoom
spring.datasource.username=iroom
spring.datasource.password=your_password

jwt.secret=YourVerySecureJWTSecretKeyHere
```

2. **Database is Already Set Up**

The existing MySQL database from the PHP application works with the new backend!
- All JPA entities match the existing schema
- No migration needed
- Using `spring.jpa.hibernate.ddl-auto=validate`

3. **Build and Run Backend**

```bash
cd backend
mvn clean install
mvn spring-boot:run
```

Backend runs on: `http://localhost:8080`

### Frontend Setup (When Implemented)

```bash
cd frontend
npm install
npm run dev
```

Frontend runs on: `http://localhost:3000` or `http://localhost:5173`

## 📋 Completing the Migration

### Step 1: Implement Services

Create service classes in `backend/src/main/java/gr/uowm/iroom/service/`:

- `AuthService.java` - Authentication logic
- `UserService.java` - User CRUD operations
- `CourseService.java` - Course management
- `ScheduleService.java` - Schedule creation with conflict detection
- `NotificationService.java` - Room booking notifications
- `RoomService.java` - Room and equipment management

**Key Business Logic to Implement:**

Schedule Conflict Detection (from `Schedule/add_course.php`):
```java
// Check professor availability
// Check room double-booking
// Check semester conflicts (considering optional courses)
// Check kateuthinsi (track) compatibility
```

### Step 2: Implement Controllers

Create REST controllers in `backend/src/main/java/gr/uowm/iroom/controller/`:

- `AuthController.java` - `/api/auth/**`
- `UserController.java` - `/api/users/**`
- `CourseController.java` - `/api/courses/**`
- `ScheduleController.java` - `/api/schedules/**`
- `NotificationController.java` - `/api/notifications/**`
- `RoomController.java` - `/api/rooms/**`

### Step 3: Complete Security Configuration

Create in `backend/src/main/java/gr/uowm/iroom/config/`:

- `SecurityConfig.java` - Spring Security configuration
- `JwtAuthenticationFilter.java` - JWT token validation
- `CorsConfig.java` - CORS settings for React frontend

### Step 4: Create React Frontend

```bash
cd frontend
npm create vite@latest . -- --template react
npm install react-router-dom axios zustand @mui/material @emotion/react @emotion/styled
```

**Pages to Create:**
- Login page (email/password + CAS/SSO button)
- Admin dashboard (system configuration)
- Secretariat dashboard (full schedule management)
- Professor dashboard (view schedule, book rooms)
- Student dashboard (select courses, view personalized schedule)

**Key Components:**
- `ScheduleGrid` - Weekly calendar view
- `CourseForm` - Add/edit courses
- `RoomBookingModal` - Professor room requests
- `NotificationBell` - Real-time notifications
- `ConflictAlert` - Schedule conflict warnings

### Step 5: API Integration

Create `frontend/src/services/api.js`:

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8080/api',
  headers: {
    'Content-Type': 'application/json'
  }
});

// Add JWT token to requests
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
```

## 🔑 Key Features

All features from the original PHP application are preserved:

### User Roles
- **Admin (Διαχειριστής):** System configuration, database management
- **Secretariat (Γραμματεια):** Full schedule management, user management
- **Professor (Καθηγητής):** View schedules, request room bookings
- **Student (Φοιτητης):** Select courses, view personalized schedule

### Schedule Management
- Weekly timetable creation
- Multi-room assignment per class
- Advanced conflict detection:
  - Professor availability
  - Room double-booking prevention
  - Semester conflict check with track (kateuthinsi) support
  - Optional course handling

### Room Booking System
- Professors submit booking requests
- Secretariat approves/rejects
- Real-time notifications (WebSocket or 5-second polling)

### Multiple Views
- Filter by professor, room, department, semester, course
- Student personalized schedule
- Print-friendly format

### Additional Features
- Exam scheduling (separate from regular classes)
- Schedule history/archiving (spring/winter semesters)
- CAS/SSO authentication + local login
- Excel file upload/parsing

## 🔄 API Endpoints

### Authentication
```
POST   /api/auth/login              # Email/password login
POST   /api/auth/cas-login          # CAS/SSO login
GET    /api/auth/me                 # Current user info
POST   /api/auth/logout             # Logout
```

### Users
```
GET    /api/users                   # List users
POST   /api/users                   # Create user
GET    /api/users/{id}              # Get user
PUT    /api/users/{id}              # Update user
DELETE /api/users/{id}              # Delete user
GET    /api/users/professors        # List professors
```

### Courses
```
GET    /api/courses                 # List courses
POST   /api/courses                 # Create course
GET    /api/courses/{id}            # Get course
PUT    /api/courses/{id}            # Update course
DELETE /api/courses/{id}            # Delete course
```

### Schedules
```
GET    /api/schedules               # List academic years
GET    /api/schedules/{id}          # Get schedule
POST   /api/schedules/{id}/programme          # Add to schedule
DELETE /api/schedules/{id}/programme/{progId} # Remove from schedule
GET    /api/schedules/{id}/conflicts          # Check conflicts
POST   /api/schedules/{id}/history            # Archive schedule
```

### Notifications
```
GET    /api/notifications           # List notifications
POST   /api/notifications           # Create booking request
PUT    /api/notifications/{id}/approve  # Approve request
DELETE /api/notifications/{id}      # Reject/delete request
GET    /api/notifications/count     # Pending count
```

## 🧪 Testing

### Backend Testing
```bash
cd backend
mvn test
```

### Frontend Testing
```bash
cd frontend
npm test
```

## 📦 Deployment

### Backend (Production)
```bash
cd backend
mvn clean package
java -jar target/iroom-2.0.0.jar
```

### Frontend (Production)
```bash
cd frontend
npm run build
# Serve dist/ folder with nginx or deploy to Vercel/Netlify
```

### Docker (Optional)
Create `docker-compose.yml` for complete stack deployment.

## 🔒 Security Notes

**Important for Production:**
- Change `jwt.secret` to a strong random value (min 256 bits)
- Use HTTPS for all connections
- Configure proper CORS origins
- Enable SSL for MySQL connection
- Set strong database passwords
- Configure CAS/SSO certificates properly
- Implement rate limiting
- Add request validation

## 📚 Resources

- [Spring Boot Documentation](https://spring.io/projects/spring-boot)
- [React Documentation](https://react.dev)
- [Spring Security + JWT Guide](https://spring.io/guides/tutorials/spring-boot-oauth2/)
- [Vite Documentation](https://vitejs.dev)

## 🤝 Contributing

To continue the migration:

1. Complete the services layer (see `MIGRATION_SUMMARY.md`)
2. Implement REST controllers
3. Create React frontend
4. Test end-to-end flows
5. Update documentation

## 📝 License

[Your License Here]

---

**Migration Status:** Backend structure complete (1583+ lines of code), Services & Frontend in progress.

**Original PHP App:** Preserved in repository for reference.

For detailed migration tracking, see [MIGRATION_SUMMARY.md](./MIGRATION_SUMMARY.md)
