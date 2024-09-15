import React from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import { INITIAL_EVENTS, createEventId } from '../../../pages/trip/event-utils';

const CalendarPlanning = ({ weekendsVisible, handleWeekendsToggle, currentEvents, handleDateSelect, handleEventClick, handleEvents }) => {
  return (
    <div className='demo-app-main' style={{
      backgroundColor: '#fff',
      padding: '30px',
      borderRadius: '10px',
      boxShadow: '0px 2px 1px -1px rgba(58, 53, 65, 0.2), 0px 1px 1px 0px rgba(58, 53, 65, 0.14), 0px 1px 3px 0px rgba(58, 53, 65, 0.12)'
    }}>
      <FullCalendar
        plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin]}
        headerToolbar={{
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        }}
        themeSystem='Cerulean'
        initialView='dayGridMonth'
        editable={true}
        selectable={true}
        selectMirror={true}
        dayMaxEvents={true}
        weekends={weekendsVisible}
        initialEvents={INITIAL_EVENTS}
        select={handleDateSelect}
        eventContent={renderEventContent}
        eventClick={handleEventClick}
        eventsSet={handleEvents}
      />
    </div>
  );
}

function renderEventContent(eventInfo) {
  return (
    <>
      <b>{eventInfo.timeText}</b>
      <i>{eventInfo.event.title}</i>
      <i>{eventInfo.event.title2}</i>
    </>
  );
}

export default CalendarPlanning;
