import React, { useState } from 'react'
import { memberList } from '../memberList/member'

export const Header: React.FC<{
  videoListHandle: (memberName: string) => void
  themeHandle: (theme: boolean) => void
}> = ({ videoListHandle, themeHandle }) => {
  const [value, setValue] = useState('default')
  const [lightTheme, setLightTheme] = useState(true)

  const selectMember = (event: React.ChangeEvent<HTMLSelectElement>) => {
    const memberName = event.target.value
    setValue(memberName)
    videoListHandle(memberName)
  }

  const changeTheme = () => {
    const theme = !lightTheme
    themeHandle(theme)
    setLightTheme(theme)
  }

  return (
    <div>
      <div className="navbar bg-base-100">
        <div className="flex-1">
          <p className="pl-3 font-bold normal-case text-xl text-purple-500">
            NOGI FIL
          </p>
        </div>
        <div className="flex-none">
          <button className="btn btn-square btn-ghost" onClick={changeTheme}>
            {lightTheme ? '☀️' : '🌔'}
          </button>
        </div>
      </div>

      <div className="flex justify-center flex-col">
        <div className="m-auto mb-3 my-5 p-5">
          「
          <a
            href="https://www.youtube.com/c/nogizakahaishinchu/videos"
            className="text-purple-600">
            乃木坂配信中
          </a>
          」のチャンネルで公開されている動画から、推しメンを選択してフィルタリングします。
        </div>
        <select
          className="select select-primary w-full max-w-xs m-auto my-5"
          onChange={selectMember}
          value={value}>
          <option disabled value="default">
            メンバーを選択してください
          </option>
          {memberList.map((member) => {
            return (
              <option value={member} key={member}>
                {member}
              </option>
            )
          })}
        </select>
      </div>
    </div>
  )
}
