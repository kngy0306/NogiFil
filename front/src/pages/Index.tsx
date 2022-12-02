import React, { useEffect, useState } from 'react'
import { Main } from '../components/Main'
import { ContextType } from '../types/ContextType'

export const ThemeContext = React.createContext({} as ContextType)

export const Index: React.FC = () => {
  const [lightTheme, setLightTheme] = useState(true)

  useEffect(() => {
    if (localStorage.getItem('lightTheme') === 'false') {
      setLightTheme(false)
    }
  }, [])

  return (
    <ThemeContext.Provider value={{ lightTheme, setLightTheme }}>
      <div data-theme={lightTheme ? 'light' : 'dark'} className="min-h-screen">
        {/* <Main /> */}
        APIサーバー以降中のため現在使用できません🙇
      </div>
    </ThemeContext.Provider>
  )
}
