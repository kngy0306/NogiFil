import React from 'react'
import { Header } from '../components/Header'
import { Main } from '../components/Main'

export const Index: React.FC = () => {
  return (
    <>
      <div>Indexページ</div>
      <Header />
      <Main />
      <div>Indexページフッター</div>
    </>
  )
}
