import { useEffect, useState } from 'react'
import api from '../api/axios'

function RoomList({ nit }) {
    const [rooms, setRooms] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    useEffect(() => {
        const fetchRooms = async () => {
            try {
                const response = await api.get(`/hotel/${nit}/rooms`)
                setRooms(response.data.data)
            } catch (err) {
                setError('Error al cargar habitaciones')
            } finally {
                setLoading(false)
            }
        }

        fetchRooms()
    }, [nit])

    if (loading) return <p>Cargando habitaciones...</p>
    if (error) return <p>{error}</p>
    if (rooms.length === 0) return <p>No hay habitaciones asignadas.</p>

    return (
        <div>
            <h4>Habitaciones asignadas:</h4>
            <ul>
                {rooms.map((room, index) => (
                    <li key={index}>
                        Tipo: <strong>{room.type}</strong> – Acomodación: <strong>{room.accommodation}</strong> – Cantidad: {room.quantity}
                    </li>
                ))}
            </ul>
        </div>
    )
}

export default RoomList
