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
      noRecipesText: 'Search for recipes on the left!',
      recipesDialog: false
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
      this.$q.loading.show({
        message: this.noRecipesText
      })

      const { recipes, error } = await axios.get('/recipes', {
        params: {
          i: this.selectedIngredients.join(','),
          p: this.page
        }
      })

      this.$q.loading.hide()

      if (error) {
        this.$q.notify({
          message: error,
          icon: 'error',
          color: 'negative',
          closeBtn: 'OK'
        })
      } else {
        this.recipes = recipes || []
        if (this.recipes.length === 0) {
          // Muda o texto de nenhuma receita após a primeira busca
          this.noRecipesText = 'No recipes found :( try other ingredients!'
          if (this.$q.platform.is.mobile) {
            this.$q.notify({
              message: this.noRecipesText,
              icon: 'warning',
              color: 'warning',
              closeBtn: 'OK'
            })
          }
        } else if (this.$q.platform.is.mobile) {
          this.recipesDialog = true
        }
      }
    }
  }
})
