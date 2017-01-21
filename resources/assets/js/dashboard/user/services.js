import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const getUsers = () => http.get('/dashboard/users').then(getData);
