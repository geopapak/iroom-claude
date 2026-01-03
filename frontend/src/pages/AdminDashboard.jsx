import { useState, useEffect } from 'react';
import {
  Container, Typography, Box, AppBar, Toolbar, IconButton, Paper, Grid, Card, CardContent,
  Button, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Chip
} from '@mui/material';
import LogoutIcon from '@mui/icons-material/Logout';
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import { useNavigate } from 'react-router-dom';
import useAuthStore from '../store/authStore';
import CreateUserModal from '../components/CreateUserModal';
import api from '../services/api';

function AdminDashboard() {
  const navigate = useNavigate();
  const { user, logout } = useAuthStore();
  const [openCreateModal, setOpenCreateModal] = useState(false);
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    setLoading(true);
    try {
      const response = await api.get('/users');
      setUsers(response.data);
    } catch (err) {
      console.error('Error fetching users:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  const handleUserCreated = (newUser) => {
    setUsers(prev => [...prev, newUser]);
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
          <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
            <Typography variant="h6">
              Διαχείριση Χρηστών
            </Typography>
            <Button
              variant="contained"
              startIcon={<PersonAddIcon />}
              onClick={() => setOpenCreateModal(true)}
            >
              Δημιουργία Χρήστη
            </Button>
          </Box>

          <TableContainer>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell>Όνομα</TableCell>
                  <TableCell>Email</TableCell>
                  <TableCell>Τύπος Χρήστη</TableCell>
                  <TableCell>Τμήμα</TableCell>
                  <TableCell>Τηλέφωνο</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {loading ? (
                  <TableRow>
                    <TableCell colSpan={5} align="center">
                      Φόρτωση...
                    </TableCell>
                  </TableRow>
                ) : users.length === 0 ? (
                  <TableRow>
                    <TableCell colSpan={5} align="center">
                      Δεν υπάρχουν χρήστες
                    </TableCell>
                  </TableRow>
                ) : (
                  users.map((u) => (
                    <TableRow key={u.id}>
                      <TableCell>
                        {u.name} {u.lastName}
                      </TableCell>
                      <TableCell>{u.email}</TableCell>
                      <TableCell>
                        <Chip
                          label={u.userType}
                          color={
                            u.userType === 'Καθηγητής' ? 'primary' :
                            u.userType === 'Φοιτητής' ? 'success' :
                            'default'
                          }
                          size="small"
                        />
                      </TableCell>
                      <TableCell>{u.department?.name || '-'}</TableCell>
                      <TableCell>{u.phone || '-'}</TableCell>
                    </TableRow>
                  ))
                )}
              </TableBody>
            </Table>
          </TableContainer>
        </Paper>

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

      <CreateUserModal
        open={openCreateModal}
        onClose={() => setOpenCreateModal(false)}
        onUserCreated={handleUserCreated}
      />
    </Box>
  );
}

export default AdminDashboard;
