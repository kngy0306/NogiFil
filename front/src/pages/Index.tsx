import React, { useState } from 'react'
import { Main } from '../components/Main'

export const Index: React.FC = () => {
  const [lightTheme, setLightTheme] = useState(true)

  const themeHandle = (theme: boolean) => {
    setLightTheme(theme)
  }

  return (
    <div data-theme={lightTheme ? 'light' : 'dark'} className="min-h-screen">
      <Main themeHandle={themeHandle} />
    </div>
  )
}
