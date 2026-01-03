package gr.uowm.iroom.dto;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

@Data
public class DepartmentRequest {
    @NotBlank(message = "Department name is required")
    private String name;

    @NotNull(message = "University ID is required")
    private Long universityId;

    @NotNull(message = "SSO department code is required")
    private Integer ssoDepart;
}
