package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links rooms to departments
 */
@Entity
@Table(name = "room_depart")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class RoomDepart extends BaseEntity {

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_room", nullable = false)
    private Room room;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;
}
