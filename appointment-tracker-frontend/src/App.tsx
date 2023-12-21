import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import AppointmentList from "./AppointmentList";
import AppointmentForm from "./AppointmentForm";
import EditAppointmentForm from "./EditAppointmentForm";
import Nav from "./Nav";

function App() {
  return (
    <Router>
      <div className="mx-auto min-w-screen min-h-screen">
        <Nav />
        <div className="flex justify-center">
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
