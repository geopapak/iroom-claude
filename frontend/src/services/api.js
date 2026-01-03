import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8080/api',
  headers: {
    'Content-Type': 'application/json'
  }
});

// Request interceptor to add token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor for error handling
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export const authAPI = {
  login: (credentials) => api.post('/auth/login', credentials),
  register: (userData) => api.post('/auth/register', userData),
  getCurrentUser: () => api.get('/auth/me'),
  logout: () => api.post('/auth/logout')
};

export const scheduleAPI = {
  getByDepartment: (scheduleId, departmentId) =>
    api.get(`/schedules/${scheduleId}/department/${departmentId}`),
  getByProfessor: (scheduleId, professorId) =>
    api.get(`/schedules/${scheduleId}/professor/${professorId}`),
  addProgramme: (scheduleId, data) =>
    api.post(`/schedules/${scheduleId}/programme`, data),
  deleteProgramme: (programmeId) =>
    api.delete(`/schedules/programme/${programmeId}`)
};

export const notificationAPI = {
  getPending: () => api.get('/notifications/pending'),
  getCount: () => api.get('/notifications/count'),
  getUserNotifications: (userId) => api.get(`/notifications/user/${userId}`),
  create: (data) => api.post('/notifications', data),
  approve: (id) => api.put(`/notifications/${id}/approve`),
  reject: (id) => api.delete(`/notifications/${id}`)
};

export const roomAPI = {
  getAll: () => api.get('/rooms'),
  getById: (id) => api.get(`/rooms/${id}`),
  getByDepartment: (departmentId) => api.get(`/rooms/department/${departmentId}`),
  create: (data) => api.post('/rooms', data),
  update: (id, data) => api.put(`/rooms/${id}`, data),
  delete: (id) => api.delete(`/rooms/${id}`)
};

export const courseAPI = {
  getAll: () => api.get('/courses'),
  getById: (id) => api.get(`/courses/${id}`),
  getByDepartment: (departmentId) => api.get(`/courses/department/${departmentId}`),
  getBySemester: (semesterId) => api.get(`/courses/semester/${semesterId}`),
  getByYear: (year) => api.get(`/courses/year/${year}`),
  create: (data) => api.post('/courses', data),
  update: (id, data) => api.put(`/courses/${id}`, data),
  delete: (id) => api.delete(`/courses/${id}`)
};

export const equipmentAPI = {
  getAll: () => api.get('/equipment'),
  getById: (id) => api.get(`/equipment/${id}`),
  create: (data) => api.post('/equipment', data),
  update: (id, data) => api.put(`/equipment/${id}`, data),
  delete: (id) => api.delete(`/equipment/${id}`)
};

export const departmentAPI = {
  getAll: () => api.get('/departments'),
  getById: (id) => api.get(`/departments/${id}`),
  create: (data) => api.post('/departments', data),
  update: (id, data) => api.put(`/departments/${id}`, data),
  delete: (id) => api.delete(`/departments/${id}`)
};

export const userAPI = {
  getAll: () => api.get('/users'),
  getById: (id) => api.get(`/users/${id}`),
  create: (data) => api.post('/users', data),
  update: (id, data) => api.put(`/users/${id}`, data),
  delete: (id) => api.delete(`/users/${id}`)
};

export default api;
