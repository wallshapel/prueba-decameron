import { useEffect, useState } from 'react'
import api from '../api/axios'
import HotelCard from './HotelCard'
import CreateHotelButton from './CreateHotelButton'

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
                <h1>No hay hoteles disponibles.</h1>
                <div>
                    <CreateHotelButton />
                </div>
            </div>

        )
    }

    return (
        <div>
            <h1>Listado de hoteles</h1>

            <div>
                <CreateHotelButton />
            </div>

            {hotels.map(hotel => (<HotelCard key={hotel.nit} hotel={hotel} />))}

            <div>
                {page > 1 && <button onClick={() => setPage(page - 1)}>Anterior</button>}
                {page < lastPage && <button onClick={() => setPage(page + 1)}>Siguiente</button>}
            </div>

            <div>
                <CreateHotelButton />
            </div>
        </div>
    )
}

export default HotelList
