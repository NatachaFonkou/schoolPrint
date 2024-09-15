import React, { useState } from 'react';
import { Modal, TextField, Button } from '@mui/material';

const PlanningModal = ({ isOpen, onClose, onSave, planning }) => {
  const [name, setName] = useState(planning.name);
  const [startDate, setStartDate] = useState(planning.startDate);
  const [endDate, setEndDate] = useState(planning.endDate);

  const handleSave = () => {
    onSave(planning,{ name, startDate, endDate });
    setName(name);
    setStartDate(startDate);
    setEndDate(endDate);
    onClose();
  };

  return (
    <Modal open={isOpen} onClose={onClose}>
      <div style={{
        position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%, -50%)',
        backgroundColor: 'white', padding: '16px', borderRadius: '8px', boxShadow: '0px 2px 10px rgba(0,0,0,0.1)'
      }}>
        <h2>Modifier le planning</h2>
        <TextField
          label="Nom du planning"
          value={name}
          onChange={(e) => setName(e.target.value)}
          fullWidth
          margin="normal"
        />
        <TextField
          label="Date de début"
          type="date"
          value={startDate}
          onChange={(e) => setStartDate(e.target.value)}
          fullWidth
          margin="normal"
          InputLabelProps={{ shrink: true }}
        />
        <TextField
          label="Date de fin"
          type="date"
          value={endDate}
          onChange={(e) => setEndDate(e.target.value)}
          fullWidth
          margin="normal"
          InputLabelProps={{ shrink: true }}
        />
        <Button onClick={handleSave} variant="contained" color="primary" style={{ marginTop: '16px' }}>Sauvegarder</Button>
        <Button onClick={onClose} variant="contained" color="secondary" style={{ marginTop: '16px', marginLeft: '8px' }}>Annuler</Button>
      </div>
    </Modal>
  );
}

export default PlanningModal;
