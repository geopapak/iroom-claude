import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Typography, Alert, Table, TableBody, TableCell,
  TableContainer, TableHead, TableRow, Paper, IconButton,
  Select, MenuItem, FormControl, InputLabel, Chip
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { userAPI, departmentAPI } from '../../services/api';

function UserManagement() {
  const [users, setUsers] = useState([]);
  const [departments, setDepartments] = useState([]);
  const [openDialog, setOpenDialog] = useState(false);
  const [editingUser, setEditingUser] = useState(null);
  const [formData, setFormData] = useState({
    name: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    departmentId: '',
    userType: ''
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchUsers();
    fetchDepartments();
  }, []);

  const fetchUsers = async () => {
    try {
      const response = await userAPI.getAll();
      setUsers(response.data);
    } catch (err) {
      console.error('Error fetching users:', err);
      setError('Σφάλμα φόρτωσης χρηστών');
    }
  };

  const fetchDepartments = async () => {
    try {
      const response = await departmentAPI.getAll();
      setDepartments(response.data);
    } catch (err) {
      console.error('Error fetching departments:', err);
    }
  };

  const handleOpenDialog = (user = null) => {
    if (user) {
      setEditingUser(user);
      setFormData({
        name: user.name,
        lastName: user.lastName,
        email: user.email,
        phone: user.phone || '',
        password: '',
        departmentId: user.department?.id || '',
        userType: user.userType
      });
    } else {
      setEditingUser(null);
      setFormData({
        name: '',
        lastName: '',
        email: '',
        phone: '',
        password: '',
        departmentId: '',
        userType: ''
      });
    }
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setEditingUser(null);
    setFormData({
      name: '',
      lastName: '',
      email: '',
      phone: '',
      password: '',
      departmentId: '',
      userType: ''
    });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      const payload = {
        name: formData.name,
        lastName: formData.lastName,
        email: formData.email,
        phone: formData.phone ? parseInt(formData.phone) : null,
        departmentId: parseInt(formData.departmentId),
        userType: formData.userType,
        password: formData.password
      };

      if (editingUser) {
        await userAPI.update(editingUser.id, payload);
        setSuccess('Ο χρήστης ενημερώθηκε επιτυχώς');
      } else {
        await userAPI.create(payload);
        setSuccess('Ο χρήστης δημιουργήθηκε επιτυχώς');
      }

      handleCloseDialog();
      fetchUsers();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα κατά την αποθήκευση');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτόν τον χρήστη;')) {
      try {
        await userAPI.delete(id);
        setSuccess('Ο χρήστης διαγράφηκε επιτυχώς');
        fetchUsers();
        setTimeout(() => setSuccess(''), 3000);
      } catch (err) {
        setError(err.response?.data?.message || 'Σφάλμα κατά τη διαγραφή');
      }
    }
  };

  const getUserTypeColor = (type) => {
    switch (type) {
      case 'Διαχειριστής': return 'error';
      case 'Γραμματεία': return 'primary';
      case 'Καθηγητής': return 'success';
      case 'Φοιτητής': return 'info';
      default: return 'default';
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h6">Διαχείριση Χρηστών</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={() => handleOpenDialog()}
        >
          Νέος Χρήστης
        </Button>
      </Box>

      {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
      {success && <Alert severity="success" sx={{ mb: 2 }}>{success}</Alert>}

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Όνομα</TableCell>
              <TableCell>Επώνυμο</TableCell>
              <TableCell>Email</TableCell>
              <TableCell>Τηλέφωνο</TableCell>
              <TableCell>Τμήμα</TableCell>
              <TableCell>Ρόλος</TableCell>
              <TableCell align="right">Ενέργειες</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {users.length === 0 ? (
              <TableRow>
                <TableCell colSpan={7} align="center">
                  Δεν βρέθηκαν χρήστες
                </TableCell>
              </TableRow>
            ) : (
              users.map((user) => (
                <TableRow key={user.id}>
                  <TableCell>{user.name}</TableCell>
                  <TableCell>{user.lastName}</TableCell>
                  <TableCell>{user.email}</TableCell>
                  <TableCell>{user.phone || '-'}</TableCell>
                  <TableCell>{user.department?.name || '-'}</TableCell>
                  <TableCell>
                    <Chip
                      label={user.userType}
                      color={getUserTypeColor(user.userType)}
                      size="small"
                    />
                  </TableCell>
                  <TableCell align="right">
                    <IconButton
                      size="small"
                      onClick={() => handleOpenDialog(user)}
                      color="primary"
                    >
                      <EditIcon />
                    </IconButton>
                    <IconButton
                      size="small"
                      onClick={() => handleDelete(user.id)}
                      color="error"
                    >
                      <DeleteIcon />
                    </IconButton>
                  </TableCell>
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </TableContainer>

      {/* Create/Edit Dialog */}
      <Dialog open={openDialog} onClose={handleCloseDialog} maxWidth="sm" fullWidth>
        <form onSubmit={handleSubmit}>
          <DialogTitle>
            {editingUser ? 'Επεξεργασία Χρήστη' : 'Νέος Χρήστης'}
          </DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}

            <TextField
              margin="normal"
              required
              fullWidth
              label="Όνομα"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
            />

            <TextField
              margin="normal"
              required
              fullWidth
              label="Επώνυμο"
              value={formData.lastName}
              onChange={(e) => setFormData({ ...formData, lastName: e.target.value })}
            />

            <TextField
              margin="normal"
              required
              fullWidth
              label="Email"
              type="email"
              value={formData.email}
              onChange={(e) => setFormData({ ...formData, email: e.target.value })}
            />

            <TextField
              margin="normal"
              fullWidth
              label="Τηλέφωνο"
              value={formData.phone}
              onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
            />

            <FormControl fullWidth margin="normal" required>
              <InputLabel>Τμήμα</InputLabel>
              <Select
                value={formData.departmentId}
                label="Τμήμα"
                onChange={(e) => setFormData({ ...formData, departmentId: e.target.value })}
              >
                {departments.map((dept) => (
                  <MenuItem key={dept.id} value={dept.id}>
                    {dept.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            <FormControl fullWidth margin="normal" required>
              <InputLabel>Ρόλος</InputLabel>
              <Select
                value={formData.userType}
                label="Ρόλος"
                onChange={(e) => setFormData({ ...formData, userType: e.target.value })}
              >
                <MenuItem value="Διαχειριστής">Διαχειριστής</MenuItem>
                <MenuItem value="Γραμματεία">Γραμματεία</MenuItem>
                <MenuItem value="Καθηγητής">Καθηγητής</MenuItem>
                <MenuItem value="Φοιτητής">Φοιτητής</MenuItem>
              </Select>
            </FormControl>

            <TextField
              margin="normal"
              fullWidth
              label={editingUser ? 'Νέος Κωδικός (προαιρετικό)' : 'Κωδικός'}
              type="password"
              required={!editingUser}
              value={formData.password}
              onChange={(e) => setFormData({ ...formData, password: e.target.value })}
              helperText={editingUser ? 'Αφήστε κενό για να μην αλλάξει ο κωδικός' : ''}
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseDialog}>Ακύρωση</Button>
            <Button type="submit" variant="contained">
              {editingUser ? 'Ενημέρωση' : 'Δημιουργία'}
            </Button>
          </DialogActions>
        </form>
      </Dialog>
    </Box>
  );
}

export default UserManagement;
