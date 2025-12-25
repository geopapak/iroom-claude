package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

/**
 * Schedule entity (academic year)
 */
@Entity
@Table(name = "schedules")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Schedule extends BaseEntity {

    @NotBlank(message = "Schedule name is required")
    @Column(name = "name", nullable = false, length = 20)
    private String name; // Academic year, e.g., "2023-2024"
}
