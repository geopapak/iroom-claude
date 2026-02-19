package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.KateuthinsiRequest;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.entity.Kateuthinsi;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.DepartmentRepository;
import gr.uowm.iroom.repository.KateuthinsiRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class KateuthinsiService {

    private final KateuthinsiRepository kateuthinsiRepository;
    private final DepartmentRepository departmentRepository;

    @Transactional
    public Kateuthinsi create(KateuthinsiRequest request) {
        Department department = departmentRepository.findById(request.getDepartmentId())
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

        Kateuthinsi kateuthinsi = Kateuthinsi.builder()
                .name(request.getName())
                .department(department)
                .build();

        return kateuthinsiRepository.save(kateuthinsi);
    }

    @Transactional(readOnly = true)
    public List<Kateuthinsi> getAll() {
        return kateuthinsiRepository.findAll();
    }

    @Transactional(readOnly = true)
    public List<Kateuthinsi> getByDepartment(Long departmentId) {
        return kateuthinsiRepository.findByDepartmentId(departmentId);
    }

    @Transactional(readOnly = true)
    public Kateuthinsi getById(Long id) {
        return kateuthinsiRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Specialization not found with id: " + id));
    }

    @Transactional
    public Kateuthinsi update(Long id, KateuthinsiRequest request) {
        Kateuthinsi kateuthinsi = kateuthinsiRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Specialization not found with id: " + id));

        Department department = departmentRepository.findById(request.getDepartmentId())
                .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

        kateuthinsi.setName(request.getName());
        kateuthinsi.setDepartment(department);

        return kateuthinsiRepository.save(kateuthinsi);
    }

    @Transactional
    public void delete(Long id) {
        Kateuthinsi kateuthinsi = kateuthinsiRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Specialization not found with id: " + id));
        kateuthinsiRepository.delete(kateuthinsi);
    }
}
