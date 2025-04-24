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

  useEffect(() => {
    fetchHotels()
  }, [page])

  if (loading) return <p className="text-center text-blue-800 font-semibold">Cargando hoteles...</p>
  if (error) return <p className="text-center text-red-600">{error}</p>

  if (hotels.length === 0) {
    return (
      <div className="max-w-4xl mx-auto mt-10 text-center space-y-4">
        <h1 className="text-2xl font-bold text-blue-800">No hay hoteles disponibles.</h1>
        <CreateHotelButton onCreated={fetchHotels} />
      </div>
    )
  }

  return (
    <div className="max-w-5xl mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold text-center text-blue-800 mb-8">Listado de hoteles</h1>

      <div className="flex justify-center mb-6">
        <CreateHotelButton onCreated={fetchHotels} />
      </div>

      <div className="space-y-6">
        {hotels.map((hotel) => (
          <HotelCard key={hotel.nit} hotel={hotel} />
        ))}
      </div>

      <div className="mt-8 flex justify-center">
        <Paginator
          meta={{ current_page: page, last_page: lastPage, links: paginationLinks }}
          onPageChange={setPage}
        />
      </div>
    </div>
  )
}

export default HotelList
