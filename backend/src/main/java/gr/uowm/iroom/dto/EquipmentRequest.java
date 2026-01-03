package gr.uowm.iroom.dto;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;

@Data
public class EquipmentRequest {
    @NotBlank(message = "Equipment name is required")
    private String name;
}
