/**
 * Configura as libs necessárias
 */

import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Garante que todas as requests serão retornadas da mesma forma, mesmo que haja um erro
 */
axios.interceptors.response.use(response => {
  return response.data
}, error => {
  return error.response.data
})
