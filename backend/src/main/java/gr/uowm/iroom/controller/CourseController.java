package gr.uowm.iroom.controller;

import gr.uowm.iroom.dto.CourseRequest;
import gr.uowm.iroom.entity.Course;
import gr.uowm.iroom.service.CourseService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/courses")
@RequiredArgsConstructor
public class CourseController {

    private final CourseService courseService;

    @PostMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Course> createCourse(@Valid @RequestBody CourseRequest request) {
        Course course = courseService.createCourse(request);
        return ResponseEntity.status(HttpStatus.CREATED).body(course);
    }

    @GetMapping
    public ResponseEntity<List<Course>> getAllCourses() {
        List<Course> courses = courseService.getAllCourses();
        return ResponseEntity.ok(courses);
    }

    @GetMapping("/{id}")
    public ResponseEntity<Course> getCourseById(@PathVariable Long id) {
        Course course = courseService.getCourseById(id);
        return ResponseEntity.ok(course);
    }

    @GetMapping("/department/{departmentId}")
    public ResponseEntity<List<Course>> getCoursesByDepartment(@PathVariable Long departmentId) {
        List<Course> courses = courseService.getCoursesByDepartment(departmentId);
        return ResponseEntity.ok(courses);
    }

    @GetMapping("/semester/{semesterId}")
    public ResponseEntity<List<Course>> getCoursesBySemester(@PathVariable Long semesterId) {
        List<Course> courses = courseService.getCoursesBySemester(semesterId);
        return ResponseEntity.ok(courses);
    }

    @GetMapping("/year/{year}")
    public ResponseEntity<List<Course>> getCoursesByYear(@PathVariable Integer year) {
        List<Course> courses = courseService.getCoursesByYear(year);
        return ResponseEntity.ok(courses);
    }

    @PutMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Course> updateCourse(@PathVariable Long id, @Valid @RequestBody CourseRequest request) {
        Course course = courseService.updateCourse(id, request);
        return ResponseEntity.ok(course);
    }

    @DeleteMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Void> deleteCourse(@PathVariable Long id) {
        courseService.deleteCourse(id);
        return ResponseEntity.noContent().build();
    }
}
