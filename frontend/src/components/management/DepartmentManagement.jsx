import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Typography, Alert, Table, TableBody, TableCell,
  TableContainer, TableHead, TableRow, Paper, IconButton
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { departmentAPI } from '../../services/api';

function DepartmentManagement() {
  const [departments, setDepartments] = useState([]);
  const [openDialog, setOpenDialog] = useState(false);
  const [editingDepartment, setEditingDepartment] = useState(null);
  const [formData, setFormData] = useState({
    name: '',
    universityId: '1', // Default to university ID 1
    ssoDepart: ''
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchDepartments();
  }, []);

  const fetchDepartments = async () => {
    try {
      const response = await departmentAPI.getAll();
      setDepartments(response.data);
    } catch (err) {
      console.error('Error fetching departments:', err);
      setError('Σφάλμα φόρτωσης τμημάτων');
    }
  };

  const handleOpenDialog = (department = null) => {
    if (department) {
      setEditingDepartment(department);
      setFormData({
        name: department.name,
        universityId: department.university?.id?.toString() || '1',
        ssoDepart: department.ssoDepart?.toString() || ''
      });
    } else {
      setEditingDepartment(null);
      setFormData({
        name: '',
        universityId: '1',
        ssoDepart: ''
      });
    }
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setEditingDepartment(null);
    setFormData({
      name: '',
      universityId: '1',
      ssoDepart: ''
    });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      const payload = {
        name: formData.name,
        universityId: parseInt(formData.universityId),
        ssoDepart: parseInt(formData.ssoDepart)
      };

      if (editingDepartment) {
        await departmentAPI.update(editingDepartment.id, payload);
        setSuccess('Το τμήμα ενημερώθηκε επιτυχώς');
      } else {
        await departmentAPI.create(payload);
        setSuccess('Το τμήμα δημιουργήθηκε επιτυχώς');
      }

      handleCloseDialog();
      fetchDepartments();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα κατά την αποθήκευση');
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το τμήμα;')) {
      try {
        await departmentAPI.delete(id);
        setSuccess('Το τμήμα διαγράφηκε επιτυχώς');
        fetchDepartments();
        setTimeout(() => setSuccess(''), 3000);
      } catch (err) {
        setError(err.response?.data?.message || 'Σφάλμα κατά τη διαγραφή');
      }
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h6">Διαχείριση Τμημάτων</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={() => handleOpenDialog()}
        >
          Νέο Τμήμα
        </Button>
      </Box>

      {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
      {success && <Alert severity="success" sx={{ mb: 2 }}>{success}</Alert>}

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Όνομα Τμήματος</TableCell>
              <TableCell>Πανεπιστήμιο</TableCell>
              <TableCell>Κωδικός SSO</TableCell>
              <TableCell align="right">Ενέργειες</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {departments.length === 0 ? (
              <TableRow>
                <TableCell colSpan={4} align="center">
                  Δεν βρέθηκαν τμήματα
                </TableCell>
              </TableRow>
            ) : (
              departments.map((department) => (
                <TableRow key={department.id}>
                  <TableCell>{department.name}</TableCell>
                  <TableCell>{department.university?.name || '-'}</TableCell>
                  <TableCell>{department.ssoDepart}</TableCell>
                  <TableCell align="right">
                    <IconButton
                      size="small"
                      onClick={() => handleOpenDialog(department)}
                      color="primary"
                    >
                      <EditIcon />
                    </IconButton>
                    <IconButton
                      size="small"
                      onClick={() => handleDelete(department.id)}
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
            {editingDepartment ? 'Επεξεργασία Τμήματος' : 'Νέο Τμήμα'}
          </DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}

            <TextField
              margin="normal"
              required
              fullWidth
              label="Όνομα Τμήματος"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              placeholder="π.χ. Τμήμα Πληροφορικής"
            />

            <TextField
              margin="normal"
              required
              fullWidth
              label="ID Πανεπιστημίου"
              type="number"
              value={formData.universityId}
              onChange={(e) => setFormData({ ...formData, universityId: e.target.value })}
              helperText="Προεπιλογή: 1 (Δημιουργήστε πανεπιστήμια πρώτα αν χρειάζεται)"
            />

            <TextField
              margin="normal"
              required
              fullWidth
              label="Κωδικός SSO Τμήματος"
              type="number"
              value={formData.ssoDepart}
              onChange={(e) => setFormData({ ...formData, ssoDepart: e.target.value })}
              helperText="Μοναδικός κωδικός για SSO authentication"
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseDialog}>Ακύρωση</Button>
            <Button type="submit" variant="contained">
              {editingDepartment ? 'Ενημέρωση' : 'Δημιουργία'}
            </Button>
          </DialogActions>
        </form>
      </Dialog>
    </Box>
  );
}

export default DepartmentManagement;
