import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const createPost = post => http.post('/posts', post).then(getData);
export const getPost = slug => http.get('/posts/'+slug).then(getData);
