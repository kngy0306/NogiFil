import React from 'react'
import { Video } from '../types/VideoType'

export const Body: React.FC<{ videoList: Video[]; message: string }> = ({
  videoList,
  message,
}) => {
  const baseUrl = process.env.REACT_APP_YOUTUBE_BASE_URL

  const videoHandle = (e: React.MouseEvent<HTMLElement>) => {
    const url = e.currentTarget.getAttribute('id')
    if (url !== null) {
      window.open(baseUrl + url, '_blank')
    }
  }

  return (
    <div className="flex justify-center flex-col w-full border-opacity-50 m-auto my-10 p-4">
      {message === ''
        ? videoList.map((video) => {
            return (
              <div
                className="card bg-base-700 shadow-xl m-auto items-center my-2"
                id={video.video_id}
                key={video.video_id}
                onClick={videoHandle}>
                <figure>
                  <img src={video.thumbnail_url} alt="thumbnail" />
                </figure>
                <div className="p-5 sm:w-card">
                  <strong>{video.title}</strong>
                </div>
              </div>
            )
          })
        : message}
    </div>
  )
}
