import React, { createContext, useState, useEffect } from 'react';
import api from "../configs/apiConfig";

export const PromotionsContext = createContext();

export const PromotionsProvider = ({ children }) => {
  const [promotions, setPromotions] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchPromotions = async () => {
      try {
        const response = await api.get('/promotions'); // Endpoint pour récupérer les promotions
        setPromotions(response.data); // Ajuste selon la structure de la réponse
        console.log(response.data)// Ajuste selon la structure de la réponse
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchPromotions();
  }, []);

  return (
    <PromotionsContext.Provider value={{ promotions, loading, error }}>
      {children}
    </PromotionsContext.Provider>
  );
};
