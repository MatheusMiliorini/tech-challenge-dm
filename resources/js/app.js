/* eslint-disable no-new */
/* eslint-disable no-undef */

// import './bootstrap'
import axios from 'axios'
import ingredients from './ingredients'

new Vue({
  el: '#app',
  created () {
    this.fillIngredients()
  },
  data: () => {
    return {
      ingredients: [],
      selectedIngredients: [],
      page: 1,
      recipes: []
    }
  },
  methods: {
    fillIngredients () {
      this.ingredients = ingredients
    },
    filterIngredients (val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.ingredients = ingredients.filter(v => v.toLowerCase().indexOf(needle) > -1)
      })
    },
    /**
     * Faz a chamada da API para buscar as receitas
     */
    async searchRecipes () {
      const { data } = await axios.get(`${window.APP_URL}/recipes`, {
        params: {
          i: this.selectedIngredients.join(','),
          p: this.page
        }
      })
      const { recipes } = data
      this.recipes = recipes || []
      console.log(this.recipes)
    }
  }
})
