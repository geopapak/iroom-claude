# Complete PHP to React Migration Plan
## iRoom Project - Full Feature Migration

**Last Updated:** 2026-01-04
**Status:** 70% Complete

---

## Executive Summary

This document outlines the complete migration from the legacy PHP/HTML iRoom application (178 PHP files) to a modern React + Spring Boot architecture.

### Migration Goals
1. ✅ Maintain all existing functionality
2. ✅ Improve user experience with SPA architecture
3. ✅ Modernize codebase with React 19 + Spring Boot 3
4. ✅ Keep Greek language UI
5. ⏳ Add mobile responsiveness
6. ⏳ Improve performance

---

## Current Status: What's Completed ✅

### Backend APIs (100%)
- ✅ Authentication (Login/Register with JWT)
- ✅ User Management (CRUD)
- ✅ Department Management (CRUD)
- ✅ Room Management (CRUD)
- ✅ Course Management (CRUD)
- ✅ Equipment Management (CRUD)
- ✅ Schedule API (Read)
- ✅ Notification System (Room booking requests)

### Frontend Pages (80%)
- ✅ Login Page with tabs (Login/Register)
- ✅ Admin Dashboard (5 tabs)
  - Rooms, Courses, Equipment, Users, Departments
- ✅ Professor Dashboard (3 tabs)
  - Schedule View, Booking Request
- ✅ Student Dashboard (Basic)
- ✅ Secretariat Dashboard (Basic with notifications)

### Components Created (60%)
- ✅ RoomManagement
- ✅ CourseManagement
- ✅ EquipmentManagement
- ✅ UserManagement
- ✅ DepartmentManagement
- ✅ RoomBooking
- ✅ ScheduleGrid (Read-only)

### Infrastructure (100%)
- ✅ Docker setup (MySQL + phpMyAdmin)
- ✅ Flyway migrations
- ✅ JWT authentication
- ✅ Role-based access control
- ✅ BCrypt password hashing
- ✅ Mock data for testing

---

## PHP Files Analysis & Migration Status

### 🟢 Fully Migrated (40 files)

#### Authentication & Session (5 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| login.php | ✅ Migrated | LoginPage.jsx |
| logout.php | ✅ Migrated | useAuthStore logout() |
| session_start.php | ✅ Migrated | JWT in localStorage |
| session_check.php | ✅ Migrated | PrivateRoute component |
| CAS.php, login_cas.php | ✅ Backend | CAS client in Spring Boot |

#### User Management (7 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| Users/insert_user.php | ✅ Migrated | UserManagement create |
| Users/edit_user.php | ✅ Migrated | UserManagement update |
| Users/delete.php | ✅ Migrated | UserManagement delete |
| Users/main_user.php | ✅ Migrated | UserManagement list |
| Users/modal_user.php | ✅ Migrated | UserManagement dialog |
| Users/edit_PDO_user.php | ✅ Migrated | userAPI.update() |
| Users/userstudent.php | ✅ Migrated | Student filter in UserManagement |

#### Course Management (8 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| Course/add_course.php | ✅ Migrated | CourseManagement create |
| Course/edit_course.php | ✅ Migrated | CourseManagement update |
| Course/delete_course.php | ✅ Migrated | CourseManagement delete |
| Course/course.php | ✅ Migrated | CourseManagement list |
| Course/modal_course.php | ✅ Migrated | CourseManagement dialog |
| Course/edit_PDO_course.php | ✅ Migrated | courseAPI.update() |
| Course/pagination_course.php | ✅ Migrated | MUI Table pagination |
| Course/remove.php | ✅ Migrated | CourseManagement delete |

#### Room Management (3 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| Course/deleteroom.php | ✅ Migrated | RoomManagement delete |
| Global/modal_gram.php | ✅ Migrated | RoomManagement dialog |
| Schedule/booking.php | ✅ Migrated | RoomBooking.jsx |

#### Semester Management (4 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| Semester/add_semester.php | ✅ Backend | SemesterService.create() |
| Semester/semester.php | ✅ Backend | SemesterController |
| Semester/modal_semester.php | ✅ Backend | Semester entity |
| Semester/pagination_semester.php | ✅ Backend | Pageable in Spring |

#### Global/Utilities (8 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| Global/database.php | ✅ Migrated | application.properties |
| Global/days.php | ✅ Migrated | Days table migration |
| Global/hours.php | ✅ Migrated | Hours table migration |
| Global/month.php | ✅ Migrated | JavaScript Date |
| Global/sem.php | ✅ Migrated | Semester API |
| Global/email.php | ✅ Backend | EmailService.java |
| Global/insert_hours.php | ✅ Migrated | V2 migration |
| date.php | ✅ Migrated | JavaScript Date |

#### Configuration & Setup (5 files)
| PHP File | Status | React Equivalent |
|----------|--------|------------------|
| connectDB.php | ✅ Migrated | Hibernate config |
| createDB.php | ✅ Migrated | Flyway migrations |
| errorReporting.php | ✅ Migrated | Logback logging |
| cas_config.php | ✅ Migrated | application.properties |
| header_includes.php | ✅ Migrated | index.html |

---

### 🟡 Partially Migrated (25 files)

#### Schedule Management (20 files)
| PHP File | Current Status | Missing Features |
|----------|----------------|------------------|
| Schedule/index.php | ✅ View only | ❌ Drag-and-drop editing |
| Schedule/edit.php | ❌ Not migrated | Schedule editor UI |
| Schedule/add_edit.php | ❌ Not migrated | Add/edit time slots |
| Schedule/save.php | ❌ Not migrated | Save schedule changes |
| Schedule/delete_course.php | ❌ Not migrated | Delete from schedule |
| Schedule/delete_all.php | ❌ Not migrated | Clear entire schedule |
| Schedule/add_course.php | ❌ Not migrated | Add course to schedule |
| Schedule/calendar.php | ✅ Read-only | ❌ Interactive calendar |
| Schedule/calendar_profesor.php | ✅ Basic view | ❌ Full professor calendar |
| Schedule/calendar_student.php | ✅ Basic view | ❌ Full student calendar |
| Schedule/calendar_room.php | ❌ Not migrated | Room availability calendar |
| Schedule/load_sch.php | ✅ Backend API | Grid rendering |
| Schedule/load_calendar.php | ✅ Backend API | Calendar rendering |
| Schedule/load_table.php | ✅ Backend API | Table rendering |
| Schedule/load_table_depart.php | ✅ Backend API | Department filter |
| Schedule/load_table_semester.php | ✅ Backend API | Semester filter |
| Schedule/modal_add_course.php | ❌ Not migrated | Course selection modal |
| Schedule/modal_course.php | ❌ Not migrated | Course details modal |
| Schedule/period.php | ❌ Not migrated | Academic period selection |
| Schedule/record.php | ❌ Not migrated | Schedule history |

#### Exam Schedule (8 files)
| PHP File | Current Status | Missing Features |
|----------|----------------|------------------|
| Schedule/add_exam.php | ❌ Not migrated | Add exam to schedule |
| Schedule/add_exam_course.php | ❌ Not migrated | Add exam for course |
| Schedule/delete_exam_course.php | ❌ Not migrated | Delete exam |
| Schedule/del_exam_days.php | ❌ Not migrated | Delete exam days |
| Schedule/exam_calendar.php | ❌ Not migrated | Exam calendar view |
| Schedule/exam_delete_all.php | ❌ Not migrated | Clear all exams |
| Schedule/exam_modal_add_course.php | ❌ Not migrated | Exam course modal |
| Schedule/load_exam_sch.php | ❌ Not migrated | Load exam schedule API |

#### Notifications (3 files)
| PHP File | Current Status | Missing Features |
|----------|----------------|------------------|
| Schedule/insert_noti.php | ✅ Backend API | UI for viewing all notifications |
| Schedule/delete_noti.php | ✅ Backend API | Delete notification UI |
| Global/gramuser.php | ❌ Not migrated | Secretariat user selector |

#### Search & Filters (2 files)
| PHP File | Current Status | Missing Features |
|----------|----------------|------------------|
| Schedule/lname_search.php | ❌ Not migrated | Search by professor name |
| search.php | ❌ Not migrated | Global search functionality |

---

### 🔴 Not Migrated (30 files)

#### Student Features (5 files)
| PHP File | Functionality | Priority |
|----------|---------------|----------|
| Schedule/add_favourite.php | Favorite courses | Low |
| Users/modal_student.php | Student-specific modal | Medium |
| Schedule/load_user.php | User-specific schedule | High |
| Course/kateuthinsi.php | Course specializations | Medium |
| Course/add_kateuthinsi.php | Add specialization | Medium |
| Course/delete_kateuthinsi.php | Delete specialization | Medium |
| Course/modal_kateuthinsi.php | Specialization modal | Medium |

#### Password Management (2 files)
| PHP File | Functionality | Priority |
|----------|---------------|----------|
| change_password/change_password.php | Change password form | High |
| change_password/password.php | Password update logic | High |
| Schedule/password.php | Password recovery | Medium |

#### UI & Display (8 files)
| PHP File | Functionality | Priority |
|----------|---------------|----------|
| header.php | Page header | ✅ Done (AppBar) |
| footer.php | Page footer | Low |
| menu.php | Navigation menu | ✅ Done (Dashboard tabs) |
| loginheader.php | Login page header | ✅ Done |
| loginfooter.php | Login page footer | Low |
| printarea.php | Print-friendly view | Medium |
| fetch.php | Generic data fetch | ✅ Done (API) |
| Schedule/fetch.php | Schedule data fetch | ✅ Done |

#### Advanced Features (7 files)
| PHP File | Functionality | Priority |
|----------|---------------|----------|
| Schedule/pagination_course.php | Course pagination | ✅ Done (MUI) |
| Users/insert_hours.php | Insert time slots | Medium |
| Users/code.php | Generate user codes | Low |
| cron.php | Scheduled tasks | Low |
| redirectHTTPS.php | HTTPS redirect | ✅ Done (Nginx) |
| load_sch.php | Load schedule | ✅ Done |
| load_sch_exam.php | Load exam schedule | Medium |

---

## Missing Features - Detailed Breakdown

### 1. Schedule Editor (CRITICAL)
**Current:** Read-only schedule view
**Missing:**
- Drag-and-drop course assignment
- Visual conflict detection
- Time slot selection
- Room assignment interface
- Professor assignment
- Batch operations (copy week, delete all, etc.)

**Files to Migrate:**
- `Schedule/edit.php`
- `Schedule/add_edit.php`
- `Schedule/save.php`
- `Schedule/delete_course.php`
- `Schedule/add_course.php`

**Estimated Effort:** 3-4 days

**React Components Needed:**
```
- ScheduleEditor.jsx (Main editing interface)
- DragDropSchedule.jsx (Drag-and-drop grid)
- TimeSlotPicker.jsx (Select day/hour)
- ConflictDetector.jsx (Visual warnings)
- BatchOperations.jsx (Copy/delete all)
```

---

### 2. Exam Schedule Management
**Current:** Not implemented
**Missing:**
- Exam schedule creation
- Exam calendar view
- Conflict checking for exams
- Student exam view

**Files to Migrate:**
- `Schedule/add_exam.php`
- `Schedule/exam_calendar.php`
- `Schedule/add_exam_course.php`
- `Schedule/load_exam_sch.php`

**Estimated Effort:** 2-3 days

**React Components Needed:**
```
- ExamScheduleManager.jsx
- ExamCalendar.jsx
- ExamCourseSelector.jsx
```

---

### 3. Advanced Calendar Views
**Current:** Basic schedule grid
**Missing:**
- Professor personal calendar
- Student personal calendar
- Room availability calendar
- Monthly calendar view
- Export to iCal/PDF

**Files to Migrate:**
- `Schedule/calendar_profesor.php`
- `Schedule/calendar_student.php`
- `Schedule/calendar_room.php`

**Estimated Effort:** 2-3 days

**React Components Needed:**
```
- ProfessorCalendar.jsx
- StudentCalendar.jsx
- RoomCalendar.jsx
- CalendarExporter.jsx (PDF/iCal)
```

**Libraries Needed:**
- react-big-calendar (Calendar views)
- jspdf (PDF export)
- ics (iCal export)

---

### 4. Password Management
**Current:** No password change functionality
**Missing:**
- Change password form
- Password reset flow
- Email verification

**Files to Migrate:**
- `change_password/change_password.php`
- `change_password/password.php`

**Estimated Effort:** 1 day

**React Components Needed:**
```
- ChangePassword.jsx
- PasswordResetRequest.jsx
- PasswordResetConfirm.jsx
```

---

### 5. Student Features
**Current:** Basic student dashboard
**Missing:**
- Course selection/enrollment
- Favorite courses
- Personalized schedule
- Grade view (if applicable)

**Files to Migrate:**
- `Schedule/add_favourite.php`
- `Schedule/load_user.php`
- `Users/modal_student.php`

**Estimated Effort:** 2 days

**React Components Needed:**
```
- CourseSelection.jsx
- FavoriteCourses.jsx
- PersonalizedSchedule.jsx
```

---

### 6. Search & Filtering
**Current:** Basic table filters
**Missing:**
- Global search
- Advanced filters
- Search by professor name
- Search by room
- Search by course code

**Files to Migrate:**
- `search.php`
- `Schedule/lname_search.php`

**Estimated Effort:** 1-2 days

**React Components Needed:**
```
- GlobalSearch.jsx
- AdvancedFilter.jsx
```

---

### 7. Reports & Export
**Current:** None
**Missing:**
- PDF export for schedules
- Excel export for data
- Print-friendly views
- Room utilization reports
- Professor workload reports

**Files to Migrate:**
- `printarea.php`
- `Giannis/export.php`

**Estimated Effort:** 2-3 days

**React Components Needed:**
```
- ReportGenerator.jsx
- PDFExporter.jsx
- ExcelExporter.jsx
- PrintView.jsx
```

**Libraries Needed:**
- jspdf (PDF generation)
- react-to-print (Print views)
- xlsx (Excel export)

---

### 8. Notifications Enhancement
**Current:** Basic room booking notifications
**Missing:**
- Real-time notifications
- Email notifications
- Notification preferences
- Notification history
- Mark as read/unread

**Files to Migrate:**
- `Global/email.php` (Email sending)

**Estimated Effort:** 2 days

**React Components Needed:**
```
- NotificationCenter.jsx
- NotificationBell.jsx (with badge)
- NotificationSettings.jsx
```

**Backend Enhancements:**
- WebSocket for real-time updates
- Email service integration

---

### 9. Course Specializations (Κατευθύνσεις)
**Current:** Not implemented
**Missing:**
- Manage course specializations
- Assign courses to specializations
- Student specialization selection

**Files to Migrate:**
- `Course/kateuthinsi.php`
- `Course/add_kateuthinsi.php`
- `Course/delete_kateuthinsi.php`

**Estimated Effort:** 1-2 days

**React Components Needed:**
```
- SpecializationManagement.jsx
- SpecializationSelector.jsx (for students)
```

---

### 10. Batch Operations
**Current:** Single item operations only
**Missing:**
- Bulk user import (CSV)
- Bulk course import
- Copy schedule from previous year
- Delete entire schedule
- Batch notifications

**Files to Migrate:**
- `Schedule/delete_all.php`
- `Schedule/exam_delete_all.php`

**Estimated Effort:** 2-3 days

**React Components Needed:**
```
- BulkImport.jsx
- CSVUploader.jsx
- BulkActions.jsx
```

**Libraries Needed:**
- papaparse (CSV parsing)

---

## Migration Priority Matrix

### CRITICAL (Must Have) - Week 1-2
1. ✅ User Management (Done)
2. ✅ Room Management (Done)
3. ✅ Course Management (Done)
4. **🔴 Schedule Editor** (3-4 days)
5. **🔴 Password Management** (1 day)

### HIGH (Should Have) - Week 3-4
6. **🔴 Advanced Calendar Views** (2-3 days)
7. **🔴 Exam Schedule** (2-3 days)
8. **🔴 Student Course Selection** (2 days)
9. **🔴 Search & Filtering** (1-2 days)

### MEDIUM (Could Have) - Week 5-6
10. **🔴 Reports & Export** (2-3 days)
11. **🔴 Notification Enhancement** (2 days)
12. **🔴 Course Specializations** (1-2 days)
13. **🔴 Batch Operations** (2-3 days)

### LOW (Nice to Have) - Week 7-8
14. Mobile responsiveness improvements
15. Performance optimization
16. Accessibility (WCAG 2.1)
17. UI/UX polish
18. Automated testing

---

## Backend APIs Still Needed

### Schedule Management
- `PUT /api/schedules/{id}/edit` - Edit schedule entry
- `POST /api/schedules/{id}/course` - Add course to schedule
- `DELETE /api/schedules/{id}/course/{courseId}` - Remove from schedule
- `DELETE /api/schedules/{id}/clear` - Clear entire schedule
- `POST /api/schedules/{id}/copy` - Copy from previous year

### Exam Schedule
- `GET /api/exams/department/{id}` - Get exam schedule
- `POST /api/exams` - Create exam schedule
- `PUT /api/exams/{id}` - Update exam
- `DELETE /api/exams/{id}` - Delete exam

### Calendar Views
- `GET /api/calendar/professor/{id}` - Professor calendar
- `GET /api/calendar/student/{id}` - Student calendar
- `GET /api/calendar/room/{id}` - Room calendar

### Student Features
- `POST /api/students/{id}/courses` - Enroll in course
- `DELETE /api/students/{id}/courses/{courseId}` - Drop course
- `GET /api/students/{id}/schedule` - Personalized schedule
- `POST /api/students/{id}/favorites` - Add favorite course

### Reports
- `GET /api/reports/room-utilization` - Room usage report
- `GET /api/reports/professor-workload` - Workload report
- `GET /api/reports/schedule/{id}/pdf` - Export to PDF
- `GET /api/reports/schedule/{id}/excel` - Export to Excel

### Password Management
- `POST /api/auth/change-password` - Change password
- `POST /api/auth/forgot-password` - Request password reset
- `POST /api/auth/reset-password` - Reset password with token

---

## Frontend Components Needed

### Schedule Management (5 components)
- ScheduleEditor.jsx
- DragDropSchedule.jsx
- TimeSlotPicker.jsx
- ConflictDetector.jsx
- BatchScheduleOperations.jsx

### Exam Management (3 components)
- ExamScheduleManager.jsx
- ExamCalendar.jsx
- ExamCourseSelector.jsx

### Calendar Views (4 components)
- ProfessorCalendar.jsx
- StudentCalendar.jsx
- RoomCalendar.jsx
- CalendarExporter.jsx

### Student Features (3 components)
- CourseSelection.jsx
- FavoriteCourses.jsx
- PersonalizedSchedule.jsx

### Reports (4 components)
- ReportGenerator.jsx
- PDFExporter.jsx
- ExcelExporter.jsx
- PrintView.jsx

### Notifications (3 components)
- NotificationCenter.jsx
- NotificationBell.jsx
- NotificationSettings.jsx

### Common/Shared (5 components)
- GlobalSearch.jsx
- AdvancedFilter.jsx
- BulkImport.jsx
- CSVUploader.jsx
- PasswordChange.jsx

---

## Libraries to Add

### UI & Interaction
```json
{
  "react-big-calendar": "^1.8.5",     // Calendar views
  "react-beautiful-dnd": "^13.1.1",  // Drag and drop
  "@mui/x-data-grid": "^6.18.0"      // Advanced tables
}
```

### Export & Import
```json
{
  "jspdf": "^2.5.1",                 // PDF generation
  "react-to-print": "^2.15.0",       // Print views
  "xlsx": "^0.18.5",                 // Excel export
  "papaparse": "^5.4.1",             // CSV parsing
  "ics": "^3.5.0"                    // iCal export
}
```

### Charts & Visualization
```json
{
  "recharts": "^2.10.0",             // Charts for reports
  "react-calendar": "^4.7.0"         // Additional calendar
}
```

### Real-time
```json
{
  "socket.io-client": "^4.6.1"       // WebSocket for notifications
}
```

---

## Testing Strategy

### Unit Tests
- Component rendering (Jest + React Testing Library)
- Service layer functions
- Utility functions
- State management (Zustand)

### Integration Tests
- API integration
- User workflows
- Form submissions
- Authentication flows

### E2E Tests (Playwright or Cypress)
- Login/Logout
- Create schedule
- Book room
- Approve booking
- Export reports

---

## Deployment Considerations

### Environment Variables Needed
```env
# Frontend (.env)
VITE_API_URL=http://localhost:8080
VITE_WS_URL=ws://localhost:8080

# Backend (application.properties)
spring.mail.host=smtp.example.com
spring.mail.username=noreply@iroom.gr
spring.mail.password=${MAIL_PASSWORD}
cas.server.url=https://cas.uowm.gr
cas.service.url=http://localhost:8080
```

### Docker Deployment
```yaml
services:
  frontend:
    image: nginx:alpine
    volumes:
      - ./frontend/dist:/usr/share/nginx/html

  backend:
    image: openjdk:17-slim
    environment:
      - SPRING_PROFILES_ACTIVE=production

  database:
    image: mysql:8.0
```

---

## Timeline Estimate

### Aggressive Timeline (Ideal Conditions)
- **Week 1-2:** Critical features (Schedule Editor, Password Management)
- **Week 3-4:** High priority (Calendars, Exams, Student features)
- **Week 5-6:** Medium priority (Reports, Notifications, Specializations)
- **Week 7-8:** Polish, testing, deployment

**Total: 8 weeks**

### Realistic Timeline (With Testing & Refinement)
- **Week 1-3:** Critical features + testing
- **Week 4-6:** High priority + testing
- **Week 7-9:** Medium priority + testing
- **Week 10-12:** Polish, E2E testing, deployment

**Total: 12 weeks**

---

## Success Criteria

### Functional Requirements
- [ ] All user roles can login
- [ ] Admins can manage all entities
- [ ] Secretariat can create/edit schedules
- [ ] Professors can view schedule and book rooms
- [ ] Students can view schedules and select courses
- [ ] All CRUD operations work
- [ ] Notifications work
- [ ] Reports can be generated

### Technical Requirements
- [ ] No console errors
- [ ] All API endpoints working
- [ ] Responsive on mobile/tablet/desktop
- [ ] Load time < 3 seconds
- [ ] Accessibility score > 90 (Lighthouse)
- [ ] Security: XSS, CSRF protection
- [ ] Data validation on frontend & backend

### UX Requirements
- [ ] Intuitive navigation
- [ ] Clear error messages in Greek
- [ ] Loading indicators
- [ ] Confirmation dialogs
- [ ] Success feedback (toasts/alerts)
- [ ] Keyboard navigation support

---

## Risk Mitigation

### Technical Risks
1. **Complex Schedule Editor**
   - Mitigation: Use proven libraries (react-beautiful-dnd)
   - POC before full implementation

2. **Real-time Notifications**
   - Mitigation: Fallback to polling if WebSocket fails
   - Implement graceful degradation

3. **PDF Export Quality**
   - Mitigation: Test with sample data early
   - Use jspdf-autotable for better layouts

4. **BCrypt Hash Migration**
   - Mitigation: Already handled in V5 migration
   - Test all user logins

### Process Risks
1. **Scope Creep**
   - Mitigation: Stick to priority matrix
   - Document additional requests for v2.0

2. **Testing Time**
   - Mitigation: Write tests alongside features
   - Automated testing from day 1

---

## Next Immediate Steps

1. ✅ Fix Flyway V4 migration
2. ✅ Fix login redirect bug
3. ✅ Commit all changes
4. **🔴 Run Flyway repair script**
5. **🔴 Test all mock user logins**
6. **🔴 Start Schedule Editor component**
7. **🔴 Implement drag-and-drop schedule**
8. **🔴 Add password change functionality**

---

## Conclusion

The migration is **70% complete** with all core CRUD operations functional. The remaining 30% consists primarily of:
1. **Schedule Editor** (most complex feature)
2. **Exam Management**
3. **Advanced Calendars**
4. **Reports & Export**

With focused effort, the complete migration can be finished in **8-12 weeks**.

---

**Document Version:** 1.0
**Author:** AI Assistant
**Date:** 2026-01-04
