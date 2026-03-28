package gr.uowm.iroom.entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.*;

import java.util.HashSet;
import java.util.Set;

/**
 * University entity
 */
@Entity
@Table(name = "university")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class University extends BaseEntity {

    @NotBlank(message = "University name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name;

    @JsonIgnore
    @OneToMany(mappedBy = "university", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<Department> departments = new HashSet<>();
}
