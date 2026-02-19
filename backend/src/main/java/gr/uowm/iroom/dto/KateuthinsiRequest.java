package gr.uowm.iroom.dto;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

@Data
public class KateuthinsiRequest {

    @NotBlank(message = "Specialization name is required")
    private String name;

    @NotNull(message = "Department ID is required")
    private Long departmentId;
}
