import React, { useState, Fragment } from 'react'

// ** MUI Imports
import Box from '@mui/material/Box'
import Paper from '@mui/material/Paper'
import Table from '@mui/material/Table'
import Collapse from '@mui/material/Collapse'
import TableRow from '@mui/material/TableRow'
import TableHead from '@mui/material/TableHead'
import TableBody from '@mui/material/TableBody'
import TableCell from '@mui/material/TableCell'
import Typography from '@mui/material/Typography'
import IconButton from '@mui/material/IconButton'
import TableContainer from '@mui/material/TableContainer'

// ** Icons Imports
import ChevronUp from 'mdi-material-ui/ChevronUp'
import ChevronDown from 'mdi-material-ui/ChevronDown'
import TripPlanningRow from "./TripPlanningRow";
import {useRouter} from "next/router";
import {Toaster} from "sonner";

const PlanningTable = ({rows, handleClick}) => {



  return (

  <TableContainer component={Paper}>
    <Toaster richColors position="top-right"/>
      <Table aria-label='collapsible table'>
        <TableHead>
          <TableRow>
            <TableCell />
            <TableCell>Nom</TableCell>
            <TableCell>Date de début</TableCell>
            <TableCell>Date de fin</TableCell>
            <TableCell>État</TableCell>
            <TableCell>Actions</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
        {rows.length === 0 ? (
          <TableRow>
            <TableCell colSpan={5} align="center">
              <Typography variant="body1">Il n'y a pas de voyages planifiés.</Typography>
            </TableCell>
          </TableRow>
        ) : (
          rows.map((row) => (
            <TripPlanningRow key={row.id} row={row} handleClick={handleClick} />
          ))
        )}
      </TableBody>
      </Table>
    </TableContainer>
  )
}

export default PlanningTable
