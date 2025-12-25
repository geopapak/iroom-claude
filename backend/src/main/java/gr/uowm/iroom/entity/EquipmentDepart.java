package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links equipment to departments
 */
@Entity
@Table(name = "equipment_depart")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class EquipmentDepart extends BaseEntity {

    @NotNull(message = "Equipment is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_equipment", nullable = false)
    private Equipment equipment;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;
}
