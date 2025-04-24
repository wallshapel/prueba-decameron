import { useState } from 'react'
import api from '../api/axios'

function CreateHotelButton({ onCreated }) {
  const [showForm, setShowForm] = useState(false)
  const [form, setForm] = useState({
    name: '',
    address: '',
    city: '',
    nit: '',
    room_limit: '',
  })

  const [error, setError] = useState(null)
  const [success, setSuccess] = useState(null)

  const handleChange = (e) => {
    const { name, value } = e.target
    setForm((prev) => ({ ...prev, [name]: value }))
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setError(null)
    setSuccess(null)

    try {
      const payload = {
        ...form,
        room_limit: parseInt(form.room_limit),
      }

      const response = await api.post('/hotel', payload)

      setSuccess('Hotel creado exitosamente.')
      setForm({
        name: '',
        address: '',
        city: '',
        nit: '',
        room_limit: '',
      })

      if (onCreated) onCreated()
      setTimeout(() => {
        setShowForm(false)
        setSuccess(null)
      }, 1000)
    } catch (err) {
      const mensaje =
        err.response?.data?.errors ?? err.response?.data?.message ?? 'Error al crear hotel'
      setError(typeof mensaje === 'string' ? mensaje : Object.values(mensaje).flat()[0])
    }
  }

  if (!showForm) {
    return (
      <button
        className="px-4 py-2 bg-blue-800 text-white font-semibold rounded hover:bg-blue-700 transition"
        onClick={() => setShowForm(true)}
      >
        Crear Hotel
      </button>
    )
  }

  return (
    <div className="border p-4 rounded-md shadow-md bg-white max-w-xl mx-auto space-y-4">
      <h4 className="text-xl font-bold text-blue-800 mb-2">Nuevo Hotel</h4>

      {error && <p className="text-red-600 text-sm">{error}</p>}
      {success && <p className="text-green-600 text-sm">{success}</p>}

      <form onSubmit={handleSubmit} className="space-y-3">
        <div>
          <label className="block text-sm font-semibold text-gray-700">Nombre:</label>
          <input
            type="text"
            name="name"
            value={form.name}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2"
          />
        </div>
        <div>
          <label className="block text-sm font-semibold text-gray-700">Dirección:</label>
          <input
            type="text"
            name="address"
            value={form.address}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2"
          />
        </div>
        <div>
          <label className="block text-sm font-semibold text-gray-700">Ciudad:</label>
          <input
            type="text"
            name="city"
            value={form.city}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2"
          />
        </div>
        <div>
          <label className="block text-sm font-semibold text-gray-700">NIT:</label>
          <input
            type="text"
            name="nit"
            value={form.nit}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2"
          />
        </div>
        <div>
          <label className="block text-sm font-semibold text-gray-700">
            Límite de habitaciones:
          </label>
          <input
            type="number"
            name="room_limit"
            value={form.room_limit}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2"
          />
        </div>
        <div className="flex gap-3 pt-2">
          <button
            type="submit"
            className="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded"
          >
            Guardar
          </button>
          <button
            type="button"
            onClick={() => setShowForm(false)}
            className="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-2 rounded"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>
  )
}

export default CreateHotelButton
