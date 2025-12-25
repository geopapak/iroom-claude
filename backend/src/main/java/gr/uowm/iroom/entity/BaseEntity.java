package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

/**
 * Base entity class with common ID field for all entities
 * Note: Removed audit fields (createdAt, updatedAt) as they don't exist in the original database
 */
@Getter
@Setter
@MappedSuperclass
public abstract class BaseEntity {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "ID")
    private Long id;
}
