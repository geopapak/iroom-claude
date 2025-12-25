import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Box, Container, TextField, Button, Typography, Alert, Paper } from '@mui/material';
import { authAPI } from '../services/api';
import useAuthStore from '../store/authStore';

function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const login = useAuthStore((state) => state.login);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const response = await authAPI.login({ email, password });
      const { token, ...userData } = response.data;

      login(userData, token);

      // Redirect based on user type
      switch (userData.userType) {
        case 'Διαχειριστής':
          navigate('/admin');
          break;
        case 'Γραμματεια':
          navigate('/secretariat');
          break;
        case 'Καθηγητής':
          navigate('/professor');
          break;
        case 'Φοιτητης':
          navigate('/student');
          break;
        default:
          navigate('/');
      }
    } catch (err) {
      setError(err.response?.data?.message || 'Σφάλμα σύνδεσης. Παρακαλώ ελέγξτε τα στοιχεία σας.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <Container maxWidth="sm">
      <Box sx={{ mt: 8, display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
        <Paper elevation={3} sx={{ p: 4, width: '100%' }}>
          <Typography component="h1" variant="h4" align="center" gutterBottom>
            iRoom
          </Typography>
          <Typography component="h2" variant="h6" align="center" color="text.secondary" gutterBottom>
            Σύστημα Διαχείρισης Αιθουσών
          </Typography>

          {error && <Alert severity="error" sx={{ mt: 2 }}>{error}</Alert>}

          <Box component="form" onSubmit={handleSubmit} sx={{ mt: 3 }}>
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Email"
              name="email"
              autoComplete="email"
              autoFocus
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
            <TextField
              margin="normal"
              required
              fullWidth
              name="password"
              label="Κωδικός"
              type="password"
              id="password"
              autoComplete="current-password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
            <Button
              type="submit"
              fullWidth
              variant="contained"
              sx={{ mt: 3, mb: 2 }}
              disabled={loading}
            >
              {loading ? 'Σύνδεση...' : 'Σύνδεση'}
            </Button>

            <Button
              fullWidth
              variant="outlined"
              sx={{ mt: 1 }}
              onClick={() => alert('CAS/SSO σύνδεση θα υλοποιηθεί σύντομα')}
            >
              Σύνδεση με CAS/SSO
            </Button>
          </Box>

          <Typography variant="body2" color="text.secondary" align="center" sx={{ mt: 3 }}>
            Προεπιλεγμένα στοιχεία: admin@admin.gr / admin
          </Typography>
        </Paper>
      </Box>
    </Container>
  );
}

export default LoginPage;
