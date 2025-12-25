package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface UserRepository extends JpaRepository<User, Long> {

    Optional<User> findByEmail(String email);

    Optional<User> findBySsoId(String ssoId);

    List<User> findByUserType(String userType);

    List<User> findByDepartmentId(Long departmentId);

    @Query("SELECT u FROM User u WHERE u.userType = 'Καθηγητής'")
    List<User> findAllProfessors();

    @Query("SELECT u FROM User u WHERE u.userType = 'Φοιτητης'")
    List<User> findAllStudents();

    @Query("SELECT u FROM User u WHERE u.userType = 'Γραμματεια'")
    List<User> findAllSecretariat();

    boolean existsByEmail(String email);
}
