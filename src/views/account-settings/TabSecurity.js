// ** React Imports
import {useContext, useState} from 'react'

// ** MUI Imports
import Box from '@mui/material/Box'
import Grid from '@mui/material/Grid'
import Avatar from '@mui/material/Avatar'
import Button from '@mui/material/Button'
import Divider from '@mui/material/Divider'
import InputLabel from '@mui/material/InputLabel'
import IconButton from '@mui/material/IconButton'
import Typography from '@mui/material/Typography'
import CardContent from '@mui/material/CardContent'
import FormControl from '@mui/material/FormControl'
import OutlinedInput from '@mui/material/OutlinedInput'
import InputAdornment from '@mui/material/InputAdornment'

// ** Icons Imports
import {SubjectsContext} from "../../contexts/subjectContext";
import TextField from "@mui/material/TextField";
import MenuItem from "@mui/material/MenuItem";
import Checkbox from "@mui/material/Checkbox";
import {ListItemText} from "@mui/material";
import Select from "@mui/material/Select";

const TabSecurity = () => {
  const { subjects, loading: subjectsLoading, error: subjectsError } = useContext(SubjectsContext);

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    tel: '',
    adresse: '',
    subjects: [] // For selected subjects
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const handleSubjectsChange = (event) => {
    const { value } = event.target;
    setFormData({
      ...formData,
      subjects: typeof value === 'string' ? value.split(',') : value
    });
  };

  if (subjectsLoading) {
    return <div>Loading subjects...</div>;
  }

  if (subjectsError) {
    return <div>Error loading subjects: {subjectsError.message}</div>;
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const newTeacherData = {
        name: formData.name,
        email: formData.email,
        tel: formData.tel,
        adresse: formData.adresse,
        subjects: formData.subjects
      };
      const response = await api.post('/teachers', newTeacherData); // Adjust endpoint accordingly
      console.log('Teacher saved successfully:', response.data);
    } catch (error) {
      console.error('Error saving teacher:', error);
    }
  };


  return (
    <CardContent>
      <form onSubmit={handleSubmit}>
        <Grid container spacing={7}>
          <Grid item xs={12} sm={4}>
            <TextField
              fullWidth
              label="Nom"
              name="name"
              value={formData.name}
              onChange={handleInputChange}
            />
          </Grid>
          <Grid item xs={12} sm={4}>
            <TextField
              fullWidth
              label="Email"
              name="email"
              value={formData.email}
              onChange={handleInputChange}
            />
          </Grid>
          <Grid item xs={12} sm={4}>
            <TextField
              fullWidth
              label="Téléphone"
              name="tel"
              value={formData.tel}
              onChange={handleInputChange}
            />
          </Grid>
          <Grid item xs={12} sm={4}>
            <TextField
              fullWidth
              label="Adresse"
              name="adresse"
              value={formData.adresse}
              onChange={handleInputChange}
            />
          </Grid>

          {/* Subjects Selection */}
          <Grid item xs={12} sm={4}>
            <FormControl fullWidth>
              <InputLabel>Matieres</InputLabel>
              <Select
                multiple
                name="subjects"
                value={formData.subjects}
                onChange={handleSubjectsChange}
                renderValue={(selected) => selected.join(', ')}
              >
                {subjects.map((subject) => (
                  <MenuItem key={subject.id} value={subject.id}>
                    <Checkbox checked={formData.subjects.indexOf(subject.id) > -1}/>
                    <ListItemText primary={subject.name}/>
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Grid>

          <Grid item xs={12}>
            <Button type="submit" variant="contained" sx={{ marginRight: 3.5 }}>
              Enregistrer
            </Button>

            <Button type='reset' variant='outlined' color='secondary' onClick={() => setFormData({
              name: '',
              email: '',
              phone: '',
              adresse: '',
              subjects: []
            })}>
              Réinitialiser
            </Button>
          </Grid>
        </Grid>
      </form>
    </CardContent>
  )
}

export default TabSecurity
