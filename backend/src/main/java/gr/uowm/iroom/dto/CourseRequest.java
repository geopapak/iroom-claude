package gr.uowm.iroom.dto;

import gr.uowm.iroom.entity.Course;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

@Data
public class CourseRequest {
    @NotBlank(message = "Course name is required")
    private String name;

    @NotNull(message = "Year is required")
    private Integer year;

    @NotBlank(message = "Course code is required")
    private String code;

    @NotNull(message = "Optional status is required")
    private Course.OptionalStatus optional;

    private Long departmentId;
    private Long semesterId;
}
