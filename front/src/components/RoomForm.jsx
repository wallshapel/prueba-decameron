import { useState } from 'react'
import api from '../api/axios'

function RoomForm({ nit, onClose, onAssigned }) {
  const [form, setForm] = useState({
    type: '',
    accommodation: '',
    quantity: '',
  })

  const [error, setError] = useState(null)

  const handleChange = (e) => {
    const { name, value } = e.target
    setForm((prev) => ({ ...prev, [name]: value }))
  }

  const handleSubmit = async (e) => {
    e.preventDefault()

    if (!form.type || !form.accommodation || !form.quantity) {
      setError('Todos los campos son obligatorios.')
      return
    }

    if (isNaN(form.quantity) || parseInt(form.quantity) <= 0) {
      setError('La cantidad debe ser un número positivo.')
      return
    }

    setError(null)

    try {
      await api.post(`/hotel/${nit}/room`, {
        rooms: [
          {
            type: form.type,
            accommodation: form.accommodation,
            quantity: parseInt(form.quantity),
          },
        ],
      })

      if (onAssigned) onAssigned()
      onClose()
    } catch (err) {
      if (err.response?.data?.errors) {
        const firstError = Object.values(err.response.data.errors)[0][0]
        setError(firstError)
      } else if (err.response?.data?.message) {
        setError(err.response.data.message)
      } else {
        setError('Ocurrió un error al guardar la habitación.')
      }
    }
  }

  return (
    <div className="mt-4 p-4 border rounded-lg bg-blue-50 shadow-sm">
      <h4 className="text-lg font-semibold text-blue-900 mb-2">Asignar nueva habitación</h4>

      {error && <p className="text-red-600 text-sm mb-2">{error}</p>}

      <form onSubmit={handleSubmit} className="space-y-3">
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Tipo de habitación:
          </label>
          <select
            name="type"
            value={form.type}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
          >
            <option value="">Seleccionar tipo</option>
            <option value="Estándar">Estándar</option>
            <option value="Junior">Junior</option>
            <option value="Suite">Suite</option>
          </select>
        </div>
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">Acomodación:</label>
          <select
            name="accommodation"
            value={form.accommodation}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
          >
            <option value="">Seleccionar acomodación</option>
            <option value="Sencilla">Sencilla</option>
            <option value="Doble">Doble</option>
            <option value="Triple">Triple</option>
            <option value="Cuádruple">Cuádruple</option>
          </select>
        </div>
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">Cantidad:</label>
          <input
            type="number"
            name="quantity"
            value={form.quantity}
            onChange={handleChange}
            className="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
          />
        </div>
        <div className="flex gap-3">
          <button
            type="submit"
            className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
          >
            Guardar
          </button>
          <button
            type="button"
            onClick={onClose}
            className="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition"
          >
            Cancelar
          </button>
        </div>
      </form>
    </div>
  )
}

export default RoomForm
