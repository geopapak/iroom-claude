package gr.uowm.iroom.controller;

import gr.uowm.iroom.dto.DepartmentRequest;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.service.DepartmentService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/departments")
@RequiredArgsConstructor
public class DepartmentController {

    private final DepartmentService departmentService;

    @PostMapping
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Department> createDepartment(@Valid @RequestBody DepartmentRequest request) {
        Department department = departmentService.createDepartment(request);
        return ResponseEntity.status(HttpStatus.CREATED).body(department);
    }

    @GetMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<List<Department>> getAllDepartments() {
        List<Department> departments = departmentService.getAllDepartments();
        return ResponseEntity.ok(departments);
    }

    @GetMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Department> getDepartmentById(@PathVariable Long id) {
        Department department = departmentService.getDepartmentById(id);
        return ResponseEntity.ok(department);
    }

    @PutMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Department> updateDepartment(@PathVariable Long id, @Valid @RequestBody DepartmentRequest request) {
        Department department = departmentService.updateDepartment(id, request);
        return ResponseEntity.ok(department);
    }

    @DeleteMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Void> deleteDepartment(@PathVariable Long id) {
        departmentService.deleteDepartment(id);
        return ResponseEntity.noContent().build();
    }
}
