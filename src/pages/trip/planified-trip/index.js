import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { formatDate } from '@fullcalendar/core';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import { INITIAL_EVENTS, createEventId } from '../event-utils';
import BuyNowButton from "../../../layouts/components/UpgradeToProButton";
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Select from '@mui/material/Select';
import MenuItem from '@mui/material/MenuItem';
import Container from '@mui/material/Container';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import Typography from '@mui/material/Typography';
import PlanningTable from "../../../views/trip/planified-trip/PlanningTable";
import Grid from "@mui/material/Grid";
import Link from "@mui/material/Link";
import CardHeader from "@mui/material/CardHeader";
import {useRouter} from "next/router";
import api from "../../../configs/apiConfig";

export default function PlanifiedTrip() {

  const [rows, setRows] = useState([]);
  const router = useRouter();

  const handleClick = (id) => {
    router.push(`/planning/${id}`);
  };

  useEffect(() => {
    const fetchPlannings = async () => {
      try {
        const response = await api.get('/planning');
        setRows(response.data);
        console.log(response.data)
      } catch (error) {
        console.error('Erreur lors du chargement des plannings:', error);
      }
    };

    fetchPlannings();
  }, []);
  return(
    <Grid container spacing={6}>
      <Grid item xs={12}>
        <Typography variant='h5'>
          <Link href='' target='_blank'>
            Voyages Planifies
          </Link>
        </Typography>
        <Typography variant='body2'>Par planning</Typography>
      </Grid>
      <Grid item xs={12}>
        <Card>
          <CardHeader title='Planning' titleTypographyProps={{ variant: 'h6' }} />
          <PlanningTable rows={rows} handleClick={handleClick}/>
        </Card>
      </Grid>
    </Grid>
  )
}


