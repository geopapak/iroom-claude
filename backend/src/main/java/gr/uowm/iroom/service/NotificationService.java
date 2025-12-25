package gr.uowm.iroom.service;

import gr.uowm.iroom.entity.Notification;
import gr.uowm.iroom.exception.ResourceNotFoundException;
import gr.uowm.iroom.repository.NotificationRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class NotificationService {

    private final NotificationRepository notificationRepository;

    public List<Notification> getAllPendingNotifications() {
        return notificationRepository.findAllPending();
    }

    public Long getPendingCount() {
        return notificationRepository.countPendingNotifications();
    }

    public List<Notification> getNotificationsByUser(Long userId) {
        return notificationRepository.findByUserId(userId);
    }

    @Transactional
    public Notification createNotification(Notification notification) {
        notification.setStatus(0); // Pending
        return notificationRepository.save(notification);
    }

    @Transactional
    public Notification approveNotification(Long notificationId) {
        Notification notification = notificationRepository.findById(notificationId)
                .orElseThrow(() -> new ResourceNotFoundException("Notification", "id", notificationId));

        notification.setStatus(1); // Approved
        return notificationRepository.save(notification);
    }

    @Transactional
    public void rejectNotification(Long notificationId) {
        Notification notification = notificationRepository.findById(notificationId)
                .orElseThrow(() -> new ResourceNotFoundException("Notification", "id", notificationId));

        notificationRepository.delete(notification);
    }
}
