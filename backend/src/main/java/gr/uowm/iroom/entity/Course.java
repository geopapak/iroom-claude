package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

import java.util.HashSet;
import java.util.Set;

/**
 * Course entity
 */
@Entity
@Table(name = "course")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Course extends BaseEntity {

    @NotBlank(message = "Course name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name;

    @NotNull(message = "Year is required")
    @Column(name = "year", nullable = false)
    private Integer year;

    @NotBlank(message = "Course code is required")
    @Column(name = "code", nullable = false, length = 20)
    private String code;

    @NotNull(message = "Optional flag is required")
    @Enumerated(EnumType.STRING)
    @Column(name = "optional", nullable = false, length = 3)
    private OptionalStatus optional;

    @OneToMany(mappedBy = "course", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<SemesterCourse> semesterCourses = new HashSet<>();

    @OneToMany(mappedBy = "course", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<CourseProfessor> professors = new HashSet<>();

    public enum OptionalStatus {
        yes, no
    }
}
