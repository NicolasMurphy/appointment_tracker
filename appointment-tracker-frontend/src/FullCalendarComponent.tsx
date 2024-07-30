import React from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { AppointmentDetails } from './types';

type FullCalendarComponentProps = {
  appointments: AppointmentDetails[];
};

const FullCalendarComponent: React.FC<FullCalendarComponentProps> = ({ appointments }) => {
  const events = appointments.map((appointment) => ({
    title: appointment.title,
    start: `${appointment.date}T${appointment.time}`,
    id: appointment.id.toString(),
  }));

  return (
    <div style={{ padding: '20px' }}>
      <FullCalendar
        plugins={[dayGridPlugin, interactionPlugin]}
        initialView="dayGridMonth"
        events={events}
        height="auto"
      />
    </div>
  );
};

export default FullCalendarComponent;
