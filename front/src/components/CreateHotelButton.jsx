function CreateHotelButton() {
    const handleClick = () => {
        // For now we only simulate the intention
        alert('Aquí se abriría el formulario para crear un hotel.')
    }

    return (
        <button onClick={handleClick}>
            Crear Hotel
        </button>
    )
}

export default CreateHotelButton
