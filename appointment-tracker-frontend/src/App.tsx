import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import AppointmentList from './AppointmentList';
import AppointmentForm from './AppointmentForm';

function App() {
  return (
    <Router>
      <div>
        <nav>
          <Link to="/">Home</Link> | <Link to="/create-appointment">Create Appointment</Link>
        </nav>
        <Routes>
          <Route path="/" element={<AppointmentList />} />
          <Route path="/create-appointment" element={<AppointmentForm />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
