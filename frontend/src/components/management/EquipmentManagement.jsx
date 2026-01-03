import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Table, TableBody, TableCell, TableContainer, TableHead,
  TableRow, Paper, IconButton, Typography, Alert, CircularProgress
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { equipmentAPI } from '../../services/api';

function EquipmentManagement() {
  const [equipment, setEquipment] = useState([]);
  const [loading, setLoading] = useState(false);
  const [openDialog, setOpenDialog] = useState(false);
  const [editingEquipment, setEditingEquipment] = useState(null);
  const [formData, setFormData] = useState({ name: '' });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchEquipment();
  }, []);

  const fetchEquipment = async () => {
    setLoading(true);
    try {
      const response = await equipmentAPI.getAll();
      setEquipment(response.data);
    } catch (err) {
      setError('Σφάλμα φόρτωσης εξοπλισμού');
    } finally {
      setLoading(false);
    }
  };

  const handleOpenDialog = (item = null) => {
    if (item) {
      setEditingEquipment(item);
      setFormData({ name: item.name });
    } else {
      setEditingEquipment(null);
      setFormData({ name: '' });
    }
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setEditingEquipment(null);
    setFormData({ name: '' });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      if (editingEquipment) {
        await equipmentAPI.update(editingEquipment.id, formData);
        setSuccess('Ο εξοπλισμός ενημερώθηκε επιτυχώς');
      } else {
        await equipmentAPI.create(formData);
        setSuccess('Ο εξοπλισμός δημιουργήθηκε επιτυχώς');
      }
      handleCloseDialog();
      fetchEquipment();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα αποθήκευσης εξοπλισμού');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό τον εξοπλισμό;')) {
      return;
    }

    setLoading(true);
    try {
      await equipmentAPI.delete(id);
      setSuccess('Ο εξοπλισμός διαγράφηκε επιτυχώς');
      fetchEquipment();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα διαγραφής εξοπλισμού');
      setTimeout(() => setError(''), 3000);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h5">Διαχείριση Εξοπλισμού</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={() => handleOpenDialog()}
        >
          Νέος Εξοπλισμός
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
                <TableCell>Όνομα Εξοπλισμού</TableCell>
                <TableCell align="right">Ενέργειες</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {equipment.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={3} align="center">
                    Δεν βρέθηκε εξοπλισμός
                  </TableCell>
                </TableRow>
              ) : (
                equipment.map((item) => (
                  <TableRow key={item.id}>
                    <TableCell>{item.id}</TableCell>
                    <TableCell>{item.name}</TableCell>
                    <TableCell align="right">
                      <IconButton onClick={() => handleOpenDialog(item)} color="primary">
                        <EditIcon />
                      </IconButton>
                      <IconButton onClick={() => handleDelete(item.id)} color="error">
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
            {editingEquipment ? 'Επεξεργασία Εξοπλισμού' : 'Νέος Εξοπλισμός'}
          </DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
            <TextField
              margin="normal"
              required
              fullWidth
              label="Όνομα Εξοπλισμού"
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

export default EquipmentManagement;
