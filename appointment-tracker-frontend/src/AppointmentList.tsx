import React from "react";
import EditAppointmentForm from "./EditAppointmentForm";
import { Appointment } from "./types";
import { useState } from "react";

type AppointmentListProps = {
  appointments: Appointment[];
  isLoading: boolean;
  setAppointments: React.Dispatch<React.SetStateAction<Appointment[]>>;
  onAppointmentUpdated: (updatedAppointment: Appointment) => void;
};

const AppointmentList: React.FC<AppointmentListProps> = ({
  appointments,
  isLoading,
  setAppointments,
  onAppointmentUpdated,
}) => {
  const [isEditModalOpen, setEditModalOpen] = useState(false);
  const [editingAppointmentId, setEditingAppointmentId] = useState<
    number | null
  >(null);

  const openEditModal = (id: number) => {
    setEditingAppointmentId(id);
    setEditModalOpen(true);
  };

  const handleModalClose = () => {
    setEditModalOpen(false);
    setEditingAppointmentId(null);
  };

  const deleteAppointment = async (id: number) => {
    try {
      const response = await fetch(`http://localhost:8000/api/delete.php`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      // Update state without re-fetching all appointments
      setAppointments((currentAppointments) =>
        currentAppointments.filter((appointment) => appointment.id !== id)
      );
    } catch (error) {
      console.error("Error:", error);
    }
  };

  if (isLoading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="mx-10">
      <h1 className="text-5xl font-bold text-center mb-4">Appointments</h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5">
        {appointments.length > 0 ? (
          appointments.map((appointment) => (
            <div
              className="card m-2 bg-neutral text-neutral-content"
              key={appointment.id}
            >
              <div className="card-body items-center text-center">
                <h2 className="card-title">{appointment.title}</h2>
                <p>{appointment.date}</p>
                {/* Add more details here */}
                <div className="card-actions justify-end">
                  <button
                    className="btn btn-secondary"
                    onClick={() => deleteAppointment(appointment.id)}
                  >
                    Delete
                  </button>
                  {/* <Link
                    className="btn btn-primary"
                    to={`/edit-appointment/${appointment.id}`}
                  >
                    Edit
                  </Link> */}

                  <button
                    onClick={() => openEditModal(appointment.id)}
                    className="btn btn-primary"
                  >
                    Edit
                  </button>
                  {isEditModalOpen && editingAppointmentId && (
                    <div className="modal modal-open">
                      <div className="modal-box relative">
                        <button
                          onClick={handleModalClose}
                          className="btn btn-sm btn-circle absolute right-2 top-2"
                        >
                          ✕
                        </button>
                        <EditAppointmentForm
                          appointmentId={editingAppointmentId}
                          onAppointmentUpdated={(updatedAppointment) => {
                            onAppointmentUpdated(updatedAppointment);
                            handleModalClose(); // Close the modal after updating
                          }}
                        />
                      </div>
                    </div>
                  )}
                </div>
              </div>
            </div>
          ))
        ) : (
          <p>No appointments found.</p>
        )}
      </div>
    </div>
  );
};

export default AppointmentList;
