package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

/**
 * User type entity
 */
@Entity
@Table(name = "type_user")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class UserType extends BaseEntity {

    @NotBlank(message = "Type is required")
    @Column(name = "type", nullable = false, length = 50)
    private String type;
}
