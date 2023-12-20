import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

type Appointment = {
  id: number;
  title: string;
  date: string;
  // Add other fields as necessary
};

const AppointmentList: React.FC = () => {
  const [appointments, setAppointments] = useState<Appointment[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  const fetchAppointments = async () => {
    setIsLoading(true);
    try {
      const response = await fetch('http://localhost:8000/api/index.php');
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      setAppointments(data);
    } catch (error) {
      console.error('Fetch error:', error);
    }
    setIsLoading(false);
  };

  useEffect(() => {
    fetchAppointments();
  }, []);

  const deleteAppointment = async (id: number) => {
    try {
      const response = await fetch(`http://localhost:8000/api/delete.php`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`,
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      await response.json();
      await fetchAppointments(); // Refetch the appointments after deletion
    } catch (error) {
      console.error('Error:', error);
    }
  };

  if (isLoading) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <h1 className='text-5xl font-bold text-center'>Appointments</h1>
      {appointments.length > 0 ? (
        appointments.map(appointment => (
          <div className="card my-4 w-96 bg-neutral text-neutral-content" key={appointment.id}>
            <div className='card-body items-center text-center'>
            <h2 className='card-title'>{appointment.title}</h2>
            <p>{appointment.date}</p>
            {/* Add more details here */}
            <div className="card-actions justify-end">
              <button className='btn btn-primary' onClick={() => deleteAppointment(appointment.id)}>Delete</button>
              <Link className='btn btn-primary' to={`/edit-appointment/${appointment.id}`} >Edit Appointment</Link>
            </div>
            </div>
          </div>
        ))
      ) : (
        <p>No appointments found.</p>
      )}
    </div>
  );
};

export default AppointmentList;
