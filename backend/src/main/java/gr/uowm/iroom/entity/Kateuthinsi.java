package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Kateuthinsi entity (academic track/specialization)
 */
@Entity
@Table(name = "kateuthinsi")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Kateuthinsi extends BaseEntity {

    @NotBlank(message = "Kateuthinsi name is required")
    @Column(name = "name", nullable = false, length = 255)
    private String name;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_department", nullable = false)
    private Department department;
}
