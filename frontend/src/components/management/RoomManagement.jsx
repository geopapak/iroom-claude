import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Table, TableBody, TableCell, TableContainer, TableHead,
  TableRow, Paper, IconButton, Typography, Alert, CircularProgress
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { roomAPI } from '../../services/api';

function RoomManagement() {
  const [rooms, setRooms] = useState([]);
  const [loading, setLoading] = useState(false);
  const [openDialog, setOpenDialog] = useState(false);
  const [editingRoom, setEditingRoom] = useState(null);
  const [formData, setFormData] = useState({ name: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchRooms();
  }, []);

  const fetchRooms = async () => {
    setLoading(true);
    try {
      const response = await roomAPI.getAll();
      setRooms(response.data);
    } catch (err) {
      setError('Σφάλμα φόρτωσης αιθουσών');
    } finally {
      setLoading(false);
    }
  };

  const handleOpenDialog = (room = null) => {
    if (room) {
      setEditingRoom(room);
      setFormData({ name: room.name });
    } else {
      setEditingRoom(null);
      setFormData({ name: '' });
    }
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setEditingRoom(null);
    setFormData({ name: '' });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      if (editingRoom) {
        await roomAPI.update(editingRoom.id, formData);
        setSuccess('Η αίθουσα ενημερώθηκε επιτυχώς');
      } else {
        await roomAPI.create(formData);
        setSuccess('Η αίθουσα δημιουργήθηκε επιτυχώς');
      }
      handleCloseDialog();
      fetchRooms();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα αποθήκευσης αίθουσας');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή την αίθουσα;')) {
      return;
    }

    setLoading(true);
    try {
      await roomAPI.delete(id);
      setSuccess('Η αίθουσα διαγράφηκε επιτυχώς');
      fetchRooms();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα διαγραφής αίθουσας');
      setTimeout(() => setError(''), 3000);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h5">Διαχείριση Αιθουσών</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={() => handleOpenDialog()}
        >
          Νέα Αίθουσα
        </Button>
      </Box>

      {success && <Alert severity="success" sx={{ mb: 2 }}>{success}</Alert>}
      {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}

      {loading && !openDialog ? (
        <Box sx={{ display: 'flex', justifyContent: 'center', p: 3 }}>
          <CircularProgress />
        </Box>
      ) : (
        <TableContainer component={Paper}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>ID</TableCell>
                <TableCell>Όνομα Αίθουσας</TableCell>
                <TableCell align="right">Ενέργειες</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {rooms.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={3} align="center">
                    Δεν βρέθηκαν αίθουσες
                  </TableCell>
                </TableRow>
              ) : (
                rooms.map((room) => (
                  <TableRow key={room.id}>
                    <TableCell>{room.id}</TableCell>
                    <TableCell>{room.name}</TableCell>
                    <TableCell align="right">
                      <IconButton onClick={() => handleOpenDialog(room)} color="primary">
                        <EditIcon />
                      </IconButton>
                      <IconButton onClick={() => handleDelete(room.id)} color="error">
                        <DeleteIcon />
                      </IconButton>
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </TableContainer>
      )}

      {/* Create/Edit Dialog */}
      <Dialog open={openDialog} onClose={handleCloseDialog} maxWidth="sm" fullWidth>
        <form onSubmit={handleSubmit}>
          <DialogTitle>
            {editingRoom ? 'Επεξεργασία Αίθουσας' : 'Νέα Αίθουσα'}
          </DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
            <TextField
              margin="normal"
              required
              fullWidth
              label="Όνομα Αίθουσας"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              autoFocus
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseDialog}>Ακύρωση</Button>
            <Button type="submit" variant="contained" disabled={loading}>
              {loading ? 'Αποθήκευση...' : 'Αποθήκευση'}
            </Button>
          </DialogActions>
        </form>
      </Dialog>
    </Box>
  );
}

export default RoomManagement;
