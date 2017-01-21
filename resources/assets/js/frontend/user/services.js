import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const getUserByUsername = username => http.get('/users/'+username).then(getData);

export const getUserPosts = user => http.get('/posts', {user: user.id}).then(getData);
