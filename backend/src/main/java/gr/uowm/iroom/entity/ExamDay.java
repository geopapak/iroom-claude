package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

/**
 * Exam days entity
 */
@Entity
@Table(name = "exam_days")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ExamDay extends BaseEntity {

    @NotBlank(message = "Exam day name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name; // Date of exam
}
