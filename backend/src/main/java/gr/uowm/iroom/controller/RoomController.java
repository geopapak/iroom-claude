package gr.uowm.iroom.controller;

import gr.uowm.iroom.dto.RoomRequest;
import gr.uowm.iroom.entity.Room;
import gr.uowm.iroom.service.RoomService;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/rooms")
@RequiredArgsConstructor
public class RoomController {

    private final RoomService roomService;

    @PostMapping
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Room> createRoom(@Valid @RequestBody RoomRequest request) {
        Room room = roomService.createRoom(request);
        return ResponseEntity.status(HttpStatus.CREATED).body(room);
    }

    @GetMapping
    public ResponseEntity<List<Room>> getAllRooms() {
        List<Room> rooms = roomService.getAllRooms();
        return ResponseEntity.ok(rooms);
    }

    @GetMapping("/{id}")
    public ResponseEntity<Room> getRoomById(@PathVariable Long id) {
        Room room = roomService.getRoomById(id);
        return ResponseEntity.ok(room);
    }

    @GetMapping("/department/{departmentId}")
    public ResponseEntity<List<Room>> getRoomsByDepartment(@PathVariable Long departmentId) {
        List<Room> rooms = roomService.getRoomsByDepartment(departmentId);
        return ResponseEntity.ok(rooms);
    }

    @PutMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('SECRETARIAT')")
    public ResponseEntity<Room> updateRoom(@PathVariable Long id, @Valid @RequestBody RoomRequest request) {
        Room room = roomService.updateRoom(id, request);
        return ResponseEntity.ok(room);
    }

    @DeleteMapping("/{id}")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<Void> deleteRoom(@PathVariable Long id) {
        roomService.deleteRoom(id);
        return ResponseEntity.noContent().build();
    }
}
