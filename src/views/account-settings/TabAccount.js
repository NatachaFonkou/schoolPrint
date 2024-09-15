// ** React Imports
import {useState, useContext, useEffect} from 'react'

// ** MUI Imports
import Box from '@mui/material/Box'
import Grid from '@mui/material/Grid'
import Link from '@mui/material/Link'
import Alert from '@mui/material/Alert'
import Select from '@mui/material/Select'
import { styled } from '@mui/material/styles'
import MenuItem from '@mui/material/MenuItem'
import TextField from '@mui/material/TextField'
import Typography from '@mui/material/Typography'
import InputLabel from '@mui/material/InputLabel'
import AlertTitle from '@mui/material/AlertTitle'
import IconButton from '@mui/material/IconButton'
import CardContent from '@mui/material/CardContent'
import FormControl from '@mui/material/FormControl'
import Button from '@mui/material/Button'

// ** Icons Imports
import Close from 'mdi-material-ui/Close'
import axios from "axios";
import {ClassroomsContext} from "../../contexts/classroomContext";
import {PromotionsContext} from "../../contexts/promotionContext";
import {OptionsContext} from "../../contexts/optionContext";
import api from "../../configs/apiConfig";

const ImgStyled = styled('img')(({ theme }) => ({
  width: 120,
  height: 120,
  marginRight: theme.spacing(6.25),
  borderRadius: theme.shape.borderRadius
}))

const ButtonStyled = styled(Button)(({ theme }) => ({
  [theme.breakpoints.down('sm')]: {
    width: '100%',
    textAlign: 'center'
  }
}))

const ResetButtonStyled = styled(Button)(({ theme }) => ({
  marginLeft: theme.spacing(4.5),
  [theme.breakpoints.down('sm')]: {
    width: '100%',
    marginLeft: 0,
    textAlign: 'center',
    marginTop: theme.spacing(4)
  }
}))

const TabAccount = () => {
  // ** State
  const [openAlert, setOpenAlert] = useState(true)
  const [imgSrc, setImgSrc] = useState('/images/avatars/1.png')
  const [imageFile, setImageFile] = useState(null)

  const onChange = file => {
    const reader = new FileReader()
    const { files } = file.target
    if (files && files.length !== 0) {
      reader.onload = () => setImgSrc(reader.result)
      reader.readAsDataURL(files[0])
    }
  }
  const { classrooms, loading: classroomsLoading, error: classroomsError } = useContext(ClassroomsContext);
  const { promotions, loading: promotionsLoading, error: promotionsError } = useContext(PromotionsContext);
  const { options, loading: optionsLoading, error: optionsError } = useContext(OptionsContext);

  const [filteredClassrooms, setFilteredClassrooms] = useState([]);


  const [formData, setFormData] = useState({
    name: '',
    surname: '',
    date :'',
    age: '',
    matricule: '',
    promotion_id: '',
    classroom_id: '',
    option_id: ''
  })

  const handleDateChange = (e) => {
    const { value } = e.target
    const dateOfBirth = new Date(value);
    const today = new Date();
    let age = today.getFullYear() - dateOfBirth.getFullYear();
    const monthDifference = today.getMonth() - dateOfBirth.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dateOfBirth.getDate())) {
      age--;
    }
    setFormData({
      ...formData,
      age: age // Stocker l'âge calculé
    });
  }

  useEffect(() => {
    if (formData.option_id) {
      // Filtrer les classes en fonction de la promotion sélectionnée
      const filtered = classrooms.filter(classroom => classroom.option.id === formData.option_id);
      setFilteredClassrooms(filtered);
    }
  }, [formData.option_id]);

  if (classroomsLoading || promotionsLoading || optionsLoading) {
    return <div>Loading...</div>; // Gestion du chargement
  }

  if (classroomsError || promotionsError || optionsError) {
    return <div>Error occurred...</div>; // Gestion des erreurs
  }


  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData({
      ...formData,
      [name]: value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      const newFormData = {
        name: formData.name,
        surname: formData.surname,
        matricule: formData.matricule,
        age: formData.age,
        promotion_id: formData.promotion_id,
        classroom_id: formData.classroom_id,
        option_id: formData.option_id
      }
      const response = await api.post('/students', newFormData)
      const studentId = response.data.id
      console.log('Student saved successfully:', response.data)
      } catch(error) {
      console.error('Error saving Student :', error)
    }
  }


  return (
    <CardContent>
      <form onSubmit={handleSubmit}>
        <Grid container spacing={7}>
          <Grid item xs={12} sx={{ marginTop: 4.8, marginBottom: 3 }}>
            <Box sx={{ display: 'flex', alignItems: 'center' }}>
              <ImgStyled src={imgSrc} alt='Profile Pic' />
              <Box>
                <ButtonStyled component='label' variant='contained' htmlFor='account-settings-upload-image'>
                  Importer la photo
                  <input
                    hidden
                    type='file'
                    onChange={e => {
                      const reader = new FileReader()
                      const { files } = e.target
                      if (files && files.length !== 0) {
                        reader.onload = () => setImgSrc(reader.result)
                        reader.readAsDataURL(files[0])
                      }
                    }}
                    accept='image/png, image/jpeg'
                    id='account-settings-upload-image'
                  />
                </ButtonStyled>
                <ResetButtonStyled color='error' variant='outlined' onClick={() => setImgSrc('/images/avatars/1.png')}>
                  Réinitialiser
                </ResetButtonStyled>
                <Typography variant='body2' sx={{ marginTop: 5 }}>
                  PNG ou JPEG. Taille maximale 800K.
                </Typography>
              </Box>
            </Box>
          </Grid>

          {/* Form Fields */}
          <Grid item xs={12} sm={3}>
            <TextField
              fullWidth
              label='Nom'
              placeholder='Atangana'
              name='name'
              value={formData.name}
              onChange={handleInputChange}
            />
          </Grid>
          <Grid item xs={12} sm={3}>
            <TextField
              fullWidth
              label='Prénom'
              placeholder='Dieudonné'
              name='surname'
              value={formData.surname}
              onChange={handleInputChange}
            />
          </Grid>
          <Grid item xs={12} sm={3}>
            <TextField
              fullWidth
              type='date'
              label='Date de naissance'
              name='age'
              value={formData.date} // Utiliser l'âge calculé
              onChange={handleDateChange} // Utiliser la fonction handleDateChange
            />
          </Grid>
          <Grid item xs={12} sm={3}>
            <TextField
              fullWidth
              label='Matricule'
              placeholder='54716177NG'
              name='matricule'
              value={formData.matricule}
              onChange={handleInputChange}
            />
          </Grid>

          {/* Dropdowns from context */}
          <Grid item xs={12} sm={4}>
            <FormControl fullWidth>
              <InputLabel>Promotion</InputLabel>
              <Select
                label='Promotion'
                name='promotion_id'
                value={formData.promotion_id}
                onChange={handleInputChange}
              >
                {promotions.map(promotion => (
                  <MenuItem key={promotion.id} value={promotion.id}>
                    {promotion.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
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
            <FormControl fullWidth>
              <InputLabel>Classe</InputLabel>
              <Select
                label='Classe'
                name='classroom_id'
                value={formData.classroom_id}
                onChange={handleInputChange}
              >
                {filteredClassrooms.map(classroom => (
                  <MenuItem key={classroom.id} value={classroom.id}>
                    {classroom.name}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>
          </Grid>

          <Grid item xs={12}>
            <Button type='submit' variant='contained' sx={{ marginRight: 3.5 }}>
              Enregistrer
            </Button>
            <Button type='reset' variant='outlined' color='secondary' onClick={() => setFormData({
              name: '',
              surname: '',
              age: '',
              matricule: '',
              promotion_id: '',
              classroom_id: '',
              option_id: ''
            })}>
              Réinitialiser
            </Button>
          </Grid>
        </Grid>
      </form>
    </CardContent>
  )
}

export default TabAccount
