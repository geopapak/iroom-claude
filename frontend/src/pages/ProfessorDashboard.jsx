import { useState } from 'react';
import {
  Container, Typography, Box, AppBar, Toolbar, IconButton, Paper, Tabs, Tab
} from '@mui/material';
import LogoutIcon from '@mui/icons-material/Logout';
import { useNavigate } from 'react-router-dom';
import useAuthStore from '../store/authStore';
import ScheduleGrid from '../components/ScheduleGrid';

function ProfessorDashboard() {
  const navigate = useNavigate();
  const { user, logout } = useAuthStore();
  const [tabValue, setTabValue] = useState(0);

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <Box>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            iRoom - Καθηγητής
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
          Καλώς ήρθατε, {user?.name}
        </Typography>

        <Box sx={{ borderBottom: 1, borderColor: 'divider', mt: 3 }}>
          <Tabs value={tabValue} onChange={(e, newValue) => setTabValue(newValue)}>
            <Tab label="Το Πρόγραμμά Μου" />
            <Tab label="Όλα τα Μαθήματα" />
            <Tab label="Κράτηση Αίθουσας" />
          </Tabs>
        </Box>

        {tabValue === 0 && (
          <Paper sx={{ p: 3, mt: 3 }}>
            <ScheduleGrid professorId={user?.id} />
          </Paper>
        )}

        {tabValue === 1 && (
          <Paper sx={{ p: 3, mt: 3 }}>
            <ScheduleGrid departmentId={user?.departmentId} />
          </Paper>
        )}

        {tabValue === 2 && (
          <Paper sx={{ p: 3, mt: 3 }}>
            <Typography variant="h6" gutterBottom>
              Κράτηση Αίθουσας
            </Typography>
            <Typography variant="body1" color="text.secondary">
              Η λειτουργικότητα κράτησης αιθουσών θα υλοποιηθεί σύντομα.
              Οι καθηγητές θα μπορούν να υποβάλλουν αιτήματα κράτησης που θα
              εγκρίνονται από τη Γραμματεία.
            </Typography>
          </Paper>
        )}
      </Container>
    </Box>
  );
}

export default ProfessorDashboard;
