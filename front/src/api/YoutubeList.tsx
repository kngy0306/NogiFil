// 後にYoutubeList.tsにし、apiだけ取得するファイルに変更する

import React, { useEffect, useState } from 'react'

type Video = {
  title: string
  thumbnail_url: string
  video_id: string
  published_at: string
}

export const YoutubeList: React.FC = () => {
  const [videoList, setVideoList] = useState<Video[]>([])
  const [message, setMessage] = useState('')
  const baseUrl = 'https://www.youtube.com/watch?v='

  useEffect(() => {
    getVideoList()
  }, [])

  const getVideoList = async () => {
    const response = await fetch('http://localhost/api/video')
    if (!response.ok) {
      setMessage('動画が取得できませんでした。')
    }

    const data: Video[] = await response.json()
    setVideoList(data)
  }

  if (message !== '') {
    return <div>{message}</div>
  }

  return (
    <div>
      {videoList.map((video) => {
        return (
          <div key={video.video_id}>
            <a href={baseUrl + video.video_id}>
              <h3>{video.title}</h3>
              <img src={video.thumbnail_url} alt="thumbnail" width="50%" />
              <p>{video.published_at}</p>
            </a>
          </div>
        )
      })}
    </div>
  )
}
