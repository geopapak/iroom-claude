package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.DepartmentRequest;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.entity.University;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.DepartmentRepository;
import gr.uowm.iroom.repository.UniversityRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class DepartmentService {

    private final DepartmentRepository departmentRepository;
    private final UniversityRepository universityRepository;

    @Transactional
    public Department createDepartment(DepartmentRequest request) {
        University university = universityRepository.findById(request.getUniversityId())
                .orElseThrow(() -> new ResourceNotFoundException("University not found with id: " + request.getUniversityId()));

        Department department = Department.builder()
                .name(request.getName())
                .university(university)
                .ssoDepart(request.getSsoDepart())
                .build();

        return departmentRepository.save(department);
    }

    @Transactional(readOnly = true)
    public List<Department> getAllDepartments() {
        return departmentRepository.findAll();
    }

    @Transactional(readOnly = true)
    public List<Department> getDepartmentsByUniversity(Long universityId) {
        return departmentRepository.findByUniversityId(universityId);
    }

    @Transactional(readOnly = true)
    public Department getDepartmentById(Long id) {
        return departmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + id));
    }

    @Transactional
    public Department updateDepartment(Long id, DepartmentRequest request) {
        Department department = departmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + id));

        University university = universityRepository.findById(request.getUniversityId())
                .orElseThrow(() -> new ResourceNotFoundException("University not found with id: " + request.getUniversityId()));

        department.setName(request.getName());
        department.setUniversity(university);
        department.setSsoDepart(request.getSsoDepart());

        return departmentRepository.save(department);
    }

    @Transactional
    public void deleteDepartment(Long id) {
        Department department = departmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + id));
        departmentRepository.delete(department);
    }
}
