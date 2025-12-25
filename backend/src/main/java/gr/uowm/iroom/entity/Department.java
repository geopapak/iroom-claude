package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

import java.util.HashSet;
import java.util.Set;

/**
 * Department entity (departament in original DB)
 */
@Entity
@Table(name = "departament")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Department extends BaseEntity {

    @NotBlank(message = "Department name is required")
    @Column(name = "name", nullable = false, length = 50)
    private String name;

    @NotNull(message = "University is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_university", nullable = false)
    private University university;

    @NotNull(message = "SSO department code is required")
    @Column(name = "sso_depart", nullable = false)
    private Integer ssoDepart;

    @OneToMany(mappedBy = "department", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<User> users = new HashSet<>();

    @OneToMany(mappedBy = "department", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    @Builder.Default
    private Set<Kateuthinsi> kateuthinsiList = new HashSet<>();
}
