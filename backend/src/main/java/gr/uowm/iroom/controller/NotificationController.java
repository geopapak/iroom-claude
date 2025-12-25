package gr.uowm.iroom.controller;

import gr.uowm.iroom.entity.Notification;
import gr.uowm.iroom.service.NotificationService;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/notifications")
@RequiredArgsConstructor
public class NotificationController {

    private final NotificationService notificationService;

    @GetMapping("/pending")
    public ResponseEntity<List<Notification>> getPendingNotifications() {
        List<Notification> notifications = notificationService.getAllPendingNotifications();
        return ResponseEntity.ok(notifications);
    }

    @GetMapping("/count")
    public ResponseEntity<Map<String, Long>> getPendingCount() {
        Long count = notificationService.getPendingCount();
        return ResponseEntity.ok(Map.of("count", count));
    }

    @GetMapping("/user/{userId}")
    public ResponseEntity<List<Notification>> getUserNotifications(@PathVariable Long userId) {
        List<Notification> notifications = notificationService.getNotificationsByUser(userId);
        return ResponseEntity.ok(notifications);
    }

    @PostMapping
    public ResponseEntity<Notification> createNotification(@RequestBody Notification notification) {
        Notification created = notificationService.createNotification(notification);
        return ResponseEntity.ok(created);
    }

    @PutMapping("/{id}/approve")
    public ResponseEntity<Notification> approveNotification(@PathVariable Long id) {
        Notification notification = notificationService.approveNotification(id);
        return ResponseEntity.ok(notification);
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<String> rejectNotification(@PathVariable Long id) {
        notificationService.rejectNotification(id);
        return ResponseEntity.ok("Notification rejected");
    }
}
