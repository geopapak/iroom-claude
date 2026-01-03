package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.RoomRequest;
import gr.uowm.iroom.entity.Department;
import gr.uowm.iroom.entity.Room;
import gr.uowm.iroom.entity.RoomDepart;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.DepartmentRepository;
import gr.uowm.iroom.repository.RoomDepartRepository;
import gr.uowm.iroom.repository.RoomRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class RoomService {

    private final RoomRepository roomRepository;
    private final DepartmentRepository departmentRepository;
    private final RoomDepartRepository roomDepartRepository;

    @Transactional
    public Room createRoom(RoomRequest request) {
        // Check if room name already exists
        if (roomRepository.findByName(request.getName()).isPresent()) {
            throw new BadRequestException("Room already exists with name: " + request.getName());
        }

        Room room = Room.builder()
                .name(request.getName())
                .build();

        room = roomRepository.save(room);

        // If department is specified, create room-department association
        if (request.getDepartmentId() != null) {
            Department department = departmentRepository.findById(request.getDepartmentId())
                    .orElseThrow(() -> new ResourceNotFoundException("Department not found with id: " + request.getDepartmentId()));

            RoomDepart roomDepart = RoomDepart.builder()
                    .room(room)
                    .department(department)
                    .build();

            roomDepartRepository.save(roomDepart);
        }

        return room;
    }

    @Transactional(readOnly = true)
    public List<Room> getAllRooms() {
        return roomRepository.findAll();
    }

    @Transactional(readOnly = true)
    public Room getRoomById(Long id) {
        return roomRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Room not found with id: " + id));
    }

    @Transactional(readOnly = true)
    public List<Room> getRoomsByDepartment(Long departmentId) {
        return roomRepository.findByDepartmentId(departmentId);
    }

    @Transactional
    public Room updateRoom(Long id, RoomRequest request) {
        Room room = roomRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Room not found with id: " + id));

        // Check if new name conflicts with existing room
        if (!room.getName().equals(request.getName()) &&
            roomRepository.findByName(request.getName()).isPresent()) {
            throw new BadRequestException("Room already exists with name: " + request.getName());
        }

        room.setName(request.getName());
        return roomRepository.save(room);
    }

    @Transactional
    public void deleteRoom(Long id) {
        Room room = roomRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Room not found with id: " + id));

        roomRepository.delete(room);
    }
}
