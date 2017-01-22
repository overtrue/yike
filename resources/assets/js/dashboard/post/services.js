import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const getPosts = (number, page) => http.get('/dashboard/posts/' + number + '?page=' + page).then(getData)
