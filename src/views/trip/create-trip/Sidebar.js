import React, {useState} from 'react';
import { formatDate } from "@fullcalendar/core";
import { useRouter } from 'next/router';
import {Button } from '@mui/material';
import PlanningModal from './PlanningModal';
import {Toaster, toast} from "sonner";
import axios from 'axios';
import Chip from "@mui/material/Chip";
import {Stack} from "@mui/material";
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import CancelIcon from '@mui/icons-material/Cancel';
import ScheduleIcon from '@mui/icons-material/Schedule';
import ErrorIcon from '@mui/icons-material/Error';
import PublishIcon from '@mui/icons-material/Publish'
import api from "../../../configs/apiConfig";
const Sidebar = ({ setPlannings,setCurrentEvents, handleWeekendsToggle,general, currentEvents, plannings, selectedPlanning, onSelectPlanning, onCreatePlanning }) => {
  const selectedPlanningDetails = plannings.find(planning => planning.id === selectedPlanning);
  const router = useRouter();
  const [isModalOpen, setIsModalOpen] = useState(false);
  const handleClick = (id) => {
    router.push(`/planning/${id}`);
  };
  const handleCreatePlanning = async (newPlanning) => {
    try {
    const response = await api.post('/planning', newPlanning);
    setPlannings([...plannings, response.data]);
    // setPlannings([...plannings, newPlanning]);
    toast.success("Planning créé avec succès");
    } catch (error) {
    toast.error("Erreur lors de la création du planning");
    console.error('Erreur lors de la création du planning:', error);
    }
};
  const handleCreatePlanningModal = () => {
      setIsModalOpen(!isModalOpen);
  };

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
    <div className='demo-app-sidebar' style={{ display: 'flex', justifyContent: 'space-around', alignItems: 'center', borderRadius: '10px', boxShadow: '0px 2px 1px -1px rgba(58, 53, 65, 0.2), 0px 1px 1px 0px rgba(58, 53, 65, 0.14), 0px 1px 3px 0px rgba(58, 53, 65, 0.12)', marginBottom: '30px' }}>
      <div className='demo-app-sidebar-section' onClick={() => handleClick(selectedPlanning)}>
        <h1 style={{ color: '#9155FD'}}>{selectedPlanningDetails ? selectedPlanningDetails.name : general.name}</h1>
        {/* <p>Date de début: {selectedPlanningDetails ? selectedPlanningDetails.startDate : general.startDate}</p>
        <p>Date de fin : {selectedPlanningDetails ? selectedPlanningDetails.endDate : general.endDate}</p>
        <p>Etat: {selectedPlanningDetails ? (selectedPlanningDetails.state === 1 ? "Unpublished" : "Published") : general.state}</p>  */}
        <p><b> Date de début : </b> {selectedPlanningDetails ? selectedPlanningDetails.startDate : general.startDate} - <b> Date de fin : </b> {selectedPlanningDetails ? selectedPlanningDetails.endDate : general.endDate}</p> <p> {selectedPlanningDetails ? getStateChip(selectedPlanningDetails.state) : general.state }</p>
      </div>
      <div className='demo-app-sidebar-section'>
        <h2 style={{ color: '#9155FD'}}> Gestion des Plannings</h2>
        <div style={{display: 'flex', flexDirection: 'column'}}>
          <div>
            <label>Sélectionner un planning :</label>
            <select value={selectedPlanning} onChange={(e) => onSelectPlanning(e.target.value)}>
              <option value="">Sélectionner un planning</option>
              {plannings.map((planning) => (
                <option key={planning.id} value={planning.id}>{planning.name}</option>
              ))}
            </select>
          </div>
          {selectedPlanningDetails && (
            <div style={{marginBottom: '10px'}}>
              <b>Date de début :</b> {formatDate(selectedPlanningDetails.startDate, { year: 'numeric', month: 'short', day: 'numeric' })} -
              <b>Date de fin :</b> {formatDate(selectedPlanningDetails.endDate, { year: 'numeric', month: 'short', day: 'numeric' })}
            </div>
          )}
          <div style={{marginBottom: '15px'}}>
          <div style={{marginBottom: '15px'}}>
            <Button variant="contained" color="primary" size="small" onClick={handleCreatePlanningModal}>
              Créer un nouveau planning
            </Button>
          </div>
        <PlanningModal
            isOpen={isModalOpen}
            onClose={() => setIsModalOpen(false)} // Fermer le modal
            onSave={handleCreatePlanning} // Sauvegarder le planning
        />
          </div>
        </div>
      </div>
    </div>
  );
}

export default Sidebar;
