import { useState } from 'react'
import RoomForm from './RoomForm'
import RoomList from './RoomList'

function HotelCard({ hotel }) {
    const [showForm, setShowForm] = useState(false)
    const [refreshKey, setRefreshKey] = useState(0)

    const refreshRooms = () => setRefreshKey(prev => prev + 1)

    return (
        <div style={{ border: '1px solid #ccc', padding: '1rem', marginBottom: '1rem' }}>
            <h3>{hotel.name}</h3>
            <p>{hotel.address}, {hotel.city}</p>
            <p>NIT: {hotel.nit}</p>
            <p>Límite de habitaciones: {hotel.room_limit}</p>

            <button onClick={() => setShowForm(prev => !prev)}>
                {showForm ? 'Ocultar formulario' : 'Asignar habitación'}
            </button>

            {showForm && (
                <RoomForm nit={hotel.nit} onClose={() => setShowForm(false)} onAssigned={refreshRooms} />
            )}

            <RoomList nit={hotel.nit} key={refreshKey} />
        </div>
    )
}

export default HotelCard
