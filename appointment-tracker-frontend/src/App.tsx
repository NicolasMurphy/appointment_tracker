import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import AppointmentList from "./AppointmentList";
import EditAppointmentForm from "./EditAppointmentForm";
import Nav from "./Nav";
import { useState, useEffect } from "react";
import { Appointment } from './types';

function App() {
  const [appointments, setAppointments] = useState<Appointment[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const fetchAppointments = async (): Promise<void> => {
    setIsLoading(true);
    try {
      const response = await fetch("http://localhost:8000/api/index.php");
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      const data = await response.json();
      setAppointments(data);
    } catch (error) {
      console.error("Fetch error:", error);
    }
    setIsLoading(false);
  };
  useEffect(() => {
    fetchAppointments();
  }, []);
  return (
    <Router>
      <div className="mx-auto min-w-screen min-h-screen">
      <Nav onAppointmentCreated={fetchAppointments} />
        <div className="flex justify-center">
          <Routes>
            <Route path="/" element={<AppointmentList fetchAppointments={fetchAppointments} appointments={appointments} isLoading={isLoading} />} />
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
