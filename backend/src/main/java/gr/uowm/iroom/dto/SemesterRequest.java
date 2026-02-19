package gr.uowm.iroom.dto;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class SemesterRequest {

    @NotBlank(message = "Semester name is required")
    private String name;
}
