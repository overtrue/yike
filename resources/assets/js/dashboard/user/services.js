import { http } from 'plugins/http'
import { getData } from 'utils/get'

export const getUsers = (number, page) => http.get('/dashboard/users/' + number + '?page=' + page).then(getData);
