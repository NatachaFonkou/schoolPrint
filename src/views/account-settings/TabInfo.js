// ** React Imports
import {forwardRef, useContext, useState} from 'react'

// ** MUI Imports
import Grid from '@mui/material/Grid'
import Radio from '@mui/material/Radio'
import Select from '@mui/material/Select'
import Button from '@mui/material/Button'
import MenuItem from '@mui/material/MenuItem'
import TextField from '@mui/material/TextField'
import FormLabel from '@mui/material/FormLabel'
import InputLabel from '@mui/material/InputLabel'
import RadioGroup from '@mui/material/RadioGroup'
import CardContent from '@mui/material/CardContent'
import FormControl from '@mui/material/FormControl'
import OutlinedInput from '@mui/material/OutlinedInput'
import FormControlLabel from '@mui/material/FormControlLabel'

// ** Third Party Imports
import DatePicker from 'react-datepicker'
import Checkbox from "@mui/material/Checkbox";
import {SubjectsContext} from "../../contexts/subjectContext";
import {OptionsContext} from "../../contexts/optionContext";



const TabInfo = () => {
  const { subjects, loading: subjectsLoading, error: subjectsError } = useContext(SubjectsContext);
  const { options, loading: optionsLoading, error: optionsError } = useContext(OptionsContext);

  const [formData, setFormData] = useState({
    name: '',
    code: '',
    option_id: '',
    subjects: [],
    includeSubjects: false // To control the visibility of subjects
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleCheckboxChange = (subjectId) => {
    const selectedSubjects = formData.subjects.includes(subjectId)
      ? formData.subjects.filter(id => id !== subjectId)
      : [...formData.subjects, subjectId];
    setFormData({ ...formData, subjects: selectedSubjects });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      // Send formData to the backend
      console.log('Form data to submit:', formData);
    } catch (error) {
      console.error('Error submitting the form:', error);
    }
  };

  if (subjectsLoading) {
    return <div>Loading subjects...</div>;
  }
  if (optionsLoading) {
    return <div>Loading...</div>; // Gestion du chargement
  }

  if (subjectsError || optionsError) {
    return <div>Error occurred...</div>; // Gestion des erreurs
  }

  return (
    <CardContent>
      <form onSubmit={handleSubmit}>
        <Grid container spacing={7}>

          <Grid item xs={12} sm={4}>
            <TextField
              label="Code de la classe"
              name="code"
              value={formData.code}
              onChange={handleInputChange}
              fullWidth
            />
          </Grid>
          <Grid item xs={12} sm={4}>
            <TextField
              label="Nom de la classe"
              name="name"
              value={formData.name}
              onChange={handleInputChange}
              fullWidth
            />
          </Grid>

          <Grid item xs={12} sm={4}>
            <FormControl fullWidth>
              <InputLabel>Option</InputLabel>
              <Select
                label='Option'
                name='option_id'
                value={formData.option_id}
                onChange={handleInputChange}
              >
                {options.map(option => (
                  <MenuItem key={option.id} value={option.id}>
                    {option.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Grid>
          <Grid item xs={12} sm={4}>
            <FormControlLabel
              control={
                <Checkbox
                  checked={formData.includeSubjects}
                  onChange={() => setFormData({...formData, includeSubjects: !formData.includeSubjects})}
                />
              }
              label="Inclure les matieres"
            />
          </Grid>
          <Grid item xs={12} sm={12}>
          {formData.includeSubjects && subjects && (
            <div>
              <h3>Selectionner les matieres de la classe:</h3>
              {subjects.map(subject => (
                <FormControlLabel
                  key={subject.id}
                  control={
                    <Checkbox
                      checked={formData.subjects.includes(subject.id)}
                      onChange={() => handleCheckboxChange(subject.id)}
                    />
                  }
                  label={subject.name}
                />
              ))}
            </div>
          )}
          </Grid>


          <Grid item xs={12}>
            <Button type="submit" variant="contained">
              Enregistrer
            </Button>
          </Grid>

        </Grid>
      </form>
    </CardContent>
  )
}

export default TabInfo
