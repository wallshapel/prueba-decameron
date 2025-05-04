import axios from 'axios'

const api = axios.create({
  // Local/Docker
  // baseURL: 'http://localhost:8000/api/v1',
  // Railway
  baseURL: 'https://laravel-production-9569.up.railway.app/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

export default api
