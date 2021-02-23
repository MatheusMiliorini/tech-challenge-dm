/* eslint-disable no-new */
/* eslint-disable no-undef */

import './bootstrap'
import ingredients from './ingredients'

new Vue({
  el: '#app',
  created () {
    this.fillIngredients()
  },
  data: () => {
    return {
      ingredients: []
    }
  },
  methods: {
    fillIngredients () {
      this.ingredients = ingredients
      // console.log(this.ingredients)
    }
  }
})
