import React, { useCallback, useContext, useState } from 'react'
import { memberList } from '../memberList/member'
import { ThemeContext } from '../pages/Index'

export const Header: React.FC<{
  videoListHandle: (memberName: string) => void
}> = ({ videoListHandle }) => {
  const [value, setValue] = useState('default')
  const { lightTheme, setLightTheme } = useContext(ThemeContext)

  const selectMember = (event: React.ChangeEvent<HTMLSelectElement>) => {
    const memberName = event.target.value
    setValue(memberName)
    videoListHandle(memberName)
  }

  const changeTheme = useCallback(() => {
    localStorage.setItem('lightTheme', `${!lightTheme}`)
    const newTheme = !lightTheme
    setLightTheme(newTheme)
  }, [lightTheme, setLightTheme])

  return (
    <div>
      <div className="navbar bg-base-100">
        <div className="flex-1">
          <a
            href="/"
            className="pl-3 font-bold normal-case text-xl text-purple-500 hover:text-purple-600">
            NOGI FIL
          </a>
        </div>
        <div className="flex-none">
          <button className="btn btn-square btn-ghost" onClick={changeTheme}>
            {lightTheme ? 'âï¸' : 'ð'}
          </button>
        </div>
      </div>

      <div className="flex justify-center flex-col">
        <div className="m-auto mb-3 my-5 p-5">
          ã
          <a
            href="https://www.youtube.com/c/nogizakahaishinchu/videos"
            className="text-purple-500 hover:text-purple-600"
            target="_blank"
            rel="noopener noreferrer">
            ä¹æ¨åéä¿¡ä¸­
          </a>
          ãã®ãã£ã³ãã«ã§å¬éããã¦ããåç»ããã¡ã³ãã¼ãé¸æãã¦æ¤ç´¢ãã¾ãã
          <br />
          â»åç»ãã¿ããããã¨YouTubeã¸ç§»åãã¾ãã
        </div>
        <select
          className="select select-primary w-full max-w-xs m-auto my-5"
          onChange={selectMember}
          value={value}>
          <option disabled value="default">
            ã¡ã³ãã¼ãé¸æãã¦ãã ãã
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
