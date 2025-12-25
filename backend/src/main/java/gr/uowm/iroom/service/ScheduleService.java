package gr.uowm.iroom.service;

import gr.uowm.iroom.entity.*;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.*;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class ScheduleService {

    private final ProgrammeRepository programmeRepository;
    private final ProgrammeRoomsRepository programmeRoomsRepository;
    private final SemesterCourseRepository semesterCourseRepository;
    private final DayRepository dayRepository;
    private final HourRepository hourRepository;
    private final ScheduleRepository scheduleRepository;
    private final RoomRepository roomRepository;
    private final CourseKateuthinsiRepository courseKateuthinsiRepository;

    @Transactional
    public Programme addToSchedule(Long semesterCourseId, Long dayId, Long hourId,
                                   Long userId, Long scheduleId, List<Long> roomIds) {
        // Validate inputs
        SemesterCourse semesterCourse = semesterCourseRepository.findById(semesterCourseId)
                .orElseThrow(() -> new ResourceNotFoundException("SemesterCourse", "id", semesterCourseId));

        Day day = dayRepository.findById(dayId)
                .orElseThrow(() -> new ResourceNotFoundException("Day", "id", dayId));

        Hour hour = hourRepository.findById(hourId)
                .orElseThrow(() -> new ResourceNotFoundException("Hour", "id", hourId));

        Schedule schedule = scheduleRepository.findById(scheduleId)
                .orElseThrow(() -> new ResourceNotFoundException("Schedule", "id", scheduleId));

        // Check conflicts
        checkProfessorConflict(userId, dayId, hourId, scheduleId);
        checkRoomConflicts(roomIds, dayId, hourId, scheduleId);
        checkSemesterConflicts(semesterCourse, dayId, hourId, scheduleId);

        // Create programme entry
        Programme programme = Programme.builder()
                .semesterCourse(semesterCourse)
                .day(day)
                .hour(hour)
                .user(semesterCourse.getCourse().getProfessors().iterator().next().getProfessor())
                .schedule(schedule)
                .build();

        programme = programmeRepository.save(programme);

        // Add room assignments
        Integer dayHourId = Integer.parseInt(hourId.toString() + dayId.toString());
        for (Long roomId : roomIds) {
            Room room = roomRepository.findById(roomId)
                    .orElseThrow(() -> new ResourceNotFoundException("Room", "id", roomId));

            ProgrammeRooms programmeRooms = ProgrammeRooms.builder()
                    .dayHourId(dayHourId)
                    .room(room)
                    .course(semesterCourse.getCourse())
                    .department(semesterCourse.getDepartment())
                    .schedule(schedule)
                    .build();

            programmeRoomsRepository.save(programmeRooms);
        }

        return programme;
    }

    private void checkProfessorConflict(Long userId, Long dayId, Long hourId, Long scheduleId) {
        List<Programme> existingProgrammes = programmeRepository
                .findByUserAndDayAndHourAndSchedule(userId, dayId, hourId, scheduleId);

        if (!existingProgrammes.isEmpty()) {
            throw new BadRequestException("Ο καθηγητής διδάσκει ήδη σε αυτήν την ώρα");
        }
    }

    private void checkRoomConflicts(List<Long> roomIds, Long dayId, Long hourId, Long scheduleId) {
        Integer dayHourId = Integer.parseInt(hourId.toString() + dayId.toString());

        for (Long roomId : roomIds) {
            List<ProgrammeRooms> existingRooms = programmeRoomsRepository
                    .findByRoomAndDayHourAndSchedule(roomId, dayHourId, scheduleId);

            if (!existingRooms.isEmpty()) {
                throw new BadRequestException("Η αίθουσα είναι ήδη δεσμευμένη σε αυτήν την ώρα");
            }
        }
    }

    private void checkSemesterConflicts(SemesterCourse newSemesterCourse, Long dayId, Long hourId, Long scheduleId) {
        // Skip for optional courses
        if (newSemesterCourse.getCourse().getOptional() == Course.OptionalStatus.yes) {
            return;
        }

        // Find all programmes at this time slot
        List<Programme> existingProgrammes = programmeRepository
                .findByDayAndHourAndSchedule(dayId, hourId, scheduleId);

        for (Programme existingProgramme : existingProgrammes) {
            SemesterCourse existingSemesterCourse = existingProgramme.getSemesterCourse();

            // Skip if different semesters
            if (!existingSemesterCourse.getSemester().getId().equals(newSemesterCourse.getSemester().getId())) {
                continue;
            }

            // Check kateuthinsi overlap
            List<CourseKateuthinsi> newCourseKats = courseKateuthinsiRepository
                    .findByCourseId(newSemesterCourse.getCourse().getId());
            List<CourseKateuthinsi> existingCourseKats = courseKateuthinsiRepository
                    .findByCourseId(existingSemesterCourse.getCourse().getId());

            // Check if they share any kateuthinsi
            for (CourseKateuthinsi newKat : newCourseKats) {
                for (CourseKateuthinsi existingKat : existingCourseKats) {
                    if (newKat.getKateuthinsi().getId().equals(existingKat.getKateuthinsi().getId())) {
                        throw new BadRequestException("Υπάρχει σύγκρουση με άλλο μάθημα του ίδιου εξαμήνου");
                    }
                }
            }
        }
    }

    public List<Programme> getScheduleByDepartment(Long departmentId, Long scheduleId) {
        return programmeRepository.findByDepartmentAndSchedule(departmentId, scheduleId);
    }

    public List<Programme> getScheduleByProfessor(Long userId, Long scheduleId) {
        return programmeRepository.findByUserId(userId);
    }

    @Transactional
    public void deleteProgramme(Long programmeId) {
        Programme programme = programmeRepository.findById(programmeId)
                .orElseThrow(() -> new ResourceNotFoundException("Programme", "id", programmeId));

        programmeRepository.delete(programme);
    }
}
