import AppointmentForm from "./AppointmentForm";
import { useState } from 'react';
import { AppointmentDetails } from './types';

type NavProps = {
  onAppointmentCreated: (newAppointment: AppointmentDetails) => void;
};

function Nav({ onAppointmentCreated }: NavProps) {
  const [isModalOpen, setModalOpen] = useState(false);

  const handleModalClose = () => {
    setModalOpen(false);
  };

  const handleAppointmentCreated = (newAppointment: AppointmentDetails) => {
    onAppointmentCreated(newAppointment);
    handleModalClose();
  };

  return (
    <div className="text-center py-4">
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
