import React, { useState } from 'react';
import { Modal, TextField, Button } from '@mui/material';

const PlanningModal = ({ isOpen, onClose, onSave }) => {
  const [name, setName] = useState('');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');

  const handleSave = () => {
    onSave({ name, startDate, endDate });
    setName('');
    setStartDate('');
    setEndDate('');
    onClose();
  };

  return (
    <Modal open={isOpen} onClose={onClose}>
      <div style={{
        position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%, -50%)',
        backgroundColor: 'white', padding: '16px', borderRadius: '8px', boxShadow: '0px 2px 10px rgba(0,0,0,0.1)'
      }}>
        <h2>Créer un nouveau planning</h2>
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
