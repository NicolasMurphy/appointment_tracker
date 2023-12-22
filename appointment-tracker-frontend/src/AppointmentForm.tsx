import React, { useState } from "react";
import { AppointmentDetails } from "./types";

const AppointmentForm: React.FC<{
  onAppointmentCreated: (newAppointment: AppointmentDetails) => void;
}> = ({ onAppointmentCreated }) => {
  const [title, setTitle] = useState<string>("");
  const [description, setDescription] = useState<string>("");
  const [date, setDate] = useState<string>("");
  const [time, setTime] = useState<string>("");

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    const requestData = { title, description, date, time };
    // console.log('Sending data:', requestData); // Log the data for debugging
    try {
      const response = await fetch("http://localhost:8000/api/create.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(requestData),
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const newAppointment = await response.json(); // Assuming the response contains the new appointment data
      onAppointmentCreated(newAppointment);

      // Clear the form
      setTitle("");
      setDescription("");
      setDate("");
      setTime("");
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

export default AppointmentForm;
