import { useState, useEffect } from 'react';
import {
  Container, Typography, Box, AppBar, Toolbar, Button, IconButton,
  Badge, Drawer, List, ListItem, ListItemText, Paper, Grid, Alert
} from '@mui/material';
import NotificationsIcon from '@mui/icons-material/Notifications';
import LogoutIcon from '@mui/icons-material/Logout';
import { useNavigate } from 'react-router-dom';
import useAuthStore from '../store/authStore';
import { notificationAPI } from '../services/api';
import ScheduleGrid from '../components/ScheduleGrid';

function SecretariatDashboard() {
  const navigate = useNavigate();
  const { user, logout } = useAuthStore();
  const [notificationCount, setNotificationCount] = useState(0);
  const [notifications, setNotifications] = useState([]);
  const [drawerOpen, setDrawerOpen] = useState(false);
  const [successMessage, setSuccessMessage] = useState('');

  useEffect(() => {
    fetchNotificationCount();
    const interval = setInterval(fetchNotificationCount, 5000); // Poll every 5 seconds
    return () => clearInterval(interval);
  }, []);

  const fetchNotificationCount = async () => {
    try {
      const response = await notificationAPI.getCount();
      setNotificationCount(response.data.count);
    } catch (error) {
      console.error('Error fetching notification count:', error);
    }
  };

  const fetchNotifications = async () => {
    try {
      const response = await notificationAPI.getPending();
      setNotifications(response.data);
      setDrawerOpen(true);
    } catch (error) {
      console.error('Error fetching notifications:', error);
    }
  };

  const handleApprove = async (notificationId) => {
    try {
      await notificationAPI.approve(notificationId);
      setSuccessMessage('Η κράτηση εγκρίθηκε επιτυχώς');
      fetchNotifications();
      fetchNotificationCount();
      setTimeout(() => setSuccessMessage(''), 3000);
    } catch (error) {
      console.error('Error approving notification:', error);
    }
  };

  const handleReject = async (notificationId) => {
    try {
      await notificationAPI.reject(notificationId);
      setSuccessMessage('Η κράτηση απορρίφθηκε');
      fetchNotifications();
      fetchNotificationCount();
      setTimeout(() => setSuccessMessage(''), 3000);
    } catch (error) {
      console.error('Error rejecting notification:', error);
    }
  };

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <Box>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            iRoom - Γραμματεία
          </Typography>
          <Typography variant="body1" sx={{ mr: 2 }}>
            {user?.name} {user?.lastName}
          </Typography>
          <IconButton color="inherit" onClick={fetchNotifications}>
            <Badge badgeContent={notificationCount} color="error">
              <NotificationsIcon />
            </Badge>
          </IconButton>
          <IconButton color="inherit" onClick={handleLogout}>
            <LogoutIcon />
          </IconButton>
        </Toolbar>
      </AppBar>

      <Container maxWidth="xl" sx={{ mt: 4 }}>
        {successMessage && <Alert severity="success" sx={{ mb: 2 }}>{successMessage}</Alert>}

        <Typography variant="h4" gutterBottom>
          Διαχείριση Προγράμματος
        </Typography>

        <Paper sx={{ p: 3, mt: 3 }}>
          <ScheduleGrid departmentId={user?.departmentId} />
        </Paper>
      </Container>

      {/* Notifications Drawer */}
      <Drawer anchor="right" open={drawerOpen} onClose={() => setDrawerOpen(false)}>
        <Box sx={{ width: 400, p: 2 }}>
          <Typography variant="h6" gutterBottom>
            Αιτήματα Κράτησης ({notifications.length})
          </Typography>
          <List>
            {notifications.map((notification) => (
              <ListItem key={notification.id} sx={{ flexDirection: 'column', alignItems: 'flex-start', borderBottom: '1px solid #eee' }}>
                <Typography variant="subtitle1">
                  {notification.user?.name} {notification.user?.lastName}
                </Typography>
                <Typography variant="body2" color="text.secondary">
                  Μάθημα: {notification.course?.name}
                </Typography>
                <Typography variant="body2" color="text.secondary">
                  Αίθουσα: {notification.room?.name}
                </Typography>
                <Typography variant="body2" color="text.secondary">
                  Σκοπός: {notification.subject}
                </Typography>
                <Box sx={{ mt: 1, display: 'flex', gap: 1 }}>
                  <Button size="small" variant="contained" color="success" onClick={() => handleApprove(notification.id)}>
                    Έγκριση
                  </Button>
                  <Button size="small" variant="outlined" color="error" onClick={() => handleReject(notification.id)}>
                    Απόρριψη
                  </Button>
                </Box>
              </ListItem>
            ))}
            {notifications.length === 0 && (
              <Typography variant="body2" color="text.secondary" align="center" sx={{ mt: 2 }}>
                Δεν υπάρχουν εκκρεμή αιτήματα
              </Typography>
            )}
          </List>
        </Box>
      </Drawer>
    </Box>
  );
}

export default SecretariatDashboard;
