import React, { useEffect, useState } from 'react'
import { apiServer } from '../api/YoutubeAPIUtils'

type Video = {
  title: string
  thumbnail_url: string
  video_id: string
}

const getVideoList = async (memberName: string) => {
  const res = await apiServer.get(memberName)
  return res
}

export const Main: React.FC = () => {
  const baseUrl = 'https://www.youtube.com/watch?v='
  const [videoList, setVideoList] = useState<Video[]>([])
  const [message, setMessage] = useState('')

  useEffect(() => {
    const res = getVideoList('賀喜遥香')
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
                <a href={baseUrl + video.video_id}>
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
