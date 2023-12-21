import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { Appointment } from './types'; // Import the Appointment type

type EditAppointmentFormProps = {
  onAppointmentUpdated: (updatedAppointment: Appointment) => void;
};

const EditAppointmentForm: React.FC<EditAppointmentFormProps> = ({ onAppointmentUpdated }) => {
  const navigate = useNavigate();
  const { id } = useParams<{ id: string }>();
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [date, setDate] = useState('');
  const [time, setTime] = useState('');

  useEffect(() => {
    // Fetch the existing appointment data for editing
    const fetchAppointmentData = async () => {
      try {
        const response = await fetch(`http://localhost:8000/api/get-appointment.php?id=${id}`);
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

    if (id) {
      fetchAppointmentData();
    }
  }, [id]);

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();

    try {
      const response = await fetch('http://localhost:8000/api/edit.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, title, description, date, time }),
      });
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      // Construct the updated appointment object
      const updatedAppointment: Appointment = {
        id: parseInt(id), // Convert id to a number if it's a string
        title,
        description,
        date,
        time
      };

      // Call the onAppointmentUpdated function with the updated appointment
      onAppointmentUpdated(updatedAppointment);

      // Navigate back to the appointment list or close the modal
      navigate('/');
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
            onChange={(e) => setTime(e.target.value)}
            required
          />
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  );
};

export default EditAppointmentForm;
