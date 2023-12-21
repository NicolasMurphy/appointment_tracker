import React, { useState, useEffect } from "react";
import { AppointmentDetails } from "./types"; // Import the Appointment type

type EditAppointmentFormProps = {
  appointmentId: number;
  onAppointmentUpdated: (updatedAppointment: AppointmentDetails) => void;
};

const EditAppointmentForm: React.FC<EditAppointmentFormProps> = ({
  appointmentId,
  onAppointmentUpdated,
}) => {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [date, setDate] = useState("");
  const [time, setTime] = useState("");

  useEffect(() => {
    if (!appointmentId) {
      console.error("No ID provided for editing.");
      return;
    }
    // Fetch the existing appointment data for editing
    const fetchAppointmentData = async () => {
      try {
        const response = await fetch(
          `http://localhost:8000/api/get-appointment.php?id=${appointmentId}`
        );
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        const data = await response.json();
        setTitle(data.title);
        setDescription(data.description);
        setDate(data.date);
        setTime(data.time);
      } catch (error) {
        console.error("Fetch error:", error);
      }
    };

    if (appointmentId) {
      fetchAppointmentData();
    }
  }, [appointmentId]);

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    if (!appointmentId) {
      console.error("No ID provided for editing.");
      return;
    }

    const requestData = { id: appointmentId, title, description, date, time };
    // console.log('Sending data:', requestData); // Log the data for debugging

    try {
      const response = await fetch("http://localhost:8000/api/edit.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(requestData),
      });

      if (!response.ok) {
        throw new Error(
          `Network response was not ok, status: ${response.status}`
        );
      }

      // Construct the updated appointment object
      const updatedAppointment: AppointmentDetails = {
        id: appointmentId,
        title,
        description,
        date,
        time,
      };

      // Call the onAppointmentUpdated function with the updated appointment
      onAppointmentUpdated(updatedAppointment);
    } catch (error) {
      console.error("Error:", error);
    }
  };

  return (
    <div>
      <h1 className="text-2xl font-bold text-center mb-4">
        Add New Appointment
      </h1>
      <form
        onSubmit={handleSubmit}
        className="form-control w-full max-w-xs mx-auto"
      >
        <label className="label" htmlFor="title">
          <span className="label-text">Title</span>
        </label>
        <input
          id="title"
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          required
          className="input input-bordered input-info"
        />

        <label className="label" htmlFor="description">
          <span className="label-text">Description</span>
        </label>
        <textarea
          id="description"
          className="textarea textarea-info"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
        ></textarea>

        <label className="label" htmlFor="date">
          <span className="label-text">Date</span>
        </label>
        <input
          id="date"
          type="date"
          value={date}
          onChange={(e) => setDate(e.target.value)}
          className="input input-bordered input-info"
          required
        />

        <label className="label" htmlFor="time">
          <span className="label-text">Time</span>
        </label>
        <input
          id="time"
          type="time"
          value={time}
          onChange={(e) => setTime(e.target.value + ":00")} // adding seconds for consistency with PHP backend
          className="input input-bordered input-info"
          required
        />

        <button className="btn btn-info mt-6" type="submit">
          Submit
        </button>
      </form>
    </div>
  );
};

export default EditAppointmentForm;
