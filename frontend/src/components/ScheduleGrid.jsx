import { useState, useEffect } from 'react';
import {
  Table, TableBody, TableCell, TableContainer, TableHead, TableRow,
  Paper, Button, Typography, Box
} from '@mui/material';
import { scheduleAPI } from '../services/api';

const DAYS = ['Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή'];
const HOURS = [
  '08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00',
  '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00',
  '16:00-17:00', '17:00-18:00', '18:00-19:00'
];

function ScheduleGrid({ departmentId, professorId, scheduleId = 1 }) {
  const [schedule, setSchedule] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchSchedule();
  }, [departmentId, professorId, scheduleId]);

  const fetchSchedule = async () => {
    setLoading(true);
    try {
      let response;
      if (professorId) {
        response = await scheduleAPI.getByProfessor(scheduleId, professorId);
      } else if (departmentId) {
        response = await scheduleAPI.getByDepartment(scheduleId, departmentId);
      }
      setSchedule(response?.data || []);
    } catch (error) {
      console.error('Error fetching schedule:', error);
    } finally {
      setLoading(false);
    }
  };

  const getCellContent = (dayIndex, hourIndex) => {
    // Find programme for this day and hour
    const programme = schedule.find(p =>
      p.day.id === dayIndex + 1 && p.hour.id === hourIndex + 1
    );

    if (!programme) return null;

    return (
      <Box sx={{ p: 1, bgcolor: 'primary.light', borderRadius: 1 }}>
        <Typography variant="caption" display="block" fontWeight="bold">
          {programme.semesterCourse?.course?.name}
        </Typography>
        <Typography variant="caption" display="block">
          {programme.user?.name} {programme.user?.lastName}
        </Typography>
      </Box>
    );
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 2 }}>
        <Typography variant="h6">Εβδομαδιαίο Πρόγραμμα</Typography>
        <Button variant="contained" onClick={fetchSchedule} disabled={loading}>
          {loading ? 'Φόρτωση...' : 'Ανανέωση'}
        </Button>
      </Box>

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Ώρα</TableCell>
              {DAYS.map((day) => (
                <TableCell key={day} align="center" sx={{ fontWeight: 'bold' }}>
                  {day}
                </TableCell>
              ))}
            </TableRow>
          </TableHead>
          <TableBody>
            {HOURS.map((hour, hourIndex) => (
              <TableRow key={hour}>
                <TableCell component="th" scope="row" sx={{ fontWeight: 'bold' }}>
                  {hour}
                </TableCell>
                {DAYS.map((day, dayIndex) => (
                  <TableCell key={`${day}-${hour}`} align="center">
                    {getCellContent(dayIndex, hourIndex)}
                  </TableCell>
                ))}
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Box>
  );
}

export default ScheduleGrid;
