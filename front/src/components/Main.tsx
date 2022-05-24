import React, { useEffect, useState } from 'react'
import { Header } from './Header'
import { Body } from './Body'
import { apiServer } from '../api/YoutubeAPIUtils'
import { Video } from '../types/VideoType'
import { Footer } from './Footer'

export const Main: React.FC = () => {
  const [videoList, setVideoList] = useState<Video[]>([])
  const [errorMessage, setErrorMessage] = useState('')

  const getVideoList = (memberName: string): void => {
    const res = apiServer.get(memberName)
    res
      .then((res) => {
        const data: Video[] = res.data
        if (!data.length) {
          setErrorMessage('動画が見つかりませんでした。')
        } else {
          setVideoList(res.data)
          setErrorMessage('')
        }
      })
      .catch((err) => {
        console.error(err)
        setErrorMessage('動画が見つかりませんでした。')
      })
  }

  const videoListHandle = (memberName: string) => {
    getVideoList(memberName)
  }

  useEffect(() => {
    getVideoList('乃木坂46')
  }, [])

  return (
    <div className="container m-auto flex flex-col min-h-screen">
      <Header videoListHandle={videoListHandle} />
      <Body videoList={videoList} errorMessage={errorMessage} />
      <Footer />
    </div>
  )
}
