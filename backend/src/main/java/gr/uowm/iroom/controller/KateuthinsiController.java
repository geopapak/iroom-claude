package gr.uowm.iroom.controller;

import gr.uowm.iroom.dto.KateuthinsiRequest;
import gr.uowm.iroom.entity.Kateuthinsi;
import gr.uowm.iroom.service.KateuthinsiService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/specializations")
@RequiredArgsConstructor
public class KateuthinsiController {

    private final KateuthinsiService kateuthinsiService;

    @PostMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Kateuthinsi> create(@Valid @RequestBody KateuthinsiRequest request) {
        return ResponseEntity.status(HttpStatus.CREATED).body(kateuthinsiService.create(request));
    }

    @GetMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<List<Kateuthinsi>> getAll() {
        return ResponseEntity.ok(kateuthinsiService.getAll());
    }

    @GetMapping("/department/{departmentId}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<List<Kateuthinsi>> getByDepartment(@PathVariable Long departmentId) {
        return ResponseEntity.ok(kateuthinsiService.getByDepartment(departmentId));
    }

    @GetMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Kateuthinsi> getById(@PathVariable Long id) {
        return ResponseEntity.ok(kateuthinsiService.getById(id));
    }

    @PutMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Kateuthinsi> update(@PathVariable Long id, @Valid @RequestBody KateuthinsiRequest request) {
        return ResponseEntity.ok(kateuthinsiService.update(id, request));
    }

    @DeleteMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Void> delete(@PathVariable Long id) {
        kateuthinsiService.delete(id);
        return ResponseEntity.noContent().build();
    }
}
