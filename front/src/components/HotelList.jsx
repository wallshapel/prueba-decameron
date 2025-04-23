import { useEffect, useState } from 'react'
import api from '../api/axios'
import HotelCard from './HotelCard'
import CreateHotelButton from './CreateHotelButton'
import Paginator from './Paginator'

function HotelList() {
    const [hotels, setHotels] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)
    const [page, setPage] = useState(1)
    const [lastPage, setLastPage] = useState(1)
    const [paginationLinks, setPaginationLinks] = useState([])

    useEffect(() => {
        const fetchHotels = async () => {
            setLoading(true)
            setError(null)

            try {
                const response = await api.get(`/hotels?page=${page}`)
                const data = response.data.data

                setHotels(data.data)
                setLastPage(data.last_page)
                setPaginationLinks(data.links)
            } catch (error) {
                setError('Error al cargar los hoteles')
            } finally {
                setLoading(false)
            }
        }

        fetchHotels()
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
                <Paginator meta={{ current_page: page, last_page: lastPage, links: paginationLinks }} onPageChange={setPage} />
            </div>
        </div>
    )
}

export default HotelList
