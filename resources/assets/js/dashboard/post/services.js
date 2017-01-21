import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const getPosts = () => http.get('/dashboard/posts').then(getData)
