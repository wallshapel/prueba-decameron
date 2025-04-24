import { useState } from 'react'
import RoomForm from './RoomForm'
import RoomList from './RoomList'

function HotelCard({ hotel }) {
  const [showForm, setShowForm] = useState(false)
  const [refreshKey, setRefreshKey] = useState(0)

  const refreshRooms = () => setRefreshKey((prev) => prev + 1)

  return (
    <div className="bg-white shadow-md border border-gray-200 rounded-xl p-6 mb-6">
      <h3 className="text-xl font-bold text-blue-900 mb-1">{hotel.name}</h3>
      <p className="text-gray-700">
        {hotel.address}, {hotel.city}
      </p>
      <p className="text-gray-700">
        NIT: <span className="font-semibold">{hotel.nit}</span>
      </p>
      <p className="text-gray-700 mb-3">
        Límite de habitaciones: <span className="font-semibold">{hotel.room_limit}</span>
      </p>

      <button
        onClick={() => setShowForm((prev) => !prev)}
        className="bg-orange-400 text-white font-medium px-4 py-2 rounded hover:bg-orange-500 transition"
      >
        {showForm ? 'Ocultar formulario' : 'Asignar habitación'}
      </button>

      {showForm && (
        <div className="mt-4">
          <RoomForm nit={hotel.nit} onClose={() => setShowForm(false)} onAssigned={refreshRooms} />
        </div>
      )}

      <div className="mt-4">
        <RoomList nit={hotel.nit} key={refreshKey} />
      </div>
    </div>
  )
}

export default HotelCard
