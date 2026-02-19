package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.UniversityRequest;
import gr.uowm.iroom.entity.University;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.UniversityRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class UniversityService {

    private final UniversityRepository universityRepository;

    @Transactional
    public University createUniversity(UniversityRequest request) {
        University university = University.builder()
                .name(request.getName())
                .build();
        return universityRepository.save(university);
    }

    @Transactional(readOnly = true)
    public List<University> getAllUniversities() {
        return universityRepository.findAll();
    }

    @Transactional(readOnly = true)
    public University getUniversityById(Long id) {
        return universityRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("University not found with id: " + id));
    }

    @Transactional
    public University updateUniversity(Long id, UniversityRequest request) {
        University university = universityRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("University not found with id: " + id));
        university.setName(request.getName());
        return universityRepository.save(university);
    }

    @Transactional
    public void deleteUniversity(Long id) {
        University university = universityRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("University not found with id: " + id));
        universityRepository.delete(university);
    }
}
