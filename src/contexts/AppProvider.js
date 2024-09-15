import React from 'react';
import { PromotionsProvider } from './promotionContext';
import { OptionsProvider } from './optionContext';
import { ClassroomsProvider } from './classroomContext';
import {SubjectsProvider} from "./subjectContext";

const AppProviders = ({ children }) => {
  return (
    <PromotionsProvider>
      <OptionsProvider>
        <ClassroomsProvider>
          <SubjectsProvider>
          {children}
          </SubjectsProvider>
        </ClassroomsProvider>
      </OptionsProvider>
    </PromotionsProvider>
  );
};

export default AppProviders;
