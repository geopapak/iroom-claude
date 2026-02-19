package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.SemesterRequest;
import gr.uowm.iroom.entity.Semester;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.SemesterRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class SemesterService {

    private final SemesterRepository semesterRepository;

    @Transactional
    public Semester create(SemesterRequest request) {
        Semester semester = Semester.builder()
                .name(request.getName())
                .build();
        return semesterRepository.save(semester);
    }

    @Transactional(readOnly = true)
    public List<Semester> getAll() {
        return semesterRepository.findAll();
    }

    @Transactional(readOnly = true)
    public Semester getById(Long id) {
        return semesterRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Semester not found with id: " + id));
    }

    @Transactional
    public Semester update(Long id, SemesterRequest request) {
        Semester semester = semesterRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Semester not found with id: " + id));
        semester.setName(request.getName());
        return semesterRepository.save(semester);
    }

    @Transactional
    public void delete(Long id) {
        Semester semester = semesterRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Semester not found with id: " + id));
        semesterRepository.delete(semester);
    }
}
