import React, { useEffect, useState } from 'react';

type Appointment = {
  id: number;
  title: string;
  date: string;
  // Add other fields as necessary
};

const AppointmentList: React.FC = () => {
  const [appointments, setAppointments] = useState<Appointment[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchAppointments = async () => {
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

    fetchAppointments();
  }, []);

  if (isLoading) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <h1>Appointments</h1>
      {appointments.length > 0 ? (
        appointments.map(appointment => (
          <div key={appointment.id}>
            <h2>{appointment.title}</h2>
            <p>{appointment.date}</p>
            {/* Add more details here */}
          </div>
        ))
      ) : (
        <p>No appointments found.</p>
      )}
    </div>
  );
};

export default AppointmentList;
