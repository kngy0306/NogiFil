import React from 'react'
import ReactDOM from 'react-dom/client'
import './index.css'
import App from './App'
import reportWebVitals from './reportWebVitals'
import { Helmet, HelmetProvider } from 'react-helmet-async'

const root = ReactDOM.createRoot(document.getElementById('root') as HTMLElement)
root.render(
  <React.StrictMode>
    <HelmetProvider>
      <Helmet>
        <title>NogiFil</title>
        <meta property="og:title" content="NogiFil" />
        <meta
          property="og:description"
          content="「乃木坂配信中」の動画を推しメンでフィルダリングするサービス"
        />
        <meta property="og:url" content="https://nogi-fil.vercel.app/" />
        <meta
          property="og:image"
          content="https://nogi-fil.vercel.app/NogiFil_image.png"
        />
        <meta property="og:type" content="website" />
        <meta name="twitter:site" content="@YoKaU2" />
        <meta
          name="twitter:image"
          content="https://nogi-fil.vercel.app/NogiFil_image.png"
        />
        <meta name="twitter:card" content="summary_large_image" />
      </Helmet>
    </HelmetProvider>
    <App />
  </React.StrictMode>
)

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals()
