import React, { useEffect, useState } from 'react'
import { apiServer } from '../api/YoutubeAPIUtils'
import { Video } from '../types/VideoType'

const getVideoList = async (memberName: string) => {
  const res = await apiServer.get(memberName)
  return res
}

export const Main: React.FC = () => {
  const baseUrl = process.env.REACT_APP_YOUTUBE_BASE_URL
  const [videoList, setVideoList] = useState<Video[]>([])
  const [message, setMessage] = useState('')

  useEffect(() => {
    const res = getVideoList('秋元真夏')
    res
      .then((Obj) => {
        console.log(Obj.data)
        setVideoList(Obj.data)
      })
      .catch((err) => {
        console.error(err)
        setMessage('動画が見つかりませんでした。')
      })
  }, [])

  return (
    <div>
      {message === ''
        ? videoList.map((video) => {
            return (
              <div key={video.video_id}>
                <a
                  href={baseUrl + video.video_id}
                  target="_blank"
                  rel="noopener noreferrer">
                  <h3>{video.title}</h3>
                  <img src={video.thumbnail_url} alt="thumbnail" width="50%" />
                </a>
              </div>
            )
          })
        : message}
    </div>
  )
}
