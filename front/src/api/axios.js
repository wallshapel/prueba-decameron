import axios from 'axios'

const api = axios.create({
    baseURL: 'http://localhost:8000/api/v1',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
})

export default api
