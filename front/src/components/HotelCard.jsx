import { useState } from 'react'
import RoomForm from './RoomForm'
import RoomList from './RoomList'

function HotelCard({ hotel }) {
    const [showForm, setShowForm] = useState(false)

    return (
        <div style={{ border: '1px solid #ccc', marginBottom: '1rem', padding: '1rem' }}>
            <h3>{hotel.name}</h3>
            <p>{hotel.address}, {hotel.city}</p>
            <p><strong>NIT:</strong> {hotel.nit}</p>
            <p><strong>Límite de habitaciones:</strong> {hotel.room_limit}</p>

            <button onClick={() => setShowForm(prev => !prev)}>
                {showForm ? 'Ocultar formulario' : 'Asignar habitación'}
            </button>

            {showForm && (
                <>
                    <RoomForm onClose={() => setShowForm(false)} nit={hotel.nit} />
                </>
            )}

            <RoomList nit={hotel.nit} />
        </div>
    )
}

export default HotelCard
