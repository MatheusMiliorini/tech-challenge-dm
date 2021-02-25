/* eslint-disable no-new */
/* eslint-disable no-undef */

import './bootstrap'
import axios from 'axios'
import ingredients from './ingredients'

// Components
import Recipe from './components/Recipe'

new Vue({
  el: '#app',
  components: {
    Recipe
  },
  created () {
    this.fillIngredients()
  },
  data: () => {
    return {
      ingredients: [],
      selectedIngredients: [],
      page: 1,
      recipes: [],
      noRecipesText: 'Search for recipes on the left!'
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
      this.noRecipesText = 'Searching...'

      const { recipes, error } = await axios.get(`${window.APP_URL}/recipes`, {
        params: {
          i: this.selectedIngredients.join(','),
          p: this.page
        }
      })
      if (error) {
        this.$q.notify({
          message: error,
          icon: 'error',
          color: 'negative',
          closeBtn: 'OK'
        })
      } else {
        this.recipes = recipes || []
        // Muda o texto de nenhuma receita após a primeira busca
        this.noRecipesText = 'No recipes found :( try other ingredients!'
      }
    }
  }
})
