import React, { useState } from 'react'
import { Main } from '../components/Main'
import { ContextType } from '../types/ContextType'

export const ThemeContext = React.createContext({} as ContextType)

export const Index: React.FC = () => {
  const [lightTheme, setLightTheme] = useState(true)

  return (
    <ThemeContext.Provider value={{ lightTheme, setLightTheme }}>
      <div data-theme={lightTheme ? 'light' : 'dark'} className="min-h-screen">
        <Main />
      </div>
    </ThemeContext.Provider>
  )
}
