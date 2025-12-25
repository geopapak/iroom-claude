package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * User entity - for professors, students, and secretariat staff
 */
@Entity
@Table(name = "users")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class User extends BaseEntity {

    @NotBlank(message = "Name is required")
    @Column(name = "name", nullable = false, length = 25)
    private String name;

    @NotBlank(message = "Last name is required")
    @Column(name = "last_name", nullable = false, length = 25)
    private String lastName;

    @Column(name = "phone")
    private Integer phone;

    @NotBlank(message = "Email is required")
    @Email(message = "Valid email is required")
    @Column(name = "email", nullable = false, length = 25, unique = true)
    private String email;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;

    @NotBlank(message = "User type is required")
    @Column(name = "user_type", nullable = false, length = 25)
    private String userType; // Καθηγητής, Φοιτητης, Γραμματεια

    @Column(name = "sso_id", length = 255)
    private String ssoId;

    @OneToOne(mappedBy = "user", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private Password password;
}
