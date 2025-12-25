package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Hour entity (time slots)
 */
@Entity
@Table(name = "hours")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Hour extends BaseEntity {

    @NotNull(message = "Start hour is required")
    @Column(name = "start_hour", nullable = false)
    private Integer startHour;

    @NotNull(message = "End hour is required")
    @Column(name = "end_hour", nullable = false)
    private Integer endHour;
}
