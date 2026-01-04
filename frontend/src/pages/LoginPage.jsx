import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Box, Container, TextField, Button, Typography, Alert, Paper, Tabs, Tab } from '@mui/material';
import { authAPI } from '../services/api';
import useAuthStore from '../store/authStore';

function LoginPage() {
  const [mode, setMode] = useState('login'); // 'login' or 'register'
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [name, setName] = useState('');
  const [lastName, setLastName] = useState('');
  const [phone, setPhone] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const login = useAuthStore((state) => state.login);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      let response;
      if (mode === 'login') {
        response = await authAPI.login({ email, password });
      } else {
        response = await authAPI.register({ name, lastName, phone, email, password });
      }

      const { token, ...userData } = response.data;

      login(userData, token);

      // Redirect based on user type
      switch (userData.userType) {
        case 'Διαχειριστής':
          navigate('/admin');
          break;
        case 'Γραμματεία':
          navigate('/secretariat');
          break;
        case 'Καθηγητής':
          navigate('/professor');
          break;
        case 'Φοιτητής':
          navigate('/student');
          break;
        default:
          navigate('/');
      }
    } catch (err) {
      setError(err.response?.data?.message || (mode === 'login' ? 'Σφάλμα σύνδεσης. Παρακαλώ ελέγξτε τα στοιχεία σας.' : 'Σφάλμα εγγραφής. Παρακαλώ δοκιμάστε ξανά.'));
    } finally {
      setLoading(false);
    }
  };

  const handleModeChange = (event, newMode) => {
    setMode(newMode);
    setError('');
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

          <Tabs value={mode} onChange={handleModeChange} centered sx={{ mt: 2 }}>
            <Tab label="Σύνδεση" value="login" />
            <Tab label="Εγγραφή" value="register" />
          </Tabs>

          {error && <Alert severity="error" sx={{ mt: 2 }}>{error}</Alert>}

          <Box component="form" onSubmit={handleSubmit} sx={{ mt: 3 }}>
            {mode === 'register' && (
              <>
                <TextField
                  margin="normal"
                  required
                  fullWidth
                  id="name"
                  label="Όνομα"
                  name="name"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                />
                <TextField
                  margin="normal"
                  required
                  fullWidth
                  id="lastName"
                  label="Επώνυμο"
                  name="lastName"
                  value={lastName}
                  onChange={(e) => setLastName(e.target.value)}
                />
                <TextField
                  margin="normal"
                  fullWidth
                  id="phone"
                  label="Τηλέφωνο"
                  name="phone"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                />
              </>
            )}
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Email"
              name="email"
              autoComplete="email"
              autoFocus={mode === 'login'}
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
              autoComplete={mode === 'login' ? 'current-password' : 'new-password'}
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
              {loading ? (mode === 'login' ? 'Σύνδεση...' : 'Εγγραφή...') : (mode === 'login' ? 'Σύνδεση' : 'Εγγραφή')}
            </Button>

            {mode === 'login' && (
              <Button
                fullWidth
                variant="outlined"
                sx={{ mt: 1 }}
                onClick={() => alert('CAS/SSO σύνδεση θα υλοποιηθεί σύντομα')}
              >
                Σύνδεση με CAS/SSO
              </Button>
            )}
          </Box>

          {mode === 'login' && (
            <Typography variant="body2" color="text.secondary" align="center" sx={{ mt: 3 }}>
              Δεν έχετε λογαριασμό; Κάντε κλικ στην καρτέλα "Εγγραφή"
            </Typography>
          )}
          {mode === 'register' && (
            <Typography variant="body2" color="text.secondary" align="center" sx={{ mt: 3 }}>
              Η εγγραφή δημιουργεί νέο λογαριασμό διαχειριστή
            </Typography>
          )}
        </Paper>
      </Box>
    </Container>
  );
}

export default LoginPage;
