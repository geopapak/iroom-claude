import {
  Container, Typography, Box, AppBar, Toolbar, IconButton, Paper, Grid, Card, CardContent
} from '@mui/material';
import LogoutIcon from '@mui/icons-material/Logout';
import { useNavigate } from 'react-router-dom';
import useAuthStore from '../store/authStore';

function AdminDashboard() {
  const navigate = useNavigate();
  const { user, logout } = useAuthStore();

  const handleLogout = () => {
    logout();
    navigate('/login');
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

        <Grid container spacing={3} sx={{ mt: 2 }}>
          <Grid item xs={12} md={6} lg={3}>
            <Card>
              <CardContent>
                <Typography variant="h6" color="primary">
                  Χρήστες
                </Typography>
                <Typography variant="h4">-</Typography>
                <Typography variant="body2" color="text.secondary">
                  Διαχείριση χρηστών
                </Typography>
              </CardContent>
            </Card>
          </Grid>

          <Grid item xs={12} md={6} lg={3}>
            <Card>
              <CardContent>
                <Typography variant="h6" color="primary">
                  Μαθήματα
                </Typography>
                <Typography variant="h4">-</Typography>
                <Typography variant="body2" color="text.secondary">
                  Διαχείριση μαθημάτων
                </Typography>
              </CardContent>
            </Card>
          </Grid>

          <Grid item xs={12} md={6} lg={3}>
            <Card>
              <CardContent>
                <Typography variant="h6" color="primary">
                  Αίθουσες
                </Typography>
                <Typography variant="h4">-</Typography>
                <Typography variant="body2" color="text.secondary">
                  Διαχείριση αιθουσών
                </Typography>
              </CardContent>
            </Card>
          </Grid>

          <Grid item xs={12} md={6} lg={3}>
            <Card>
              <CardContent>
                <Typography variant="h6" color="primary">
                  Τμήματα
                </Typography>
                <Typography variant="h4">-</Typography>
                <Typography variant="body2" color="text.secondary">
                  Διαχείριση τμημάτων
                </Typography>
              </CardContent>
            </Card>
          </Grid>
        </Grid>

        <Paper sx={{ p: 3, mt: 4 }}>
          <Typography variant="h6" gutterBottom>
            Ρυθμίσεις Συστήματος
          </Typography>
          <Typography variant="body1" color="text.secondary">
            Ο πίνακας διαχείρισης θα περιλαμβάνει:
          </Typography>
          <ul>
            <li>Διαχείριση ημερών και ωρών λειτουργίας</li>
            <li>Διαχείριση ακαδημαϊκών ετών</li>
            <li>Διαχείριση εξαμήνων</li>
            <li>Ρυθμίσεις βάσης δεδομένων</li>
            <li>Διαχείριση δικαιωμάτων χρηστών</li>
          </ul>
        </Paper>
      </Container>
    </Box>
  );
}

export default AdminDashboard;
