# iRoom Frontend Migration Plan
## PHP/HTML to React Migration

This document outlines the complete migration from the legacy PHP/HTML frontend (178 PHP files) to a modern React application.

---

## Current Status

### ✅ Completed Features

#### Authentication & User Management
- [x] Login page with email/password
- [x] Registration page for new admin users
- [x] JWT authentication
- [x] Protected routes
- [x] User creation modal (Admin dashboard)
- [x] User list display

#### Dashboards (Basic Structure)
- [x] Admin Dashboard (basic)
- [x] Professor Dashboard (basic)
- [x] Student Dashboard (basic)
- [x] Secretariat Dashboard (basic with notifications)

#### Components
- [x] ScheduleGrid component
- [x] CreateUserModal component
- [x] AppBar with logout
- [x] Navigation and routing

---

## 🚧 Missing Features (To Be Migrated)

### 1. **Admin Dashboard - Complete Management**

#### A. User Management (Enhanced)
- [ ] Full CRUD operations UI
- [ ] User search and filtering
- [ ] Bulk user import (CSV)
- [ ] User role assignment
- [ ] Password reset functionality
- [ ] User activity logs

#### B. Department Management
- [ ] Create/Edit/Delete departments
- [ ] Department list with search
- [ ] Assign departments to universities
- [ ] Department configuration (semesters, courses)

#### C. Room Management
- [ ] Create/Edit/Delete rooms
- [ ] Room list with filtering
- [ ] Room capacity settings
- [ ] Equipment assignment to rooms
- [ ] Room availability calendar
- [ ] Room conflict detection

#### D. Course Management
- [ ] Create/Edit/Delete courses
- [ ] Course list with search and filters
- [ ] Assign courses to departments
- [ ] Assign professors to courses
- [ ] Course semester assignment
- [ ] Optional/mandatory course flags
- [ ] Course prerequisites

#### E. Equipment Management
- [ ] Create/Edit/Delete equipment
- [ ] Equipment catalog
- [ ] Assign equipment to rooms
- [ ] Equipment availability tracking

#### F. Schedule Management (Admin)
- [ ] Create new academic year schedules
- [ ] Bulk schedule import
- [ ] Manual schedule editing
- [ ] Schedule validation (conflict detection)
- [ ] Schedule templates
- [ ] Copy schedule from previous year

#### G. System Configuration
- [ ] Academic year settings
- [ ] Semester configuration
- [ ] Time slot configuration (hours)
- [ ] Holiday/break configuration
- [ ] System-wide settings

#### H. Reports & Analytics
- [ ] Room utilization reports
- [ ] Professor workload reports
- [ ] Course enrollment reports
- [ ] Schedule conflict reports
- [ ] Export to PDF/Excel
- [ ] Print views

### 2. **Professor Dashboard - Enhanced**

#### A. My Schedule
- [ ] Weekly view of assigned classes
- [ ] Monthly calendar view
- [ ] Print personal schedule
- [ ] Export schedule (PDF/iCal)
- [ ] Schedule change notifications

#### B. My Courses
- [ ] List of assigned courses
- [ ] Course details (students, room, time)
- [ ] Course materials management
- [ ] Student list for each course

#### C. Room Booking
- [ ] Search available rooms
- [ ] Submit room booking request
- [ ] View booking history
- [ ] Cancel pending bookings
- [ ] Booking status tracking

#### D. Notifications
- [ ] Booking approval/rejection notifications
- [ ] Schedule change alerts
- [ ] System announcements

### 3. **Student Dashboard - Enhanced**

#### A. My Schedule
- [ ] Personalized schedule based on selected courses
- [ ] Course selection interface
- [ ] Add/drop courses (if allowed)
- [ ] Weekly/monthly views
- [ ] Export schedule

#### B. Course Catalog
- [ ] Browse available courses
- [ ] Filter by semester/department/type
- [ ] View course details
- [ ] View professor information
- [ ] View room and time information

#### C. Exam Schedule
- [ ] View exam dates and times
- [ ] Export exam schedule
- [ ] Exam room information
- [ ] Conflict warnings

### 4. **Secretariat Dashboard - Enhanced**

#### A. Schedule Management
- [ ] Edit department schedule
- [ ] Assign rooms to courses
- [ ] Assign professors to time slots
- [ ] Drag-and-drop schedule editing
- [ ] Conflict detection and warnings
- [ ] Schedule validation

#### B. Room Booking Management
- [ ] View all pending bookings
- [ ] Approve/reject bookings
- [ ] View booking history
- [ ] Booking conflict resolution
- [ ] Bulk booking operations

#### C. Student Management
- [ ] View student enrollments
- [ ] Manage course registrations
- [ ] Generate student schedules
- [ ] Student reports

#### D. Reports
- [ ] Generate various reports
- [ ] Export functionality
- [ ] Print capabilities

### 5. **Common Components Needed**

#### A. Schedule Components
- [ ] **WeeklyScheduleView** - Grid view of weekly schedule
- [ ] **MonthlyCalendarView** - Calendar view
- [ ] **ScheduleEditor** - Drag-and-drop editor for secretariat/admin
- [ ] **TimeSlotPicker** - Select day/time slots
- [ ] **RoomSelector** - Search and select rooms
- [ ] **ConflictDetector** - Visual indicator of scheduling conflicts

#### B. Management Components
- [ ] **DataTable** - Reusable table with sort/filter/pagination
- [ ] **FormDialog** - Generic form modal for create/edit
- [ ] **ConfirmDialog** - Confirmation dialogs
- [ ] **SearchBar** - Advanced search with filters
- [ ] **BulkActions** - Select and perform bulk operations
- [ ] **FileUploader** - CSV/Excel import

#### C. Notification Components
- [ ] **NotificationBell** - Bell icon with badge
- [ ] **NotificationPanel** - Drawer with notification list
- [ ] **Toast** - Success/error messages
- [ ] **AlertBar** - System-wide alerts

#### D. Display Components
- [ ] **CourseCard** - Display course information
- [ ] **RoomCard** - Display room information
- [ ] **UserCard** - Display user information
- [ ] **StatCard** - Dashboard statistics

#### E. Export/Print Components
- [ ] **PDFExporter** - Export to PDF
- [ ] **ExcelExporter** - Export to Excel/CSV
- [ ] **PrintView** - Print-friendly layouts
- [ ] **iCalExporter** - Export to calendar format

---

## Migration Priority

### Phase 1: Core Management (CRITICAL)
1. Room Management components
2. Course Management components
3. Department Management components
4. Enhanced Schedule Grid with editing capabilities

### Phase 2: Enhanced Dashboards
1. Complete Admin Dashboard
2. Enhanced Professor Dashboard with booking
3. Enhanced Student Dashboard with course selection
4. Enhanced Secretariat Dashboard with editing

### Phase 3: Advanced Features
1. Room booking workflow
2. Notification system
3. Reports and analytics
4. Export/import functionality

### Phase 4: Polish & Optimization
1. Mobile responsiveness
2. Performance optimization
3. Accessibility improvements
4. User experience enhancements

---

## Technical Architecture

### Component Structure
```
frontend/src/
├── components/
│   ├── common/           # Reusable components
│   │   ├── DataTable.jsx
│   │   ├── FormDialog.jsx
│   │   ├── SearchBar.jsx
│   │   └── ...
│   ├── management/       # CRUD components
│   │   ├── RoomManagement.jsx
│   │   ├── CourseManagement.jsx
│   │   ├── DepartmentManagement.jsx
│   │   └── ...
│   ├── schedule/         # Schedule-related
│   │   ├── WeeklyScheduleView.jsx
│   │   ├── ScheduleEditor.jsx
│   │   ├── TimeSlotPicker.jsx
│   │   └── ...
│   ├── booking/          # Room booking
│   │   ├── RoomBookingForm.jsx
│   │   ├── BookingList.jsx
│   │   └── ...
│   └── reports/          # Reports & exports
│       ├── ReportGenerator.jsx
│       ├── PDFExporter.jsx
│       └── ...
├── pages/
│   ├── AdminDashboard.jsx
│   ├── ProfessorDashboard.jsx
│   ├── StudentDashboard.jsx
│   ├── SecretariatDashboard.jsx
│   └── LoginPage.jsx
├── services/
│   ├── api.js            # API client
│   ├── roomService.js
│   ├── courseService.js
│   └── ...
├── store/
│   ├── authStore.js
│   ├── scheduleStore.js
│   └── ...
└── utils/
    ├── dateHelpers.js
    ├── validators.js
    └── ...
```

### State Management
- **Zustand** for global state (auth, notifications)
- **React Query** for server state (data fetching, caching)
- **Local state** for UI state

### UI Libraries
- **Material-UI (MUI)** - Primary component library
- **@mui/x-data-grid** - Advanced data tables
- **react-big-calendar** - Calendar views
- **react-beautiful-dnd** - Drag and drop
- **recharts** - Charts and graphs
- **react-to-print** - Print functionality
- **jspdf** - PDF generation

---

## API Endpoints Required

### Currently Available
- ✅ `/api/auth/login`
- ✅ `/api/auth/register`
- ✅ `/api/auth/me`
- ✅ `/api/users` (CRUD)
- ✅ `/api/departments` (GET)
- ✅ `/api/schedules/*`
- ✅ `/api/notifications/*`

### May Need to be Created/Enhanced
- [ ] `/api/rooms/*` - Room CRUD
- [ ] `/api/courses/*` - Course CRUD
- [ ] `/api/equipment/*` - Equipment CRUD
- [ ] `/api/semesters/*` - Semester management
- [ ] `/api/schedules/*/edit` - Schedule editing
- [ ] `/api/bookings/*` - Room booking
- [ ] `/api/reports/*` - Report generation
- [ ] `/api/import/*` - Bulk import endpoints

---

## Key Differences from PHP Version

### Improvements in React Version
1. **Single Page Application** - No page reloads
2. **Real-time Updates** - WebSocket/polling for notifications
3. **Better UX** - Smooth transitions, loading states
4. **Responsive Design** - Mobile-friendly from the start
5. **Modern UI** - Material Design components
6. **Type Safety** - Can add TypeScript later
7. **Component Reusability** - DRY principle
8. **Better Performance** - Virtual DOM, lazy loading
9. **API-first** - Clean separation of concerns
10. **Modern Development** - Hot reload, dev tools

### Features to Maintain
1. **Greek Language** - All UI in Greek
2. **Multi-role Support** - Admin, Professor, Student, Secretariat
3. **Schedule Management** - Core functionality
4. **Room Booking** - Request/approval workflow
5. **Notifications** - Alert system
6. **Reports** - PDF/Excel exports
7. **CAS/SSO Integration** - University authentication

---

## Testing Strategy

### Unit Tests
- Component rendering
- Utility functions
- State management

### Integration Tests
- API integration
- User workflows
- Form submissions

### E2E Tests
- Critical user journeys
- Login/logout
- CRUD operations
- Schedule creation

---

## Deployment Considerations

### Build Process
```bash
# Frontend
cd frontend
npm run build

# Backend
cd backend
mvn clean package
```

### Environment Variables
- API base URL
- JWT secret
- CAS/SSO configuration
- Email configuration

### Docker Deployment
- Frontend: Nginx container
- Backend: Java container
- Database: MySQL container (already configured)

---

## Migration Timeline Estimate

- **Phase 1** (Core Management): 2-3 days
- **Phase 2** (Enhanced Dashboards): 2-3 days
- **Phase 3** (Advanced Features): 3-4 days
- **Phase 4** (Polish): 1-2 days

**Total**: ~8-12 days for complete migration

---

## Success Criteria

### Functional
- [ ] All user roles can login and access their dashboards
- [ ] Admins can manage rooms, courses, departments, users
- [ ] Professors can view schedules and book rooms
- [ ] Students can view schedules and select courses
- [ ] Secretariat can edit schedules and approve bookings
- [ ] All reports can be generated and exported

### Technical
- [ ] No console errors
- [ ] All API endpoints working
- [ ] Responsive on mobile/tablet/desktop
- [ ] Load time < 3 seconds
- [ ] Accessibility score > 90

### UX
- [ ] Intuitive navigation
- [ ] Clear error messages
- [ ] Loading indicators
- [ ] Confirmation dialogs
- [ ] Success feedback

---

## Next Steps

1. **Review this plan** with stakeholders
2. **Prioritize features** based on business needs
3. **Start Phase 1** - Create management components
4. **Iterate** based on feedback
5. **Deploy incrementally** - Feature by feature

---

## Notes

- This is a complete rewrite, not a 1:1 port
- Focus on modern UX/UI patterns
- Leverage React ecosystem best practices
- Maintain backward compatibility with database
- Plan for future enhancements (mobile app, API for third parties)

---

*Document Version: 1.0*
*Last Updated: 2026-01-03*
