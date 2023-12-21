import { Link } from "react-router-dom";
import AppointmentForm from "./AppointmentForm";
import { useState } from 'react';

type NavProps = {
  onAppointmentCreated: () => void;
};

function Nav({ onAppointmentCreated }: NavProps) {
  const [isModalOpen, setModalOpen] = useState(false);

  const handleModalClose = () => {
    setModalOpen(false);
  };

  const handleAppointmentCreated = () => {
    onAppointmentCreated();
    handleModalClose();
  };

  return (
    <div className="text-center py-4">
      <Link to="/">Home</Link>
      <button onClick={() => setModalOpen(true)} className="btn btn-outline mx-2">
        Create Appointment
      </button>
      {isModalOpen && (
        <div className="modal modal-open">
          <div className="modal-box relative">
            <button
              onClick={handleModalClose}
              className="btn btn-sm btn-circle absolute right-2 top-2"
            >
              ✕
            </button>
            <AppointmentForm onAppointmentCreated={handleAppointmentCreated} />
          </div>
        </div>
      )}
    </div>
  );
}


export default Nav;
