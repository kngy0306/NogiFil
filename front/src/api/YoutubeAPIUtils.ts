import axios from 'axios'

export const apiServer = axios.create({
  baseURL: process.env.REACT_APP_API_ENDPOINT,
  responseType: 'json',
  headers: {
    'Content-Type': 'application/json',
  },
})
