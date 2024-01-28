import React from "react";
import EditAppointmentForm from "./EditAppointmentForm";
import { AppointmentDetails } from "./types";
import { useState } from "react";
import { API_BASE_URL } from './apiConfig';

type AppointmentListProps = {
  appointments: AppointmentDetails[];
  isLoading: boolean;
  isAppointmentCreated: boolean;
  isAppointmentUpdated: boolean;
  setAppointments: React.Dispatch<React.SetStateAction<AppointmentDetails[]>>;
  onAppointmentUpdated: (updatedAppointment: AppointmentDetails) => void;
};

const AppointmentList: React.FC<AppointmentListProps> = ({
  appointments,
  isLoading,
  isAppointmentCreated,
  isAppointmentUpdated,
  setAppointments,
  onAppointmentUpdated,
}) => {
  const [isEditModalOpen, setEditModalOpen] = useState<boolean>(false);
  const [editingAppointmentId, setEditingAppointmentId] = useState<
    number | null
  >(null);
  const [isAppointmentDeleted, setIsAppointmentDeleted] = useState<boolean>(false);

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
      const response = await fetch(`${API_BASE_URL}/delete.php`, {
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
      // show toast and remove after 3 seconds
      setIsAppointmentDeleted(true);
      setTimeout(() => {
        setIsAppointmentDeleted(false);
      }, 5000);
    } catch (error) {
      console.error("Error:", error);
    }
  };

  const sortedAppointments = [...appointments].sort((a, b) => {
    const dateTimeA = `${a.date}T${a.time}`;
    const dateTimeB = `${b.date}T${b.time}`;

    return dateTimeA.localeCompare(dateTimeB);
  });

  if (isLoading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="mx-10">
      <h1 className="text-5xl font-bold text-center mb-4">Appointments</h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5">
        {sortedAppointments.length > 0 ? (
          sortedAppointments.map((appointment) => (
            <div
              className="card m-2 bg-neutral text-neutral-content"
              key={appointment.id}
            >
              <div className="card-body items-center text-center">
                <h2 className="card-title">{appointment.title}</h2>
                <p>{appointment.date}</p>
                {/* convert 24 time to 12 hour with am/pm */}
                <p>
                  {new Date(
                    "1970-01-01T" + appointment.time + "Z"
                  ).toLocaleTimeString("en-US", {
                    timeZone: "UTC",
                    hour12: true,
                    hour: "numeric",
                    minute: "numeric",
                  })}
                </p>
                <div className="card-actions justify-end">
                  <button
                    className="btn btn-secondary"
                    onClick={() => deleteAppointment(appointment.id)}
                  >
                    Delete
                  </button>

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
      {isAppointmentDeleted && <div className="toast toast-center">
        <div className="alert alert-success">
          <span>Appointment successfully deleted.</span>
        </div>
      </div>}
      {isAppointmentCreated && <div className="toast toast-center">
        <div className="alert alert-success">
          <span>Appointment successfully created.</span>
        </div>
      </div>}
      {isAppointmentUpdated && <div className="toast toast-center">
        <div className="alert alert-success">
          <span>Appointment successfully updated.</span>
        </div>
      </div>}
    </div>
  );
};

export default AppointmentList;
