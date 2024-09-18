import TableCell from "@mui/material/TableCell";
import TableRow from "@mui/material/TableRow";
import React, {useEffect, useState} from "react";
import axios from "axios";
import { format, parseISO } from 'date-fns';
import Chip from "@mui/material/Chip";
import {Stack} from "@mui/material";
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import CancelIcon from '@mui/icons-material/Cancel';
import ScheduleIcon from '@mui/icons-material/Schedule';
import ErrorIcon from '@mui/icons-material/Error';
import PublishIcon from '@mui/icons-material/Publish'
import IconButton from "@mui/material/IconButton";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/Delete";
import TripModal from "./TripModal";
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, Button } from "@mui/material";
import {toast} from "sonner";
import api from "../../../configs/apiConfig";

const TripRow = ({ planningId, plannedTravel }) => {
  const [travel, setTravel] = useState({})
  const [data, setData] = useState({
    vehicle: '',
    driver: '',
    city1: '',
    city2: ''
  });
  const [modalOpen, setModalOpen] = useState(false);
  const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);
  useEffect(() => {
    const fetchTravels = async () => {
      try {
        const response = await api.get(`/travels/${plannedTravel}`);
        const travelData = response.data;
        setTravel(travelData);
        console.log("Travel Data:", travelData);
      } catch (error) {
        toast.error("Erreur lors du chargement de planning")
        console.error('Erreur lors du chargement des plannings:', error);
      }
    };
    fetchTravels();
  }, [plannedTravel]);

  useEffect(() => {
    const fetchVehicle = async () => {
      try {
        const vehicleRequest = await api.get(`/vehicles/${travel.vehicleID}`);
        setData(prevData => ({ ...prevData, vehicle: vehicleRequest.data }));
      } catch (err) {
        console.error('Erreur lors du chargement des données du véhicule:', err);
        toast.error('Erreur lors du chargement des données du véhicule');
      }
    };

    fetchVehicle();
  }, [travel.vehicleID]);

  useEffect(() => {
    const fetchDriver = async () => {
      try {
        const driverRequest = await api.get(`/drivers/${travel.driverID}`);
        setData(prevData => ({ ...prevData, driver: driverRequest.data }));
      } catch (err) {
        console.error('Erreur lors du chargement des données du conducteur:', err);
        toast.error('Erreur lors du chargement des données du conducteur');
      }
    };

    fetchDriver();
  }, [travel.driverID]);

  useEffect(() => {
    const fetchCity1 = async () => {
      try {
        const city1Request = await api.get(`/cities/${travel.departureCityId}`);
        setData(prevData => ({ ...prevData, city1: city1Request.data }));
      } catch (err) {
        console.error('Erreur lors du chargement des données de la ville de départ:', err);
        toast.error('Erreur lors du chargement des données de la ville de départ');
      }
    };

    fetchCity1();
  }, [travel.departureCityId]);

  useEffect(() => {
    const fetchCity2 = async () => {
      try {
        const city2Request = await api.get(`/cities/${travel.destinationCityId}`);
        setData(prevData => ({ ...prevData, city2: city2Request.data }));
      } catch (err) {
        console.error('Erreur lors du chargement des données de la ville de destination:', err);
        toast.error('Erreur lors du chargement des données de la ville de destination');
      }
    };

    fetchCity2();
  }, [travel.destinationCityId]);


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

  const formatDate = (dateString) => {
    if (!dateString) return ''; // Return empty string or handle the default case
    return format(parseISO(dateString), 'dd/MM/yyyy HH:mm');
  };

  const formatDuration = (minutes) => {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    return `${hours}h ${remainingMinutes}m`;
  };

  const handleEdit = () => {
    setModalOpen(true);
  };

  const handleDelete = () => {
    setDeleteDialogOpen(true);
  };

  const handleDeleteConfirm = async () => {
    try {
      const params = {
        travelId: travel.id,
        newStartDate: travel.startDate
      };

      await api.delete(`/planning/${planningId}/travels`, { params });
      console.log(`Voyage supprimé : ${travel.id}`);
      toast.info("Voyage Supprimé !");
      setDeleteDialogOpen(false);
    } catch (error) {
      toast.error("Erreur lors de la suppression du voyage");
      console.error(`Erreur lors de la suppression du voyage : ${error}`);
    }
  };

  const handleCloseModal = () => {
    setModalOpen(false);
  };

  const handleCloseDeleteDialog = () => {
    setDeleteDialogOpen(false);
  };

  const handleSave = async (updatedTravel) => {
    try {
      await api.put(`/travels/${travel.id}`, updatedTravel);
      setTravel(updatedTravel);
      toast.success("Mise a jour reussie ! ")
      console.log(`Voyage mis à jour : ${updatedTravel.id}`);
    } catch (error) {
      toast.error("Erreur lors de la mise à jour du voyage ! ")
      console.error(`Erreur lors de la mise à jour du voyage : ${error}`);
    }
  };

  const handleRowClick = () => {
    setModalOpen(true);
  };



  return (
    
    <>
      <TableRow key={travel.startDate} onClick={handleRowClick} style={{ cursor: 'pointer' }}>
        <TableCell/>
        <TableCell/>
        <TableCell/>
        <TableCell component="th" scope="row">{plannedTravel.code}</TableCell>
        <TableCell>{plannedTravel.name}</TableCell>
        <TableCell>{data.city2.name} - {travel.destinationQuarter}</TableCell>
        <TableCell>{plannedTravel.teacher.name}</TableCell>
        <TableCell><b>{formatDate(travel.startDate)}</b></TableCell>
        <TableCell>
          <IconButton onClick={handleEdit} color="warning">
            <EditIcon />
          </IconButton>
          <IconButton onClick={handleDelete} color="error">
            <DeleteIcon />
          </IconButton>
        </TableCell>
      </TableRow>
      <TripModal open={modalOpen} handleClose={handleCloseModal} travel={travel} data={data} handleSave={handleSave} />
      <Dialog
        open={deleteDialogOpen}
        onClose={handleCloseDeleteDialog}
      >
        <DialogTitle>{"Confirmer la suppression"}</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Êtes-vous sûr de vouloir supprimer ce voyage ?
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDeleteDialog} color="primary">
            Annuler
          </Button>
          <Button onClick={handleDeleteConfirm} color="error" autoFocus>
            Supprimer
          </Button>
        </DialogActions>
      </Dialog>
    </>
  );
};

export default TripRow;
