package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links equipment to rooms and departments
 */
@Entity
@Table(name = "equipment_room")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class EquipmentRoom extends BaseEntity {

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_rooms", nullable = false)
    private Room room;

    @NotNull(message = "Equipment is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_equipment", nullable = false)
    private Equipment equipment;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;
}
