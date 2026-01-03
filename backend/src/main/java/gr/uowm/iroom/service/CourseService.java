package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.CourseRequest;
import gr.uowm.iroom.entity.Course;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.entity.Semester;
import gr.uowm.iroom.entity.SemesterCourse;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.CourseRepository;
import gr.uowm.iroom.repository.DepartmentRepository;
import gr.uowm.iroom.repository.SemesterCourseRepository;
import gr.uowm.iroom.repository.SemesterRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class CourseService {

    private final CourseRepository courseRepository;
    private final DepartmentRepository departmentRepository;
    private final SemesterRepository semesterRepository;
    private final SemesterCourseRepository semesterCourseRepository;

    @Transactional
    public Course createCourse(CourseRequest request) {
        // Check if course code already exists
        if (courseRepository.existsByCode(request.getCode())) {
            throw new BadRequestException("Course already exists with code: " + request.getCode());
        }

        Course course = Course.builder()
                .name(request.getName())
                .year(request.getYear())
                .code(request.getCode())
                .optional(request.getOptional())
                .build();

        course = courseRepository.save(course);

        // If department and semester are specified, create semester-course association
        if (request.getDepartmentId() != null && request.getSemesterId() != null) {
            Department department = departmentRepository.findById(request.getDepartmentId())
                    .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

            Semester semester = semesterRepository.findById(request.getSemesterId())
                    .orElseThrow(() -> new ResourceNotFoundException("Semester not found with id: " + request.getSemesterId()));

            SemesterCourse semesterCourse = SemesterCourse.builder()
                    .course(course)
                    .semester(semester)
                    .department(department)
                    .build();

            semesterCourseRepository.save(semesterCourse);
        }

        return course;
    }

    @Transactional(readOnly = true)
    public List<Course> getAllCourses() {
        return courseRepository.findAll();
    }

    @Transactional(readOnly = true)
    public Course getCourseById(Long id) {
        return courseRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Course not found with id: " + id));
    }

    @Transactional(readOnly = true)
    public List<Course> getCoursesByDepartment(Long departmentId) {
        return courseRepository.findByDepartmentId(departmentId);
    }

    @Transactional(readOnly = true)
    public List<Course> getCoursesBySemester(Long semesterId) {
        return courseRepository.findBySemesterId(semesterId);
    }

    @Transactional(readOnly = true)
    public List<Course> getCoursesByYear(Integer year) {
        return courseRepository.findByYear(year);
    }

    @Transactional
    public Course updateCourse(Long id, CourseRequest request) {
        Course course = courseRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Course not found with id: " + id));

        // Check if new code conflicts with existing course
        if (!course.getCode().equals(request.getCode()) &&
            courseRepository.existsByCode(request.getCode())) {
            throw new BadRequestException("Course already exists with code: " + request.getCode());
        }

        course.setName(request.getName());
        course.setYear(request.getYear());
        course.setCode(request.getCode());
        course.setOptional(request.getOptional());

        return courseRepository.save(course);
    }

    @Transactional
    public void deleteCourse(Long id) {
        Course course = courseRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Course not found with id: " + id));

        courseRepository.delete(course);
    }
}
