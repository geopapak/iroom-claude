import { useState, useEffect } from 'react';
import {
  Box, Button, Dialog, DialogTitle, DialogContent, DialogActions,
  TextField, Table, TableBody, TableCell, TableContainer, TableHead,
  TableRow, Paper, IconButton, Typography, Alert, CircularProgress,
  Select, MenuItem, FormControl, InputLabel
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { courseAPI } from '../../services/api';

function CourseManagement() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(false);
  const [openDialog, setOpenDialog] = useState(false);
  const [editingCourse, setEditingCourse] = useState(null);
  const [formData, setFormData] = useState({
    name: '',
    code: '',
    year: 1,
    optional: 'no'
  });
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  useEffect(() => {
    fetchCourses();
  }, []);

  const fetchCourses = async () => {
    setLoading(true);
    try {
      const response = await courseAPI.getAll();
      setCourses(response.data);
    } catch (err) {
      setError('Σφάλμα φόρτωσης μαθημάτων');
    } finally {
      setLoading(false);
    }
  };

  const handleOpenDialog = (course = null) => {
    if (course) {
      setEditingCourse(course);
      setFormData({
        name: course.name,
        code: course.code,
        year: course.year,
        optional: course.optional
      });
    } else {
      setEditingCourse(null);
      setFormData({ name: '', code: '', year: 1, optional: 'no' });
    }
    setOpenDialog(true);
    setError('');
  };

  const handleCloseDialog = () => {
    setOpenDialog(false);
    setEditingCourse(null);
    setFormData({ name: '', code: '', year: 1, optional: 'no' });
    setError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      if (editingCourse) {
        await courseAPI.update(editingCourse.id, formData);
        setSuccess('Το μάθημα ενημερώθηκε επιτυχώς');
      } else {
        await courseAPI.create(formData);
        setSuccess('Το μάθημα δημιουργήθηκε επιτυχώς');
      }
      handleCloseDialog();
      fetchCourses();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα αποθήκευσης μαθήματος');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το μάθημα;')) {
      return;
    }

    setLoading(true);
    try {
      await courseAPI.delete(id);
      setSuccess('Το μάθημα διαγράφηκε επιτυχώς');
      fetchCourses();
      setTimeout(() => setSuccess(''), 3000);
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα διαγραφής μαθήματος');
      setTimeout(() => setError(''), 3000);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h5">Διαχείριση Μαθημάτων</Typography>
        <Button
          variant="contained"
          startIcon={<AddIcon />}
          onClick={() => handleOpenDialog()}
        >
          Νέο Μάθημα
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
                <TableCell>Κωδικός</TableCell>
                <TableCell>Όνομα Μαθήματος</TableCell>
                <TableCell>Έτος</TableCell>
                <TableCell>Τύπος</TableCell>
                <TableCell align="right">Ενέργειες</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {courses.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={5} align="center">
                    Δεν βρέθηκαν μαθήματα
                  </TableCell>
                </TableRow>
              ) : (
                courses.map((course) => (
                  <TableRow key={course.id}>
                    <TableCell>{course.code}</TableCell>
                    <TableCell>{course.name}</TableCell>
                    <TableCell>{course.year}ο Έτος</TableCell>
                    <TableCell>{course.optional === 'yes' ? 'Επιλογής' : 'Υποχρεωτικό'}</TableCell>
                    <TableCell align="right">
                      <IconButton onClick={() => handleOpenDialog(course)} color="primary">
                        <EditIcon />
                      </IconButton>
                      <IconButton onClick={() => handleDelete(course.id)} color="error">
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
            {editingCourse ? 'Επεξεργασία Μαθήματος' : 'Νέο Μάθημα'}
          </DialogTitle>
          <DialogContent>
            {error && <Alert severity="error" sx={{ mb: 2 }}>{error}</Alert>}
            <TextField
              margin="normal"
              required
              fullWidth
              label="Όνομα Μαθήματος"
              value={formData.name}
              onChange={(e) => setFormData({ ...formData, name: e.target.value })}
              autoFocus
            />
            <TextField
              margin="normal"
              required
              fullWidth
              label="Κωδικός Μαθήματος"
              value={formData.code}
              onChange={(e) => setFormData({ ...formData, code: e.target.value })}
            />
            <FormControl fullWidth margin="normal">
              <InputLabel>Έτος</InputLabel>
              <Select
                value={formData.year}
                label="Έτος"
                onChange={(e) => setFormData({ ...formData, year: e.target.value })}
              >
                {[1, 2, 3, 4].map((year) => (
                  <MenuItem key={year} value={year}>{year}ο Έτος</MenuItem>
                ))}
              </Select>
            </FormControl>
            <FormControl fullWidth margin="normal">
              <InputLabel>Τύπος Μαθήματος</InputLabel>
              <Select
                value={formData.optional}
                label="Τύπος Μαθήματος"
                onChange={(e) => setFormData({ ...formData, optional: e.target.value })}
              >
                <MenuItem value="no">Υποχρεωτικό</MenuItem>
                <MenuItem value="yes">Επιλογής</MenuItem>
              </Select>
            </FormControl>
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

export default CourseManagement;
