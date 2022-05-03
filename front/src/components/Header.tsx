import { useState } from 'react'

export const Header = () => {
  const memberList = ['賀喜遥香', '秋元真夏']
  const [query, setQuery] = useState('')

  return (
    <>
      <button className="btn btn-success">Success</button>
      <div className="font-bold">Header</div>
    </>
  )
}
