  import React, {useState} from 'react';
  import Dialog from '@mui/material/Dialog';
  import DialogTitle from '@mui/material/DialogTitle';
  import DialogContent from '@mui/material/DialogContent';
  import DialogContentText from '@mui/material/DialogContentText';
  import DialogActions from '@mui/material/DialogActions';
  import Button from '@mui/material/Button';
  import TextField from '@mui/material/TextField';
  import Select from '@mui/material/Select';
  import MenuItem from '@mui/material/MenuItem';

  const ModalTravel = ({ modalIsOpen, closeModal, formData, cities, quarters1, quarters2, vehicles, handleInputChange, handleSubmit }) => {
    const [selectedVehicle, setSelectedVehicle] = useState(null);
    const handleVehicleSelect = (event) => {
      const selectedVehicleId = event.target.value;
      const selected = vehicles.find(vehicle => vehicle.id === selectedVehicleId);
      setSelectedVehicle(selected);
    };

    return (
      <Dialog
        open={modalIsOpen}
        onClose={closeModal}
        aria-labelledby="form-dialog-title"
        maxWidth="md"
        fullWidth
      >
        <DialogTitle id="form-dialog-title">Ajouter un nouveau voyage</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Veuillez entrer les informations concernant le voyage.
          </DialogContentText>
          <form onSubmit={handleSubmit}>
            <div style={{display: 'flex', gap: '20px', marginTop: '1rem'}}>
              <TextField
                autoFocus
                margin="dense"
                name="startDate"
                label="Date et heure de départ"
                type="datetime-local"
                fullWidth
                value={formData.startDate}
                onChange={handleInputChange}
                required
                InputLabelProps={{
                  shrink: true,
                }}
              />
              <TextField
                margin="dense"
                name="endDate"
                label="Date et heure d'arrivée"
                type="datetime-local"
                fullWidth
                value={formData.endDate}
                onChange={handleInputChange}
                required
                InputLabelProps={{
                  shrink: true,
                }}
              />
            </div>


            <div>
              Véhicules Disponibles
              <Select
                margin="dense"
                name="vehicleID"
                label="Véhicule disponible"
                fullWidth
                value={formData.vehicleID}
                onChange={(e) => {
                  handleInputChange(e);
                  handleVehicleSelect(e);
                }}
                required
                inputProps={{shrink: true}}
              >
                {vehicles.length === 0 ? (
                  <MenuItem disabled>Pas de véhicules disponibles</MenuItem>
                ) : (
                  vehicles.map(vehicle => (
                    <MenuItem key={vehicle.id} value={vehicle.id}>
                      {vehicle.registrationNumber}
                    </MenuItem>
                  ))
                )}
              </Select>

              {/* Modal pour afficher les détails du véhicule sélectionné */}
              <Dialog
                open={!!selectedVehicle}
                onClose={() => setSelectedVehicle(null)}
                aria-labelledby="modal-title"
                aria-describedby="modal-description"
              >
                <div style={{
                  position: 'absolute',
                  top: '50%',
                  left: '50%',
                  transform: 'translate(-50%, -50%)',
                  backgroundColor: '#fff',
                  padding: '20px',
                  borderRadius: '5px',
                  boxShadow: '0px 0px 10px rgba(0, 0, 0, 0.1)',
                  minWidth: '300px'
                }}>
                  <DialogTitle id="modal-title">Détails du véhicule</DialogTitle>
                  <DialogContent>
                    <DialogContentText id="modal-description">
                      {selectedVehicle && (
                        <div>
                          <p><b>Numéro d'immatriculation :</b> {selectedVehicle.registrationNumber}</p>
                          <p><b>État :</b> {selectedVehicle.state === 2 ? 'Actif' : 'Inactif'}</p>
                          <p><b>Capacité :</b> {selectedVehicle.capacity}</p>
                          <p><b>Code de catégorie :</b> {selectedVehicle.categoryCode}</p>
                          <p><b>Numéro de châssis :</b> {selectedVehicle.chassisNumber}</p>
                          <p><b>Boîte de vitesses :</b> {selectedVehicle.gearBox === 1 ? 'Manuelle' : 'Automatique'}</p>
                          <p><b>Date de première circulation :</b> {selectedVehicle.firstCirculation}</p>
                          <p><b>Date de dernière fin de voyage :</b> {selectedVehicle.lastTravelEndDateTime}</p>
                          {/* Ajoutez d'autres détails du véhicule ici */}
                        </div>
                      )}
                    </DialogContentText>
                  </DialogContent>
                  <DialogActions>
                    <Button onClick={() => setSelectedVehicle(null)} color="primary">
                      Fermer
                    </Button>
                  </DialogActions>
                </div>
              </Dialog>
            </div>
            <div style={{display: 'flex', gap: '20px', marginTop: '1rem'}}>
              <div style={{width: 420}}>Ville de départ
                <Select
                  margin="dense"
                  name="departureCityId"
                  label="Ville de départ"
                  fullWidth
                  value={formData.departureCityId}
                  onChange={handleInputChange}
                  required
                  InputLabelProps={{shrink: true}}
                >
                  {cities.length === 0 ? (
                    <MenuItem disabled>Pas de Villes enregistrées</MenuItem>
                  ) : (
                    cities.map((city) => (
                      <MenuItem key={city.id} value={city.id}>
                        {city.name}
                      </MenuItem>
                    ))
                  )}
                </Select>
              </div>
              <div style={{width: 420}}> Quartier de départ
                <Select
                  margin="dense"
                  name="departureQuarter"
                  label="Quartier de départ"
                  fullWidth
                  value={formData.departureQuarter}
                  onChange={handleInputChange}
                  required
                  InputLabelProps={{shrink: true}}
                >
                  {quarters1.length === 0 ?
                    <MenuItem> Pas de quartiers disponibles</MenuItem> : (
                      quarters1.map((quarter, index) => (
                        <MenuItem key={index} value={quarter}>
                          {quarter}
                        </MenuItem>
                      )))}
                </Select>
              </div>
            </div>
            <TextField
              margin="dense"
              name="ticketPrice"
              label="Prix du billet"
              type="number"
              fullWidth
              value={formData.ticketPrice}
              onChange={handleInputChange}
              required
            />
            <div style={{display: 'flex', gap: '20px', marginTop: '1rem'}}>
              <div style={{width: 420}}>Ville d'arrivée
                <Select
                  margin="dense"
                  name="destinationCityId"
                  label="Ville de destination"
                  fullWidth
                  value={formData.destinationCityId}
                  onChange={handleInputChange}
                  required
                  InputLabelProps={{shrink: true}}
                >
                  {cities.length === 0 ? (
                    <MenuItem disabled>Pas de Villes enregistrées</MenuItem>
                  ) : (
                    cities.map((city) => (
                      <MenuItem key={city.id} value={city.id}>
                        {city.name}
                      </MenuItem>
                    ))
                  )}
                </Select>
              </div>
              <div style={{width: 420}}> Quartier d'arrivée
                <Select
                  margin="dense"
                  name="destinationQuarter"
                  label="Quartier d'arrivee"
                  fullWidth
                  value={formData.destinationQuarter}
                  onChange={handleInputChange}
                  required
                  InputLabelProps={{shrink: true}}
                >
                  {quarters2.length === 0 ?
                    <MenuItem> Pas de quartiers disponibles</MenuItem> : (
                      quarters2.map((quarter, index) => (
                        <MenuItem key={index} value={quarter}>
                          {quarter}
                        </MenuItem>
                      )))}
                </Select>
              </div>
            </div>
            <TextField
              margin="dense"
              name="ticketPrice"
              label="Prix du billet"
              type="number"
              fullWidth
              value={formData.ticketPrice}
              onChange={handleInputChange}
              required
            />
            <DialogActions>
              <Button onClick={closeModal} color="primary">
                Annuler
              </Button>
                <Button type="submit" color="primary">
                  Ajouter
                </Button>
            </DialogActions>
          </form>
        </DialogContent>
      </Dialog>
    );
  }

  export default ModalTravel;
