package gr.uowm.iroom.dto;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class UniversityRequest {
    @NotBlank(message = "University name is required")
    private String name;
}
