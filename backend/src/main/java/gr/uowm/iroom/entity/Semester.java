package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

import java.util.HashSet;
import java.util.Set;

/**
 * Semester entity (e.g., 1st, 2nd, 3rd, etc.)
 */
@Entity
@Table(name = "semester")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Semester extends BaseEntity {

    @NotBlank(message = "Semester name is required")
    @Column(name = "name", nullable = false, length = 5)
    private String name;

    @OneToMany(mappedBy = "semester", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<SemesterCourse> semesterCourses = new HashSet<>();
}
