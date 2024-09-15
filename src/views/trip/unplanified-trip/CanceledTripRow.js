import React, { useEffect, useState } from 'react';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Typography } from '@mui/material';
import api from "../../../configs/apiConfig";


const CanceledTripRow = ({ travel }) => {
  const [vehicle, setVehicle] = useState('');
  const [driver, setDriver] = useState('');
  const [city1, setCity1] = useState('');
  const [city2, setCity2] = useState('');

  useEffect(() => {
    const fetchVehicle = api.get(`/vehicles/${travel.vehiculeID}`);
    const fetchDriver = api.get(`/drivers/${travel.driverID}`);
    const fetchCity1 = api.get(`/cities/${travel.departureCityId}`);
    const fetchCity2 = api.get(`/cities/${travel.destinationCityId}`);

    Promise.all([fetchVehicle, fetchDriver, fetchCity1, fetchCity2])
      .then(([vehicleRes, driverRes, city1Res, city2Res]) => {
        setVehicle(vehicleRes.data);
        setDriver(driverRes.data);
        setCity1(city1Res.data);
        setCity2(city2Res.data);
      })
      .catch(error => console.error(error));
  }, [travel]);

  return (
    <TableRow key={travel.startDate}>
      <TableCell component='th' scope='row'>{vehicle.categoryCode}</TableCell>
      <TableCell>{driver.name}</TableCell>
      <TableCell>{city1.name} - {travel.departureQuarter}</TableCell>
      <TableCell>{city2.name} - {travel.destinationQuarter}</TableCell>
      <TableCell>{travel.startDate}</TableCell>
      <TableCell>{travel.duration}</TableCell>
      <TableCell>{travel.ticketPrice}</TableCell>
      <TableCell>{travel.state}</TableCell>
    </TableRow>
  );
};

export default CanceledTripRow;
