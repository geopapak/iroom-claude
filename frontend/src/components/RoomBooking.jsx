import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Typography, Alert, Select, MenuItem, FormControl,
  InputLabel, Table, TableBody, TableCell, TableContainer,
  TableHead, TableRow, Paper, Chip
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import { roomAPI, notificationAPI } from '../services/api';
import useAuthStore from '../store/authStore';

function RoomBooking() {
  const { user } = useAuthStore();
  const [rooms, setRooms] = useState([]);
  const [bookings, setBookings] = useState([]);
  const [openDialog, setOpenDialog] = useState(false);
  const [formData, setFormData] = useState({
    roomId: '',
    subject: '',
    dayHour: ''
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchRooms();
    fetchMyBookings();
  }, []);

  const fetchRooms = async () => {
    try {
      const response = await roomAPI.getAll();
      setRooms(response.data);
    } catch (err) {
      console.error('Error fetching rooms:', err);
    }
  };

  const fetchMyBookings = async () => {
    try {
      if (user?.id) {
        const response = await notificationAPI.getUserNotifications(user.id);
        setBookings(response.data);
      }
    } catch (err) {
      console.error('Error fetching bookings:', err);
    }
  };

  const handleOpenDialog = () => {
    setFormData({ roomId: '', subject: '', dayHour: '' });
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setFormData({ roomId: '', subject: '', dayHour: '' });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      await notificationAPI.create({
        userId: user.id,
        roomId: parseInt(formData.roomId),
        subject: formData.subject,
        dayHour: parseInt(formData.dayHour),
        courseId: 1, // Placeholder
        departmentId: user.departmentId
      });

      setSuccess('Το αίτημα κράτησης υποβλήθηκε επιτυχώς');
      handleCloseDialog();
      fetchMyBookings();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα υποβολής αιτήματος');
    }
  };

  const getStatusColor = (status) => {
    if (status === 0) return 'warning'; // Pending
    if (status === 1) return 'success'; // Approved
    return 'error'; // Rejected
  };

  const getStatusText = (status) => {
    if (status === 0) return 'Εκκρεμεί';
    if (status === 1) return 'Εγκρίθηκε';
    return 'Απορρίφθηκε';
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h6">Κρατήσεις Αιθουσών</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={handleOpenDialog}
        >
          Νέα Κράτηση
        </Button>
      </Box>

      {success && <Alert severity="success" sx={{ mb: 2 }}>{success}</Alert>}

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Αίθουσα</TableCell>
              <TableCell>Σκοπός</TableCell>
              <TableCell>Κατάσταση</TableCell>
              <TableCell>Ημερομηνία</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {bookings.length === 0 ? (
              <TableRow>
                <TableCell colSpan={4} align="center">
                  Δεν υπάρχουν κρατήσεις
                </TableCell>
              </TableRow>
            ) : (
              bookings.map((booking) => (
                <TableRow key={booking.id}>
                  <TableCell>{booking.room?.name || '-'}</TableCell>
                  <TableCell>{booking.subject}</TableCell>
                  <TableCell>
                    <Chip
                      label={getStatusText(booking.status)}
                      color={getStatusColor(booking.status)}
                      size="small"
                    />
                  </TableCell>
                  <TableCell>
                    {booking.createdAt ? new Date(booking.createdAt).toLocaleDateString('el-GR') : '-'}
                  </TableCell>
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </TableContainer>

      {/* Booking Dialog */}
      <Dialog open={openDialog} onClose={handleCloseDialog} maxWidth="sm" fullWidth>
        <form onSubmit={handleSubmit}>
          <DialogTitle>Νέα Κράτηση Αίθουσας</DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}

            <FormControl fullWidth margin="normal" required>
              <InputLabel>Αίθουσα</InputLabel>
              <Select
                value={formData.roomId}
                label="Αίθουσα"
                onChange={(e) => setFormData({ ...formData, roomId: e.target.value })}
              >
                {rooms.map((room) => (
                  <MenuItem key={room.id} value={room.id}>
                    {room.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            <TextField
              margin="normal"
              required
              fullWidth
              label="Σκοπός Κράτησης"
              multiline
              rows={3}
              value={formData.subject}
              onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
            />

            <FormControl fullWidth margin="normal" required>
              <InputLabel>Ημέρα/Ώρα</InputLabel>
              <Select
                value={formData.dayHour}
                label="Ημέρα/Ώρα"
                onChange={(e) => setFormData({ ...formData, dayHour: e.target.value })}
              >
                <MenuItem value={1}>Δευτέρα 08:00-10:00</MenuItem>
                <MenuItem value={2}>Δευτέρα 10:00-12:00</MenuItem>
                <MenuItem value={3}>Τρίτη 08:00-10:00</MenuItem>
                <MenuItem value={4}>Τρίτη 10:00-12:00</MenuItem>
                <MenuItem value={5}>Τετάρτη 08:00-10:00</MenuItem>
                <MenuItem value={6}>Τετάρτη 10:00-12:00</MenuItem>
                <MenuItem value={7}>Πέμπτη 08:00-10:00</MenuItem>
                <MenuItem value={8}>Πέμπτη 10:00-12:00</MenuItem>
                <MenuItem value={9}>Παρασκευή 08:00-10:00</MenuItem>
                <MenuItem value={10}>Παρασκευή 10:00-12:00</MenuItem>
              </Select>
            </FormControl>
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseDialog}>Ακύρωση</Button>
            <Button type="submit" variant="contained">
              Υποβολή Αιτήματος
            </Button>
          </DialogActions>
        </form>
      </Dialog>
    </Box>
  );
}

export default RoomBooking;
