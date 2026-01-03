package gr.uowm.iroom.dto;

import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

@Data
public class CreateUserRequest {
    @NotBlank(message = "Name is required")
    private String name;

    @NotBlank(message = "Last name is required")
    private String lastName;

    private Integer phone;

    @NotBlank(message = "Email is required")
    @Email(message = "Valid email is required")
    private String email;

    @NotNull(message = "Department ID is required")
    private Long departmentId;

    @NotBlank(message = "User type is required")
    private String userType; // Καθηγητής, Φοιτητης, Γραμματεια

    @NotBlank(message = "Password is required")
    private String password;

    private String ssoId;
}
