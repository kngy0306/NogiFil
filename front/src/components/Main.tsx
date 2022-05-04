import React, { useEffect, useState } from 'react'
import { Header } from './Header'
import { Body } from './Body'
import { apiServer } from '../api/YoutubeAPIUtils'
import { Video } from '../types/VideoType'
import { Footer } from './Footer'

export const Main: React.FC = () => {
  const [videoList, setVideoList] = useState<Video[]>([])
  const [message, setMessage] = useState('')

  const videoListHandle = (memberName: string) => {
    getVideoList(memberName)
  }

  const getVideoList = (memberName: string): void => {
    const res = apiServer.get(memberName)
    res
      .then((res) => {
        setVideoList(res.data)
        setMessage('')
      })
      .catch((err) => {
        console.error(err)
        setMessage('動画が見つかりませんでした。')
      })
  }

  useEffect(() => {
    getVideoList('賀喜遥香')
  }, [])

  return (
    <div className="container">
      <Header videoListHandle={videoListHandle} />
      <Body videoList={videoList} message={message} />
      <Footer />
    </div>
  )
}
