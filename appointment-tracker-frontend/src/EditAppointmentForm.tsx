import React, { useState, useEffect } from 'react';
import { AppointmentDetails } from './types'; // Import the Appointment type

type EditAppointmentFormProps = {
  appointmentId: number;
  onAppointmentUpdated: (updatedAppointment: AppointmentDetails) => void;
};

const EditAppointmentForm: React.FC<EditAppointmentFormProps> = ({ appointmentId, onAppointmentUpdated }) => {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [date, setDate] = useState('');
  const [time, setTime] = useState('');

  useEffect(() => {
    if (!appointmentId) {
      console.error('No ID provided for editing.');
      return;
    }
    // Fetch the existing appointment data for editing
    const fetchAppointmentData = async () => {
      try {
        const response = await fetch(`http://localhost:8000/api/get-appointment.php?id=${appointmentId}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        setTitle(data.title);
        setDescription(data.description);
        setDate(data.date);
        setTime(data.time);
      } catch (error) {
        console.error('Fetch error:', error);
      }
    };

    if (appointmentId) {
      fetchAppointmentData();
    }
  }, [appointmentId]);

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    if (!appointmentId) {
      console.error('No ID provided for editing.');
      return;
    }

    const requestData = { id: appointmentId, title, description, date, time };
    // console.log('Sending data:', requestData); // Log the data for debugging

    try {
      const response = await fetch('http://localhost:8000/api/edit.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestData),
      });

      if (!response.ok) {
        throw new Error(`Network response was not ok, status: ${response.status}`);
      }

      // Construct the updated appointment object
      const updatedAppointment: AppointmentDetails = {
        id: appointmentId,
        title,
        description,
        date,
        time
      };

      // Call the onAppointmentUpdated function with the updated appointment
      onAppointmentUpdated(updatedAppointment);

    } catch (error) {
      console.error('Error:', error);
    }
  };


  return (
    <div>
      <h1>Edit Appointment</h1>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Title:</label>
          <input
            type="text"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
          />
        </div>
        <div>
          <label>Description:</label>
          <textarea
            value={description}
            onChange={(e) => setDescription(e.target.value)}
          />
        </div>
        <div>
          <label>Date:</label>
          <input
            type="date"
            value={date}
            onChange={(e) => setDate(e.target.value)}
            required
          />
        </div>
        <div>
          <label>Time:</label>
          <input
            type="time"
            value={time}
            onChange={(e) => setTime(e.target.value + ":00")}
            required
          />
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  );
};

export default EditAppointmentForm;
