import { useState } from 'react';
import {
  Container, Typography, Box, AppBar, Toolbar, IconButton, Tabs, Tab
} from '@mui/material';
import LogoutIcon from '@mui/icons-material/Logout';
import { useNavigate } from 'react-router-dom';
import useAuthStore from '../store/authStore';
import RoomManagement from '../components/management/RoomManagement';
import CourseManagement from '../components/management/CourseManagement';
import EquipmentManagement from '../components/management/EquipmentManagement';
import UserManagement from '../components/management/UserManagement';
import DepartmentManagement from '../components/management/DepartmentManagement';

function AdminDashboard() {
  const navigate = useNavigate();
  const { user, logout } = useAuthStore();
  const [tabValue, setTabValue] = useState(0);

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  const handleTabChange = (event, newValue) => {
    setTabValue(newValue);
  };

  return (
    <Box>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            iRoom - Διαχειριστής
          </Typography>
          <Typography variant="body1" sx={{ mr: 2 }}>
            {user?.name} {user?.lastName}
          </Typography>
          <IconButton color="inherit" onClick={handleLogout}>
            <LogoutIcon />
          </IconButton>
        </Toolbar>
      </AppBar>

      <Container maxWidth="xl" sx={{ mt: 4 }}>
        <Typography variant="h4" gutterBottom>
          Πίνακας Ελέγχου Διαχειριστή
        </Typography>

        <Box sx={{ borderBottom: 1, borderColor: 'divider', mt: 3 }}>
          <Tabs value={tabValue} onChange={handleTabChange}>
            <Tab label="Αίθουσες" />
            <Tab label="Μαθήματα" />
            <Tab label="Εξοπλισμός" />
            <Tab label="Χρήστες" />
            <Tab label="Τμήματα" />
          </Tabs>
        </Box>

        <Box sx={{ mt: 3 }}>
          {tabValue === 0 && <RoomManagement />}
          {tabValue === 1 && <CourseManagement />}
          {tabValue === 2 && <EquipmentManagement />}
          {tabValue === 3 && <UserManagement />}
          {tabValue === 4 && <DepartmentManagement />}
        </Box>
      </Container>
    </Box>
  );
}

export default AdminDashboard;
