import { useEffect, useState } from 'react'
import api from '../api/axios'
import HotelCard from './HotelCard'

function HotelList() {
    const [hotels, setHotels] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)
    const [page, setPage] = useState(1)
    const [lastPage, setLastPage] = useState(1)

    useEffect(() => {
        api.get(`/hotels?page=${page}`)
            .then(response => {
                const data = response.data.data
                setHotels(data.data)
                setLastPage(data.last_page)
                setLoading(false)
            })
            .catch(() => {
                setError('Error al cargar los hoteles')
                setLoading(false)
            })
    }, [page])

    if (loading) return <p>Cargando hoteles...</p>
    if (error) return <p>{error}</p>

    if (hotels.length === 0) {
        return (
            <div>
                <p>No hay hoteles disponibles.</p>
                <button>Crear Hotel</button>
            </div>
        )
    }

    return (
        <div>
            {hotels.map(hotel => (
                <HotelCard key={hotel.nit} hotel={hotel} />
            ))}

            <div>
                {page > 1 && <button onClick={() => setPage(page - 1)}>Anterior</button>}
                {page < lastPage && <button onClick={() => setPage(page + 1)}>Siguiente</button>}
            </div>
        </div>
    )
}

export default HotelList
