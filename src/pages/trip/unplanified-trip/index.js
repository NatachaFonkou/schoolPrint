// ** MUI Imports
import Grid from '@mui/material/Grid'
import Link from '@mui/material/Link'
import Card from '@mui/material/Card'
import Typography from '@mui/material/Typography'
import CardHeader from '@mui/material/CardHeader'
import CanceledTripTable from "../../../views/trip/unplanified-trip/CanceledTripTable";
import {useEffect, useState} from "react";
import axios from "axios";
import api from "../../../configs/apiConfig";

const UnplannifiedTrip = () => {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    const fetchPlannings = async () => {
      try {
        const response = await api.get('/histories');
        setRows(response.data);
        console.log(response.data)
      } catch (error) {
        console.error('Erreur lors du chargement des plannings:', error);
      }
    };

    fetchPlannings();
  }, []);

  return (
    <Grid container spacing={6}>
      <Grid item xs={12}>
        <Typography variant='h5'>
          <Link href='' target='_blank'>
            Voyages Annulés
          </Link>
        </Typography>
        <Typography variant='body2'>Par planning</Typography>
      </Grid>
      <Grid item xs={12}>
        <Card>
          <CardHeader title='Voyages' titleTypographyProps={{ variant: 'h6' }} />
          <CanceledTripTable  />
        </Card>
      </Grid>
    </Grid>
  )
}

export default UnplannifiedTrip
