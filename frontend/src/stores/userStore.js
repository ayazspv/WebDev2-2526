import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from '@/axios';

export const useUserStore = defineStore('users', () => {
  const user = ref(null);
  const users = ref([]);
  const token = ref(localStorage.getItem('token') || '');
  const error = ref(null);
  const loading = ref(false);

  // Login
  const login = async (credentials) => {
    try {
      error.value = null;
      const response = await axios.post('/login', credentials);
      if (response.data && response.data.token) {
        token.value = response.data.token;
        user.value = {
          id: response.data.id,
          email: response.data.userEmail,
          role: response.data.userType,
        };
        localStorage.setItem('token', response.data.token);
        return response.data;
      } else {
        error.value = response.data?.message || 'Login failed';
        return null;
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed';
      return null;
    }
  };

  // Register new user
  const register = async (userData) => {
    try {
      const response = await axios.post('/register', userData);
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Registration failed';
      return null;
    }
  };

  // Get current logged-in user info
  const fetchMe = async () => {
    try {
      const response = await axios.get('/me');
      user.value = response.data;
      return user.value;
    } catch (err) {
      error.value = err.response?.data?.message || 'Fetch me failed';
      return null;
    }
  };

  // Fetch all users (for admin/manager dashboard)
  const fetchAllUsers = async () => {
    try {
      const response = await axios.get('/users');
      users.value = response.data;
    } catch (err) {
      users.value = [];
    }
  };

  const addUser = async (userData) => {
    try {
      // userData should have: firstname, lastname, role, email, password, phoneNumber, status
      const response = await axios.post('/users', userData)
      return response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to add user'
      return null
    }
  }

  const editUser = async (id, data) => {
    loading.value = true
    error.value = null
    try {
      const payload = { ...data }
      if (!payload.password) delete payload.password
      const response = await axios.put(`/users/${id}`, payload)
      return response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to edit user'
      return null
    } finally {
      loading.value = false
    }
  }

  const deleteUser = async (id) => {
    loading.value = true
    error.value = null
    try {
      const response = await axios.delete(`/users/${id}`)
      // Optionally update local users list
      await fetchAllUsers()
      return response.data
    } catch (err) {
      error.value = 'Error deleting user: ' + (err.response?.data?.message || err.message)
      return null
      } finally {
        loading.value = false
      }
    }

  const logout = () => {
    token.value = ''
    user.value = null
    localStorage.removeItem('token')
  }

  return {
    user,
    users,
    token,
    error,
    login,
    register,
    fetchMe,
    fetchAllUsers,
    addUser,
    editUser,
    deleteUser,
    logout
  };
});
