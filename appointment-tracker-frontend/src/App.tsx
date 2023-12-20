import React from "react";
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import AppointmentList from "./AppointmentList";
import AppointmentForm from "./AppointmentForm";
import EditAppointmentForm from "./EditAppointmentForm";

function App() {
  return (
    <Router>
      <div>
        <nav className="navbar bg-base-100">
          <div className="navbar-start">
          </div>
          <div className="navbar-center">
            <ul className="menu menu-horizontal px-1">
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/create-appointment">Create Appointment</Link>
              </li>
            </ul>
          </div>
          <div className="navbar-end">
          </div>
        </nav>
        <div className="h-screen flex justify-center">
          <Routes>
            <Route path="/" element={<AppointmentList />} />
            <Route path="/create-appointment" element={<AppointmentForm />} />
            <Route
              path="/edit-appointment/:id"
              element={<EditAppointmentForm />}
            />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
