import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { formatDate } from '@fullcalendar/core';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import BuyNowButton from "src/layouts/components/UpgradeToProButton";
import Typography from '@mui/material/Typography';
import Sidebar from 'src/views/trip/create-trip/Sidebar';
import listPlugin from "@fullcalendar/list"
import {Toaster, toast} from "sonner"
import ModalTravel from "src/views/trip/create-trip/Modal";
// import create from 'src/views/trip/event-utils';
// import {Modal, Box, Typography} from "@mui/material";
import {createEventId} from "src/pages/trip/event-utils";
import api from "../../../../configs/apiConfig";
// import { formatDate } from "@fullcalendar/core";

const Plannings = () => {
  const [plannings, setPlannings] = useState([]);
  const [selectedPlanning, setSelectedPlanning] = useState('');
  const [planning, setPlanning] = useState(null);
  const [currentEvents, setCurrentEvents] = useState([]);
  const handleOpen = () => setOpen(true);
  const [selectedDateInfo, setSelectedDateInfo] = useState(null);
  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [cities, setCities] = useState([]);
  const [quarters1, setQuarters1] = useState([]);
  const [quarters2, setQuarters2] = useState([]);
  const [vehicles, setVehicles] = useState([]);
  const [travelId, setTravelId] = useState(null);
  const [tripDetails, setTripDetails] = useState(null);
  const [open2, setOpen2] = useState(false);
  const handleOpen2 = () => setOpen2(true);
  const handleClose = () => setOpen2(false);
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
  const general = {
    name: "Plannings",
    startDate: "--",
    endDate: "--",
    state: "Publiés et Non publiés",
    plannedTravels: [],
  }


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
          console.log(departureDateTime);
          api.get(`/vehicles/available/${departureDateTime}`)
            .then(response => {
              console.log(response.data);
              setVehicles(response.data);
            })
            .catch(error => console.error(error));
        }
      }, [formData.startDate]);
      const fetchEventsId = async () => {
        try {
          const answer = await api.get(`/planning/${selectedPlanning}`);
          setPlanning(answer.data);
          const response = await api.get(`/planning/${selectedPlanning}/travels`);
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
          setCurrentEvents(formattedEvents);
          toast.success("Voyages chargés");
        } catch (error) {
          toast.error("Erreur lors du chargement des voyages");
          console.error('Erreur lors du chargement des événements:', error);
        }
      };

      const fetchEvents = async () => {
        try{
        const response = await api.get(`/travels`);
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
            setCurrentEvents(formattedEvents);
            toast.success("Voyages chargés");
          } catch (error) {
            toast.error("Erreur lors du chargement des voyages");
            console.error('Erreur lors du chargement des événements:', error);
          }
      };
  const calculateDuration = (startDate, endDate) => {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const duration = (end - start) / (1000 * 60); // Duration in minutes
    return duration;
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
  const handlePublishPlanning = async () => {
    if (selectedPlanning) {
      try {
        const response = await api.post(`/planning/publish/${selectedPlanning}`);
        toast.success("Planning publie avec succes");
        setPlannings(plannings);
        console.log('Planning published successfully:', response.data);
      } catch (error) {
        toast.error("Erreur lors de la publication du planning");
        console.error('Erreur lors de la publication du planning:', error);
      }
    } else {
      console.log("Pas de planning selectionné");
    }
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
      stopPoints: null,
      startDate: formData.startDate,
      tollPrice: formData.tollPrice,
      ticketPrice: formData.ticketPrice
    };
    if(selectedPlanning){

        console.log(newFormData);
        const travelResponse = await api.post('/travels', newFormData);
        console.log(travelResponse.data);
        const newTravel = travelResponse.data;
      try{
        await api.post(`/planning/${selectedPlanning}/travels`, null, {
          params: {
            travelId: newTravel.id
          }
        });
        toast.success("Voyage cree avec succes et insere au planning");
        setCurrentEvents([...currentEvents], newTravel);
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
    const fetchPlannings = async () => {
      try {
        const response = await api.get('/planning');
        setPlannings(response.data);
      } catch (error) {
        console.error('Erreur lors du chargement des plannings:', error);
      }
    };

    fetchPlannings();
  }, []);

  useEffect(() => {
    if (selectedPlanning) {
      fetchEventsId();
    }else{
    fetchEvents();
  }
  }, [selectedPlanning]);

  const fetchTripDetails = async () => {
    try {
      console.log(travelId);
      const response = await api.get(`/travels/${travelId}`);
      setTripDetails(response.data);
      console.log(response.data);
    } catch (error) {
      console.error('Erreur lors du chargement des détails du voyage:', error);
    }
  };



  const handleSelectPlanning = (planningId) => {
    setSelectedPlanning(planningId);
  };

  return (
    <div>
      {
        selectedPlanning && <BuyNowButton handlePublishPlanning={handlePublishPlanning} />
      }

      <Sidebar
        setCurrentEvents={setCurrentEvents}
        currentEvents={currentEvents}
        plannings={plannings}
        selectedPlanning={selectedPlanning}
        onSelectPlanning={handleSelectPlanning}
        general={general}
        setPlannings={setPlannings}
      />
      <FullCalendar
        plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin]}
        initialView="dayGridMonth"
        events={currentEvents}
        validRange={{
          start: Math.max(new Date(planning ? planning.startDate : general.startDate), new Date()),
          end: planning ? planning.endDate : general.end,
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
            <div style={{ backgroundColor: color, padding: '5px', borderRadius: '3px', color: 'white' }} onClick={selectedPlanning ? (() => {setTravelId(eventInfo.event.id);fetchTripDetails();handleOpen2()}) : undefined}>
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
       />
       {selectedPlanning && <ModalTravel
        modalIsOpen={modalIsOpen}
        closeModal={closeModal}
        formData={formData}
        cities={cities}
        quarters1={quarters1}
        quarters2={quarters2}
        vehicles={vehicles}
        handleInputChange={handleInputChange}
        handleSubmit={handleSubmit}
      />}
      {open2 && tripDetails &&<Modal open={open2} onClose={handleClose}>
         <Box sx={{
           position: 'absolute',
           top: '50%',
           left: '50%',
           transform: 'translate(-50%, -50%)',
           width: 400,
           bgcolor: 'background.paper',
           // border: '2px solid #000',
           boxShadow: 24,
           p: 4
         }}>
           <Typography variant="h6" component="h2">
             Détails du Voyage
           </Typography>
            <div>
              <p><b>Départ :</b> {tripDetails.departureQuarter}</p>
              <p><b>Destination :</b> {tripDetails.destinationQuarter}</p>
              <p><b>Durée :</b> {tripDetails.duration} minutes</p>
              <p><b>Date de départ :</b> {formatDate(tripDetails.startDate, { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' })}</p>
              <p><b>Prix du péage :</b> {tripDetails.tollPrice} FCFA</p>
              <p><b>Prix du billet :</b> {tripDetails.ticketPrice} FCFA</p>
            </div>
         </Box>
      </Modal>}
      <Toaster richColors position="top-right"/>
    </div>
  );
};

export default Plannings;
