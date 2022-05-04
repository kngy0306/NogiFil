import { useState } from 'react'

export const Header: React.FC<{
  videoListHandle: (memberName: string) => void
}> = ({ videoListHandle }) => {
  const memberList = ['賀喜遥香', '秋元真夏']
  const [value, setValue] = useState('default')

  const selectMember = (event: React.ChangeEvent<HTMLSelectElement>) => {
    const memberName = event.target.value
    setValue(memberName)
    videoListHandle(memberName)
  }

  return (
    <div>
      <div className="navbar bg-base-100">
        <div className="flex-1">
          <a className="btn btn-ghost normal-case text-xl text-purple-500">
            NOGI FIL
          </a>
        </div>
        <div className="flex-none">
          <button className="btn btn-square btn-ghost">🌔</button>
        </div>
      </div>

      <div className="flex justify-center">
        <select
          className="select select-primary w-full max-w-xs"
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
