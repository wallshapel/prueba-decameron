import axios from 'axios'

const api = axios.create({
  // Local/Docker
  // baseURL: 'http://localhost:8000/api/v1',
  // Railway
  baseURL: process.env.REACT_APP_API_URL || 'http://localhost:8000/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

export default api
