package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Password entity - stores hashed passwords for users
 */
@Entity
@Table(name = "password")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Password extends BaseEntity {

    @NotNull(message = "User is required")
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_user", nullable = false, unique = true)
    private User user;

    @NotBlank(message = "Password is required")
    @Column(name = "pass", nullable = false, length = 255)
    private String passwordHash;
}
