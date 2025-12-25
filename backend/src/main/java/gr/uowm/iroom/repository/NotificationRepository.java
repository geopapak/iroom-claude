package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Notification;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface NotificationRepository extends JpaRepository<Notification, Long> {
    List<Notification> findByStatus(Integer status);
    List<Notification> findByUserId(Long userId);
    List<Notification> findByDepartmentId(Long departmentId);

    @Query("SELECT COUNT(n) FROM Notification n WHERE n.status = 0")
    Long countPendingNotifications();

    @Query("SELECT n FROM Notification n WHERE n.status = 0 ORDER BY n.id DESC")
    List<Notification> findAllPending();
}
