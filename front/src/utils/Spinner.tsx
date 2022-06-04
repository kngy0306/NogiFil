import React from 'react'

export const Spinner = React.memo(() => {
  return (
    <div className="flex justify-center">
      <div className="animate-spin h-10 w-10 border-4 border-purple-500 rounded-full border-t-transparent"></div>
    </div>
  )
})
