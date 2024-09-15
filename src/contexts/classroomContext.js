import React, { createContext, useState, useEffect } from 'react';
import api from "../configs/apiConfig";

export const ClassroomsContext = createContext();

export const ClassroomsProvider = ({ children }) => {
  const [classrooms, setClassrooms] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchClassrooms = async () => {
      try {
        const response = await api.get('/classrooms'); // Endpoint pour récupérer les classes
        setClassrooms(response.data);
        console.log(response.data)// Ajuste selon la structure de la réponse
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchClassrooms();
  }, []);

  return (
    <ClassroomsContext.Provider value={{ classrooms, loading, error }}>
      {children}
    </ClassroomsContext.Provider>
  );
};
