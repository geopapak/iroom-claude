package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Admin semester settings (odd/even semester type per department)
 */
@Entity
@Table(name = "admin_sem")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class AdminSem extends BaseEntity {

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_department", nullable = false)
    private Department department;

    @NotNull(message = "Semester is required")
    @Column(name = "ID_sem", nullable = false)
    private Integer semesterId; // 1 = winter, 2 = spring
}
