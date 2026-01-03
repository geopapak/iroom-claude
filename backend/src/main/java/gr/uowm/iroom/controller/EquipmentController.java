package gr.uowm.iroom.controller;

import gr.uowm.iroom.dto.EquipmentRequest;
import gr.uowm.iroom.entity.Equipment;
import gr.uowm.iroom.service.EquipmentService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/equipment")
@RequiredArgsConstructor
public class EquipmentController {

    private final EquipmentService equipmentService;

    @PostMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Equipment> createEquipment(@Valid @RequestBody EquipmentRequest request) {
        Equipment equipment = equipmentService.createEquipment(request);
        return ResponseEntity.status(HttpStatus.CREATED).body(equipment);
    }

    @GetMapping
    public ResponseEntity<List<Equipment>> getAllEquipment() {
        List<Equipment> equipment = equipmentService.getAllEquipment();
        return ResponseEntity.ok(equipment);
    }

    @GetMapping("/{id}")
    public ResponseEntity<Equipment> getEquipmentById(@PathVariable Long id) {
        Equipment equipment = equipmentService.getEquipmentById(id);
        return ResponseEntity.ok(equipment);
    }

    @PutMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Equipment> updateEquipment(@PathVariable Long id, @Valid @RequestBody EquipmentRequest request) {
        Equipment equipment = equipmentService.updateEquipment(id, request);
        return ResponseEntity.ok(equipment);
    }

    @DeleteMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Void> deleteEquipment(@PathVariable Long id) {
        equipmentService.deleteEquipment(id);
        return ResponseEntity.noContent().build();
    }
}
