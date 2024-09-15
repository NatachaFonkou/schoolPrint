import React, { createContext, useState, useEffect } from 'react';
import api from "../configs/apiConfig";

export const OptionsContext = createContext();

export const OptionsProvider = ({ children }) => {
  const [options, setOptions] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchOptions = async () => {
      try {
        const response = await api.get('/options'); // Endpoint pour récupérer les options
        setOptions(response.data)
        console.log(response.data) // Ajuste selon la structure de la réponse
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchOptions();
  }, []);

  return (
    <OptionsContext.Provider value={{ options, loading, error }}>
      {children}
    </OptionsContext.Provider>
  );
};
