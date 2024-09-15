import React, { useState, useEffect } from 'react';
import axios from 'axios';
import UpdatePlanning from 'src/views/trip/planified-trip/UpdatePlanning';
import { useRouter } from 'next/router';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import { toast, Toaster } from 'sonner';
import BuyNowButton from "../../layouts/components/UpgradeToProButton";
import { Button } from '@mui/material';
import ModalTravel from "../../views/trip/create-trip/Modal";
import {createEventId} from "../../pages/trip/event-utils";
import Chip from "@mui/material/Chip";
import PublishIcon from "@mui/icons-material/Publish";
import ErrorIcon from "@mui/icons-material/Error";
import ScheduleIcon from "@mui/icons-material/Schedule";
import CancelIcon from "@mui/icons-material/Cancel";
import CheckCircleIcon from "@mui/icons-material/CheckCircle";
import api from "../../configs/apiConfig";
const PlanningDetail = () => {
  const router = useRouter();
  const { id } = router.query;
  const [planning, setPlanning] = useState(null);
  const [eventsData, setEventsData] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedDateInfo, setSelectedDateInfo] = useState(null);
  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [vehicles, setVehicles] = useState([]);
  const [cities, setCities] = useState([]);
  const [quarters1, setQuarters1] = useState([]);
  const [quarters2, setQuarters2] = useState([]);
  const [formData, setFormData] = useState({
    startDate: '',
    endDate: '',
    vehicleID: '',
    departureCityId: '',
    departureQuarter: '',
    destinationCityId: '',
    destinationQuarter: '',
    tollPrice: 0,
    ticketPrice: 0,
  });
  function closeModal() {
    setModalIsOpen(false);
    setFormData({
      startDate: '',
      endDate: '',
      vehicleID: '',
      departureCityId: '',
      departureQuarter: '',
      destinationCityId: '',
      destinationQuarter: '',
      ticketPrice: ''
    });
    setQuarters1([]);
    setQuarters2([]);
  }

  useEffect(() => {
    if (id) {
      const handleSelectPlanning = (planningId) => {
        const getPlanning = async (planningId) => {
          try {
            const response = await api.get(`/planning/${planningId}`);
            setPlanning(response.data);
            toast.success("Planning sélectionné avec succès");
          } catch (error) {
            toast.error("Erreur lors du chargement du planning");
            console.error('Erreur lors du chargement des événements:', error);
          }
        };
        const fetchEvents = async () => {
          try {
            const response = await api.get(`/planning/${planningId}/travels`);
            const formattedEvents = response.data.map(event => ({
              id: event.id,
              title: event.departureQuarter + " - " + event.destinationQuarter, // Use a suitable field for title
              start: event.startDate,
              end: event.endDate || event.startDate, // Optional, depends on your data
              extendedProps: {
                state: event.state,
                duration: event.duration,
                price: event.ticketPrice,
              },
            }));
            setEventsData(formattedEvents);
            toast.success("Voyages chargés");
          } catch (error) {
            toast.error("Erreur lors du chargement des voyages");
            console.error('Erreur lors du chargement des événements:', error);
          }
        };
        getPlanning(planningId);
        fetchEvents();
      };
      handleSelectPlanning(id);
    }
  }, [id]);
  useEffect(() => {
    api.get('/cities')
      .then(response => {
        setCities(response.data);
        console.log(response.data);
      })
      .catch(error => console.error(error));
  }, []);

  useEffect(() => {
    if (formData.startDate) {
      const departureDateTime = `${formData.startDate}`;
      api.get(`/vehicles/available/${departureDateTime}`)
        .then(response => {
          console.log(response.data);
          setVehicles(response.data);
        })
        .catch(error => console.error(error));
    }
  }, [formData.startDate]);

  const handlePublishPlanning = async () => {
    if (planning) {
      try {
        const response = await api.post(`/planning/publish/${planning.id}`);
        toast.success("Planning publié avec succes");
        console.log('Planning published successfully:', response.data);
      } catch (error) {
        toast.error("Erreur lors de la publication du planning");
        console.error('Erreur lors de la publication du planning:', error);
      }
    } else {
      console.log("Pas de planning selectionné");
    }
  };
  function handleInputChange(e) {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });

    if (name === 'departureCityId') {
      const selectedCity = cities.find(city => city.id === value);
      setQuarters1(selectedCity ? selectedCity.quarters : []);
    }
    if (name === 'destinationCityId') {
      const selectedCity = cities.find(city => city.id === value);
      setQuarters2(selectedCity ? selectedCity.quarters : []);
    }
  }
  const calculateDuration = (startDate, endDate) => {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const duration = (end - start) / (1000 * 60); // Duration in minutes
    return duration;
  };
  const handleSubmit = async (e) => {
    e.preventDefault();
    const duration = calculateDuration(formData.startDate, formData.endDate);
    try {
      // console.log(duration);
      const newFormData = {
        vehicleID: formData.vehicleID,
        state: 1,
        departureCityId: formData.departureCityId,
        departureQuarter: formData.departureQuarter,
        destinationCityId: formData.destinationCityId,
        destinationQuarter: formData.destinationQuarter,
        duration: duration,
        startDate: formData.startDate,
        tollPrice: formData.tollPrice,
        ticketPrice: formData.ticketPrice
      };
      if(id){

          // console.log(newFormData.duration);
          const travelResponse = await api.post('/travels', newFormData);
          const newTravel = travelResponse.data;
        try{
          await api.post(`/planning/${planning.id}/travels`, null, {
            params: {
              travelId: newTravel.id
            }
          });
          toast.success("Voyage cree avec succes et insere au planning");
        }catch(error){
          if(error.response.status !== 400){
            toast.error("Erreur lors de la création du voyage");
            console.log("error", error);
          }
        }
      } else {
        toast.warning("Veuillez selectionner un planning");
      }
      closeModal();

    } catch (error) {
      console.error('Erreur lors de l\'ajout du voyage', error);
    }
    let calendarApi = selectedDateInfo.view.calendar;

    calendarApi.unselect(); // Clear date selection in the calendar

    if (formData.vehicleID && formData.departureCityId && formData.destinationCityId) {
      calendarApi.addEvent({
        id: createEventId(),
        title: `Vehicle: ${formData.vehicleID}`,
        start: `${formData.startDate}`,
        end: `${formData.endDate}`,
        allDay: false
      });
      closeModal();
    }
  };

  const handleUpdatePlanning = async (planning, newPlanning) => {
    try {
      const formPlanning = {
        "id": planning.id,
        "name": newPlanning.name,
        "plannedTravels": planning.plannedTravels,
        "endDate": newPlanning.endDate,
        "startDate": newPlanning.startDate,
        "state": planning.state
      };
      console.log(formData);
      const response = await api.put(`/planning/${planning.id}`, formPlanning);
      setPlanning(response.data);
      toast.success("Planning modifier avec succès");
    } catch (error) {
      toast.error("Erreur lors de la création du planning");
      console.error('Erreur lors de la création du planning:', error);
    }
  };
  const handleUpdatePlanningModal = () => {
    setIsModalOpen(!isModalOpen);
  };
  function handleEvents(events) {
    setEventsData(events);
  }
  const handleDateSelect = (selectInfo) => {
    setSelectedDateInfo(selectInfo);
    console.log(selectInfo);
    setFormData({
      ...formData,
      startDate: selectInfo.startStr.split("+")[0],
      endDate: selectInfo.endStr ? selectInfo.endStr.split("+")[0] : '',
    });
    setModalIsOpen(true);
  };
  function handleEventClick(clickInfo) {
    if (confirm(`Voulez-vous supprimer cette instance de voyage ? ${clickInfo.event.title}`)) {
      clickInfo.event.remove();
    }
  }
  if (!planning) {
    return <div>Loading...</div>;
  }

  const getStateChip = (state) => {
    switch (state) {
      case 0:
        return <Chip icon={<PublishIcon />} label="Publié" color="primary" />;
      case 1:
        return <Chip icon={<ErrorIcon />} label="Non Publié" color="error" />;
      case 2:
        return <Chip icon={<ScheduleIcon />} label="En cours" color="warning" />;
      case 3:
        return <Chip icon={<CancelIcon />} label="Annulé" color="secondary" />;
      case 4:
        return <Chip icon={<CheckCircleIcon />} label="Terminé" color="success" />;
      default:
        return <Chip icon={<PublishIcon />} label="Publié" color="primary" />;
    }
  };

  return (
    <div>
      <Toaster richColors position="top-center" />
      <BuyNowButton
        handlePublishPlanning={handlePublishPlanning} />
      <h1>{planning.name}</h1>
      <p>{planning.text}</p>
      <p><b> Date de début : </b> {planning.startDate} - <b> Date de fin : </b> {planning.endDate} {" --- "} {getStateChip(planning.state)}</p>
      <p></p>
      <div style={{ marginBottom: '15px', justifyContent: 'flex-end' }}>
        <Button variant="contained" color="primary" size="small" onClick={handleUpdatePlanningModal}>
          Modifier le planning
        </Button>
      </div>
      <UpdatePlanning
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)} // Fermer le modal
        onSave={handleUpdatePlanning} // Sauvegarder le planning
        planning={planning}
      />
      <FullCalendar
        plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin]}
        initialView="dayGridMonth"
        events={eventsData}
        validRange={{
          start: planning.startDate,
          end: planning.endDate,
        }}
        headerToolbar={{
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        }}
        eventClassNames={(eventInfo) => {
          if (eventInfo.event.extendedProps.state === 0) {
            return 'green-event';
          } else if (eventInfo.event.extendedProps.state === 1) {
            return 'blue-event';
          }
          return '';
        }}
        eventContent={(eventInfo) => {
          let color;
          if (eventInfo.event.extendedProps.state === 0) {
            color = 'green';
          } else if (eventInfo.event.extendedProps.state === 1) {
            color = 'blue';
          }
          return (
            <div style={{ backgroundColor: color, padding: '5px', borderRadius: '3px', color: 'white' }}>
              <b>{eventInfo.event.title}</b>
            </div>
          );
        }}
        selectable={true}
        dateClick={(info) => {
          alert(`Date: ${info.dateStr}`);
        }}
        select={handleDateSelect}
        themeSystem='bootstrap4'
        editable={true}
        selectMirror={true}
        dayMaxEvents={true}
        eventClick={handleEventClick}
        // eventsSet={handleEvents}
      />
      <ModalTravel
        modalIsOpen={modalIsOpen}
        closeModal={closeModal}
        formData={formData}
        cities={cities}
        quarters1={quarters1}
        quarters2={quarters2}
        vehicles={vehicles}
        handleInputChange={handleInputChange}
        handleSubmit={handleSubmit}
      />
    </div>
  );
};

export default PlanningDetail;
