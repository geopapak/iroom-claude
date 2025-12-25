package gr.uowm.iroom;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.data.jpa.repository.config.EnableJpaAuditing;

/**
 * Main Spring Boot Application class for iRoom
 * University Room Scheduling System
 */
@SpringBootApplication
@EnableJpaAuditing
public class IroomApplication {

    public static void main(String[] args) {
        SpringApplication.run(IroomApplication.class, args);
    }
}
