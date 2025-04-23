function RoomForm({ onClose }) {
    return (
        <div>
            <h4>Asignar nueva habitación</h4>
            <form>
                <div>
                    <label>Tipo de habitación:</label>
                    <input type="text" name="type" />
                </div>
                <div>
                    <label>Acomodación:</label>
                    <input type="text" name="accommodation" />
                </div>
                <div>
                    <label>Cantidad:</label>
                    <input type="number" name="quantity" />
                </div>
                <button type="submit">Guardar</button>
                <button type="button" onClick={onClose}>Cancelar</button>
            </form>
        </div>
    )
}

export default RoomForm
