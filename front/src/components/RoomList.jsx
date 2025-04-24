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

  if (loading) return <p className="text-sm text-gray-500 italic mt-2">Cargando habitaciones...</p>
  if (error) return <p className="text-red-600 text-sm mt-2">{error}</p>
  if (rooms.length === 0)
    return <p className="text-gray-600 text-sm mt-2">No hay habitaciones asignadas.</p>

  return (
    <div className="mt-4 bg-white border rounded-md p-4 shadow-sm">
      <h4 className="text-blue-700 font-semibold mb-2">Habitaciones asignadas:</h4>
      <ul className="space-y-2 list-disc list-inside">
        {rooms.map((room, index) => (
          <li key={index} className="text-sm text-gray-700">
            <span className="font-medium text-gray-900">Tipo:</span> {room.type} &nbsp;|&nbsp;
            <span className="font-medium text-gray-900">Acomodación:</span> {room.accommodation}{' '}
            &nbsp;|&nbsp;
            <span className="font-medium text-gray-900">Cantidad:</span> {room.quantity}
          </li>
        ))}
      </ul>
    </div>
  )
}

export default RoomList
