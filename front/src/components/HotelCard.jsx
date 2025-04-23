function HotelCard({ hotel }) {
    return (
        <div>
            <h3>{hotel.name}</h3>
            <p>{hotel.address}, {hotel.city}</p>
            <p>NIT: {hotel.nit}</p>
            <p>Límite de habitaciones: {hotel.room_limit}</p>
            <button>Asignar habitación</button>
        </div>
    )
}

export default HotelCard
