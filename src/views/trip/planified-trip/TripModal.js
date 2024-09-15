import React, { useState, useEffect } from 'react';
import Dialog from '@mui/material/Dialog';
import DialogTitle from '@mui/material/DialogTitle';
import DialogContent from '@mui/material/DialogContent';
import DialogActions from '@mui/material/DialogActions';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import axios from 'axios';
import { format, parseISO } from 'date-fns';
import api from "../../../configs/apiConfig";

const TripModal = ({ open, handleClose, travel, data, handleSave }) => {
  const [formData, setFormData] = useState(travel);
  const [stopPoints, setStopPoints] = useState(travel.stopPoints || []);
  const [numStopPoints, setNumStopPoints] = useState(stopPoints.length);
  const [cities, setCities] = useState([]);

  useEffect(() => {
    setFormData({ ...travel, stopPoints });
  }, [stopPoints, travel]);

  useEffect(() => {
    const fetchCities = async () => {
      try {
        const response = await api.get('/cities');
        setCities(response.data);
      } catch (error) {
        console.error('Erreur lors du chargement des villes:', error);
      }
    };

    fetchCities();
  }, []);
  const formatDate = (dateString) => {
    if (!dateString) return '';
    return format(parseISO(dateString), 'dd/MM/yyyy HH:mm');
  };

  const formatDuration = (minutes) => {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    return `${hours}h ${remainingMinutes}m`;
  };

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleNumStopPointsChange = (e) => {
    const value = parseInt(e.target.value, 10);
    setNumStopPoints(value);

    const newStopPoints = [...stopPoints];
    while (newStopPoints.length < value) {
      newStopPoints.push({ cityId: '', duration: '' });
    }
    while (newStopPoints.length > value) {
      newStopPoints.pop();
    }
    setStopPoints(newStopPoints);
  };

  const handleStopPointChange = (index, field, value) => {
    const newStopPoints = [...stopPoints];
    newStopPoints[index][field] = value;
    setStopPoints(newStopPoints);
  };

  const handleSubmit = () => {
    handleSave({ ...formData, stopPoints });
    handleClose();
  };

  return (
    <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Détails du Voyage</DialogTitle>
      <DialogContent>
        <TextField
          margin="dense"
          label="Véhicule"
          type="text"
          fullWidth
          value={data.vehicle.categoryCode}
          disabled
        />
        <TextField
          margin="dense"
          label="Conducteur"
          type="text"
          fullWidth
          value={data.driver ? data.driver.name : ''}
          disabled
        />
        <TextField
          margin="dense"
          label="Lieu de Départ"
          type="text"
          fullWidth
          value={`${data.city1.name} - ${travel.departureQuarter}`}
          disabled
        />
        <TextField
          margin="dense"
          label="Lieu d'Arrivée"
          type="text"
          fullWidth
          value={`${data.city2.name} - ${travel.destinationQuarter}`}
          disabled
        />
        <TextField
          margin="dense"
          label="Date de Début"
          type="datetime-local"
          fullWidth
          name="startDate"
          value={formData.startDate}
          onChange={handleChange}
        />
        <TextField
          margin="dense"
          label="Durée (minutes)"
          type="number"
          fullWidth
          name="duration"
          value={formData.duration}
          disabled
        />
        <TextField
          margin="dense"
          label="Prix du Billet"
          type="number"
          fullWidth
          name="ticketPrice"
          value={formData.ticketPrice}
          onChange={handleChange}
        />
        <TextField
          margin="dense"
          label="Nombre de points d'arrêt"
          type="number"
          fullWidth
          value={numStopPoints}
          onChange={handleNumStopPointsChange}
        />
        {stopPoints.map((stopPoint, index) => (
          <div key={index}>
            <Autocomplete
              options={cities}
              getOptionLabel={(option) => option.name}
              value={cities.find(city => city.id === stopPoint.cityId) || null}
              onChange={(e, newValue) => handleStopPointChange(index, 'cityId', newValue ? newValue.id : '')}
              renderInput={(params) => (
                <TextField
                  {...params}
                  margin="dense"
                  label={`Point d'arrêt ${index + 1} - Lieu`}
                  type="text"
                  fullWidth
                />
              )}
            />
            <TextField
              margin="dense"
              label={`Point d'arrêt ${index + 1} - Durée (minutes)`}
              type="number"
              fullWidth
              value={stopPoint.duration}
              onChange={(e) => handleStopPointChange(index, 'duration', e.target.value)}
            />
          </div>
        ))}
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} color="primary">Fermer</Button>
        <Button onClick={handleSubmit} color="primary">Enregistrer</Button>
      </DialogActions>
    </Dialog>
  );
};

export default TripModal;
