import React, {useEffect, useState} from "react";
import axios from "axios";
import {Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography} from "@mui/material";
import CanceledTripRow from "./CanceledTripRow";
import api from "../../../configs/apiConfig";

const CanceledTripTable = () => {
  const [canceledTrips, setCanceledTrips] = useState([]);

  useEffect(() => {
    api.get('/histories')
      .then(response => {
        setCanceledTrips(response.data);
      })
      .catch(error => console.error(error));
  }, []);

  return (
    <TableContainer component={Paper}>
      <Table aria-label='canceled trips table'>
        <TableHead>
          <TableRow>
            <TableCell>Véhicule</TableCell>
            <TableCell>Conducteur</TableCell>
            <TableCell>Lieu de Départ</TableCell>
            <TableCell>Lieu d'arrivée</TableCell>
            <TableCell>Heure de Départ</TableCell>
            <TableCell>Durée</TableCell>
            <TableCell>Prix du billet</TableCell>
            <TableCell>État</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {canceledTrips.length === 0 ? (
            <TableRow>
              <TableCell colSpan={8} align='center'>
                <Typography variant='body1'>Il n'y a pas de voyages annulés.</Typography>
              </TableCell>
            </TableRow>
          ) : (
            canceledTrips.map((travel, index) => (
              <CanceledTripRow key={index} travel={travel} />
            ))
          )}
        </TableBody>
      </Table>
    </TableContainer>
  );
};

export default CanceledTripTable;
