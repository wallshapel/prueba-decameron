import { useState } from 'react'
import RoomForm from './RoomForm'

function HotelCard({ hotel }) {
    const [showForm, setShowForm] = useState(false)

    return (
        <div>
            <h3>{hotel.name}</h3>
            <p>{hotel.address}, {hotel.city}</p>
            <p>NIT: {hotel.nit}</p>
            <p>Límite de habitaciones: {hotel.room_limit}</p>

            <button onClick={() => setShowForm(prev => !prev)}>
                {showForm ? 'Ocultar formulario' : 'Asignar habitación'}
            </button>

            {showForm && (
                <RoomForm onClose={() => setShowForm(false)} />
            )}
        </div>
    )
}

export default HotelCard
