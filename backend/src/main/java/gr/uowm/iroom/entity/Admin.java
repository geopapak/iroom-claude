package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

/**
 * Admin entity - system administrators
 */
@Entity
@Table(name = "admin")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Admin extends BaseEntity {

    @NotBlank(message = "Name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name;

    @NotBlank(message = "Last name is required")
    @Column(name = "last_name", nullable = false, length = 50)
    private String lastName;

    @Column(name = "phone", length = 50)
    private String phone;

    @NotBlank(message = "Email is required")
    @Email(message = "Valid email is required")
    @Column(name = "email", nullable = false, length = 25, unique = true)
    private String email;

    @NotBlank(message = "User type is required")
    @Column(name = "user_type", nullable = false, length = 25)
    private String userType; // Διαχειριστής

    @NotBlank(message = "Password is required")
    @Column(name = "pass", nullable = false, length = 255)
    private String passwordHash;
}
