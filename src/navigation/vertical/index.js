// ** Icon imports
import Login from 'mdi-material-ui/Login'
import Table from 'mdi-material-ui/Table'
import CubeOutline from 'mdi-material-ui/CubeOutline'
import HomeOutline from 'mdi-material-ui/HomeOutline'
import FormatLetterCase from 'mdi-material-ui/FormatLetterCase'
import AccountCogOutline from 'mdi-material-ui/AccountCogOutline'
import CreditCardOutline from 'mdi-material-ui/CreditCardOutline'
import AccountPlusOutline from 'mdi-material-ui/AccountPlusOutline'
import AlertCircleOutline from 'mdi-material-ui/AlertCircleOutline'
import GoogleCirclesExtended from 'mdi-material-ui/GoogleCirclesExtended'

const navigation = () => {
  return [
    {
      title: 'Tableau de Bord',
      icon: HomeOutline,
      path: '/'
    },
    {
      title: 'Enregistrer Ressources',
      icon: AccountCogOutline,
      path: '/setup-driver'
    },
    {
      sectionTitle: 'Gestion des evaluations'
    },
    {
      title: 'Evaluation',
      icon: Login,
      path: '/trip/planified-trip'
    },
    {
      title: 'Créer une evaluation',
      icon: AccountPlusOutline,
      path: '/trip/planified-trip/create-trip'
    },
    {
      title: 'Notes Evaluations',
      icon: AlertCircleOutline,
      path: '/trip/unplanified-trip'
    },
    {
      sectionTitle: 'Gestion des ressources'
    },
  ]
}

export default navigation
