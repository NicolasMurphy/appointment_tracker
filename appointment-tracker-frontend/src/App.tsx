import { useState, useEffect } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import AppointmentList from "./AppointmentList";
import Nav from "./Nav";
import { AppointmentDetails } from "./types";
import { API_BASE_URL } from "./apiConfig";
import FullCalendarComponent from "./FullCalendarComponent";

function App() {
  const [appointments, setAppointments] = useState<AppointmentDetails[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [isAppointmentCreated, setIsAppointmentCreated] =
    useState<boolean>(false);
  const [isAppointmentUpdated, setIsAppointmentUpdated] =
    useState<boolean>(false);

  const fetchAppointments = async (): Promise<void> => {
    setIsLoading(true);
    try {
      const response = await fetch(`${API_BASE_URL}/index.php`);
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

  const handleAppointmentCreated = (newAppointment: AppointmentDetails) => {
    setAppointments((currentAppointments) => [
      ...currentAppointments,
      newAppointment,
    ]);
    setIsAppointmentCreated(true);
    setTimeout(() => {
      setIsAppointmentCreated(false);
    }, 5000);
  };

  const handleAppointmentUpdated = (updatedAppointment: AppointmentDetails) => {
    setAppointments((currentAppointments) =>
      currentAppointments.map((appointment) =>
        appointment.id === updatedAppointment.id
          ? updatedAppointment
          : appointment
      )
    );
    setIsAppointmentUpdated(true);
    setTimeout(() => {
      setIsAppointmentUpdated(false);
    }, 5000);
  };

  return (
    <Router>
      <div className="mx-auto min-w-screen min-h-screen">
        <Nav onAppointmentCreated={handleAppointmentCreated} />
        <div className="flex justify-center">
          <Routes>
            <Route
              path="/"
              element={
                <AppointmentList
                  appointments={appointments}
                  isLoading={isLoading}
                  setAppointments={setAppointments}
                  onAppointmentUpdated={handleAppointmentUpdated}
                  isAppointmentCreated={isAppointmentCreated}
                  isAppointmentUpdated={isAppointmentUpdated}
                />
              }
            />
            <Route
              path="/calendar"
              element={<FullCalendarComponent appointments={appointments} />}
            />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
