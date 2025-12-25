package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Notification entity for room booking requests
 */
@Entity
@Table(name = "notification")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Notification extends BaseEntity {

    @NotNull(message = "User is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_user", nullable = false)
    private User user;

    @NotNull(message = "Day-hour ID is required")
    @Column(name = "ID_day_hour", nullable = false)
    private Integer dayHourId;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_room", nullable = false)
    private Room room;

    @NotBlank(message = "Subject is required")
    @Column(name = "subject", nullable = false, length = 250)
    private String subject;

    @NotNull(message = "Status is required")
    @Column(name = "status", nullable = false)
    private Integer status; // 0 = pending, 1 = approved
}
