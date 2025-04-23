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
        setForm(prev => ({ ...prev, [name]: value }))
    }

    const handleSubmit = async (e) => {
        e.preventDefault()
        setError(null)
        setSuccess(null)

        try {
            const payload = {
                ...form,
                room_limit: parseInt(form.room_limit)
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

            if (onCreated) onCreated() // List refresh
            setTimeout(() => {
                setShowForm(false)
                setSuccess(null)
            }, 1000)
        } catch (err) {
            const mensaje = err.response?.data?.errors ?? err.response?.data?.message ?? 'Error al crear hotel'
            setError(typeof mensaje === 'string' ? mensaje : Object.values(mensaje).flat()[0])
        }
    }

    if (!showForm) {
        return <button onClick={() => setShowForm(true)}>Crear Hotel</button>
    }

    return (
        <div>
            <h4>Nuevo Hotel</h4>

            {error && <p style={{ color: 'red' }}>{error}</p>}
            {success && <p style={{ color: 'green' }}>{success}</p>}

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="name" value={form.name} onChange={handleChange} />
                </div>
                <div>
                    <label>Dirección:</label>
                    <input type="text" name="address" value={form.address} onChange={handleChange} />
                </div>
                <div>
                    <label>Ciudad:</label>
                    <input type="text" name="city" value={form.city} onChange={handleChange} />
                </div>
                <div>
                    <label>NIT:</label>
                    <input type="text" name="nit" value={form.nit} onChange={handleChange} />
                </div>
                <div>
                    <label>Límite de habitaciones:</label>
                    <input type="number" name="room_limit" value={form.room_limit} onChange={handleChange} />
                </div>
                <button type="submit">Guardar</button>
                <button type="button" onClick={() => setShowForm(false)}>Cancelar</button>
            </form>
        </div>
    )
}

export default CreateHotelButton
