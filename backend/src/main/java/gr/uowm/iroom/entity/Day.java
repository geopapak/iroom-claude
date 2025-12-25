package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

/**
 * Day entity (days of the week)
 */
@Entity
@Table(name = "days")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Day extends BaseEntity {

    @NotBlank(message = "Day name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name;
}
