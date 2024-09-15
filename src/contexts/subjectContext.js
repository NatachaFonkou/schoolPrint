import React, { createContext, useState, useEffect } from 'react';
import axios from 'axios';
import api from "../configs/apiConfig";

// Create the context
export const SubjectsContext = createContext();

// Create a provider component
export const SubjectsProvider = ({ children }) => {
  const [subjects, setSubjects] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    // Fetch the subjects from the API
    const fetchSubjects = async () => {
      try {
        const response = await api.get('/subjects');
        setSubjects(response.data);
        console.log(response.data)
        setLoading(false);
      } catch (err) {
        setError(err);
        setLoading(false);
      }
    };

    fetchSubjects();
  }, []);

  return (
    <SubjectsContext.Provider value={{ subjects, loading, error }}>
      {children}
    </SubjectsContext.Provider>
  );
};
