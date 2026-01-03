package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.EquipmentRequest;
import gr.uowm.iroom.entity.Equipment;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.EquipmentRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class EquipmentService {

    private final EquipmentRepository equipmentRepository;

    @Transactional
    public Equipment createEquipment(EquipmentRequest request) {
        if (equipmentRepository.findByName(request.getName()).isPresent()) {
            throw new BadRequestException("Equipment already exists with name: " + request.getName());
        }

        Equipment equipment = Equipment.builder()
                .name(request.getName())
                .build();

        return equipmentRepository.save(equipment);
    }

    @Transactional(readOnly = true)
    public List<Equipment> getAllEquipment() {
        return equipmentRepository.findAll();
    }

    @Transactional(readOnly = true)
    public Equipment getEquipmentById(Long id) {
        return equipmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Equipment not found with id: " + id));
    }

    @Transactional
    public Equipment updateEquipment(Long id, EquipmentRequest request) {
        Equipment equipment = equipmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Equipment not found with id: " + id));

        if (!equipment.getName().equals(request.getName()) &&
            equipmentRepository.findByName(request.getName()).isPresent()) {
            throw new BadRequestException("Equipment already exists with name: " + request.getName());
        }

        equipment.setName(request.getName());
        return equipmentRepository.save(equipment);
    }

    @Transactional
    public void deleteEquipment(Long id) {
        Equipment equipment = equipmentRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Equipment not found with id: " + id));
        equipmentRepository.delete(equipment);
    }
}
