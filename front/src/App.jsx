import { Routes, Route } from 'react-router-dom'
import HotelList from './components/HotelList'

function App() {
  return (
    <Routes>
      <Route path="/" element={<HotelList />} />
    </Routes>
  )
}

export default App
