import React from 'react'
import { Video } from '../types/VideoType'

export const Body: React.FC<{ videoList: Video[]; message: string }> = ({
  videoList,
  message,
}) => {
  const baseUrl = process.env.REACT_APP_YOUTUBE_BASE_URL

  return (
    <div className="flex justify-center flex-col w-full border-opacity-50 m-auto my-10 p-4">
      {message === ''
        ? videoList.map((video) => {
            return (
              // <div
              //   key={video.video_id}
              //   className="flex items-center flex-col container p-7">
              //   <img
              //     src={video.thumbnail_url}
              //     alt="thumbnail"
              //     className="max-w-xs"
              //   />
              //   <h3>{video.title}</h3>
              // </div>
              <div
                className="card bg-base-700 shadow-xl m-auto items-center my-2 "
                key={video.video_id}>
                <figure>
                  <img src={video.thumbnail_url} alt="thumbnail" />
                </figure>
                <div className="card-body">
                  {/* <h2 className="card-title">Shoes!</h2> */}
                  <p>{video.title}</p>
                  <div className="card-actions justify-end"></div>
                </div>
              </div>
            )
          })
        : message}
    </div>
  )
}
