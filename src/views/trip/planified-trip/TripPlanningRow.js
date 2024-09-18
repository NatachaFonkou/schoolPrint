import React, {Fragment, useState, useContext} from "react";
import TableRow from "@mui/material/TableRow";
import TableCell from "@mui/material/TableCell";
import IconButton from "@mui/material/IconButton";
import ChevronUp from "mdi-material-ui/ChevronUp";
import ChevronDown from "mdi-material-ui/ChevronDown";
import Collapse from "@mui/material/Collapse";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Table from "@mui/material/Table";
import TableHead from "@mui/material/TableHead";
import TableBody from "@mui/material/TableBody";
import TripRow from "./TripRow";
import {Stack} from "@mui/material";
import Chip from "@mui/material/Chip";
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import CancelIcon from '@mui/icons-material/Cancel';
import ScheduleIcon from '@mui/icons-material/Schedule';
import ErrorIcon from '@mui/icons-material/Error';
import PublishIcon from '@mui/icons-material/Publish'
import Button from "@mui/material/Button";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/Delete";
import { Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle } from "@mui/material";
import {useRouter} from "next/router";
import PlanningModal from "./UpdatePlanning";
import {toast} from "sonner";
import axios from 'axios';
import UpdatePlanning from "./UpdatePlanning";
import api from "../../../configs/apiConfig";
import { ClassroomsContext } from 'src/contexts/classroomContext';


const TripPlanningRow = props => {
  // ** Props
  const { row, handleClick, idOpt } = props
  console.log(row)
  // console.log(key)

  // ** State
  const [open, setOpen] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false); // State for modal visibility
  const [deleteDialogOpen, setDeleteDialogOpen] = useState(false); // State for delete dialog visibility
  const [currentPlanning, setCurrentPlanning] = useState({});
  const _classrooms=[];
  const { classrooms, loading: classroomsLoading, error: classroomsError } = useContext(ClassroomsContext);
  // const _classrooms = classrooms.filter(item => item.option.name === row.name && item.name === row.classroom.)
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

  const handleEdit = () => {
    setCurrentPlanning(row);
    setIsModalOpen(true);
  };

  const handleDelete = () => {
    setDeleteDialogOpen(true);
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.delete(`/planning/${row.id}`);
      console.log(`Planning supprimé : ${row.id}`);
      toast.success("Planning supprimé !");
      setDeleteDialogOpen(false);
    } catch (error) {
      toast.error("Erreur lors de la suppression du planning");
      console.error(`Erreur lors de la suppression du planning : ${error}`);
    }
  };

  const handleCloseModal = () => {
    setIsModalOpen(false); // Close the modal
  };

  const handleCloseDeleteDialog = () => {
    setDeleteDialogOpen(false); // Close the delete dialog
  };

  const handleSavePlanning = async (planning, newPlanning) => {
    try {
      const formPlanning = {
        "id": planning.id,
        "name": newPlanning.name,
        "plannedTravels": planning.plannedTravels,
        "endDate": newPlanning.endDate,
        "startDate": newPlanning.startDate,
        "state": planning.state
      };
      console.log(formPlanning);
      const response = await api.put(`/planning/${planning.id}`, formPlanning);
      setCurrentPlanning(response.data); // Update the current planning state
      toast.success("Planning modifié avec succès");
    } catch (error) {
      toast.error("Erreur lors de la modification du planning");
      console.error('Erreur lors de la modification du planning:', error);
    }
  };

  return (
    <Fragment>
      <TableRow sx={{ '& > *': { borderBottom: 'unset' } }}>
        <TableCell>
          <IconButton aria-label='expand row' size='small' onClick={() => setOpen(!open)}>
            {open ? <ChevronUp /> : <ChevronDown />}
          </IconButton>
        </TableCell>
        <TableCell component='th' scope='row' onClick={() => handleClick(row.id)} style={{ cursor: 'pointer' }}>
          {row.code}
        </TableCell>
        <TableCell>{row.name}</TableCell>
        <TableCell>{row.effectif}</TableCell>
        <TableCell>
          <IconButton onClick={handleEdit} color="warning">
            <EditIcon />
          </IconButton>
          <IconButton onClick={handleDelete} color="error">
            <DeleteIcon />
          </IconButton>
        </TableCell>
      </TableRow>
      <TableRow>
        <TableCell colSpan={5} sx={{ py: '0 !important' }}>
          <Collapse in={open} timeout='auto' unmountOnExit>
            <Box sx={{ m: 2 }}>
              <Typography variant='h6' gutterBottom component='div'>
                Matières
              </Typography>
              <Table size='small' aria-label='planned travels'>
                <TableHead>
                  <TableRow>
                    <TableCell />
                    <TableCell />
                    <TableCell />
                    <TableCell>Code</TableCell>
                    <TableCell>Nom</TableCell>
                    <TableCell>Nbr Evaluations</TableCell>
                    <TableCell>Enseignants</TableCell>
                    <TableCell>Coefficient</TableCell>
                    <TableCell>Actions</TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  {_classrooms? (
                    _classrooms.map((classroom, index) => (
                      <TripRow key={index} plannedTravel={classroom} planningId={row.id} />
                    ))
                  ) : (
                    <TableRow>
                      <TableCell colSpan={8} align="center">
                        <Typography variant="body1">Il n'y a pas de voyages planifiés.</Typography>
                      </TableCell>
                    </TableRow>
                  )}
                </TableBody>
              </Table>
            </Box>
          </Collapse>
        </TableCell>
      </TableRow>
      <UpdatePlanning
        isOpen={isModalOpen}
        onClose={handleCloseModal}
        onSave={handleSavePlanning}
        planning={row}
      />
      <Dialog
        open={deleteDialogOpen}
        onClose={handleCloseDeleteDialog}
      >
        <DialogTitle>{"Confirmer la suppression"}</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Êtes-vous sûr de vouloir supprimer ce planning ?
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
    </Fragment>
  );
};

export default TripPlanningRow;
