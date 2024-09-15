// pages/index.js
import React, {useEffect, useState} from 'react';
import { useRouter } from 'next/router';
import Grid from '@mui/material/Grid';
import Container from '@mui/material/Container';
import Card from '../../@core/components/card/Card';
import { Toaster, toast } from "sonner";
import PlanningModal from 'src/views/trip/PlanningModal';
import { Button } from '@mui/material';
import api from "../../configs/apiConfig";

const Plannings = () => {
    const router = useRouter();
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [plannings, setPlannings] = useState([]);
    useEffect(() => {
        const fetchPlannings = async () => {
        try {
            const response = await api.get('/planning');
            setPlannings(response.data);
        } catch (error) {
            console.error('Erreur lors du chargement des plannings:', error);
        }
        };

    fetchPlannings();
  }, []);
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
  const handleClick = (id) => {
    router.push(`/planning/${id}`);
  };

  return (
    <>
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
        <Container maxWidth="lg pb-10">
            <Grid container spacing={2}>
                {plannings.map((planning) => (
                <Grid item xs={12} md={6} key={planning.id}>
                    <div onClick={() => handleClick(planning.id)}>
                    <Card
                        state={planning.state}
                        title={planning.name}
                        text={"Start date " + planning.startDate + " - EndDate " + planning.endDate }
                    />
                    </div>
                </Grid>
                ))}
            </Grid>
        </Container>
    </>
  );
};

export default Plannings;
