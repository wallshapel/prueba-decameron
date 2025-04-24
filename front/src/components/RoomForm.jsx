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
        <div>
            <h4>Asignar nueva habitación</h4>

            {error && <p style={{ color: 'red' }}>{error}</p>}

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Tipo de habitación:</label>
                    <select name="type" value={form.type} onChange={handleChange}>
                        <option value="">Seleccionar tipo</option>
                        <option value="Estándar">Estándar</option>
                        <option value="Junior">Junior</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div>
                    <label>Acomodación:</label>
                    <select name="accommodation" value={form.accommodation} onChange={handleChange}>
                        <option value="">Seleccionar acomodación</option>
                        <option value="Sencilla">Sencilla</option>
                        <option value="Doble">Doble</option>
                        <option value="Triple">Triple</option>
                        <option value="Cuádruple">Cuádruple</option>
                    </select>
                </div>
                <div>
                    <label>Cantidad:</label>
                    <input type="number" name="quantity" value={form.quantity} onChange={handleChange} />
                </div>
                <button type="submit">Guardar</button>
                <button type="button" onClick={onClose}>Cancelar</button>
            </form>
        </div>
    )
}

export default RoomForm
