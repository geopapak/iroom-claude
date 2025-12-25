package gr.uowm.iroom.controller;

import gr.uowm.iroom.entity.Programme;
import gr.uowm.iroom.service.ScheduleService;
import lombok.Data;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/schedules")
@RequiredArgsConstructor
public class ScheduleController {

    private final ScheduleService scheduleService;

    @GetMapping("/{scheduleId}/department/{departmentId}")
    public ResponseEntity<List<Programme>> getScheduleByDepartment(
            @PathVariable Long scheduleId,
            @PathVariable Long departmentId) {
        List<Programme> programmes = scheduleService.getScheduleByDepartment(departmentId, scheduleId);
        return ResponseEntity.ok(programmes);
    }

    @GetMapping("/{scheduleId}/professor/{professorId}")
    public ResponseEntity<List<Programme>> getScheduleByProfessor(
            @PathVariable Long scheduleId,
            @PathVariable Long professorId) {
        List<Programme> programmes = scheduleService.getScheduleByProfessor(professorId, scheduleId);
        return ResponseEntity.ok(programmes);
    }

    @PostMapping("/{scheduleId}/programme")
    public ResponseEntity<Programme> addToSchedule(
            @PathVariable Long scheduleId,
            @RequestBody AddProgrammeRequest request) {
        Programme programme = scheduleService.addToSchedule(
                request.getSemesterCourseId(),
                request.getDayId(),
                request.getHourId(),
                request.getUserId(),
                scheduleId,
                request.getRoomIds()
        );
        return ResponseEntity.ok(programme);
    }

    @DeleteMapping("/programme/{programmeId}")
    public ResponseEntity<String> deleteProgramme(@PathVariable Long programmeId) {
        scheduleService.deleteProgramme(programmeId);
        return ResponseEntity.ok("Programme deleted successfully");
    }
}

@Data
class AddProgrammeRequest {
    private Long semesterCourseId;
    private Long dayId;
    private Long hourId;
    private Long userId;
    private List<Long> roomIds;
}
