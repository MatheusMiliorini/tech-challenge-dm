<template>
  <q-card class="recipe-card full-width">
    <q-card-section>
      <img class="recipe-gif" :src="recipe.gif" height="100px" width="100px" />
      <div class="recipe-text-wrapper">
        <div class="recipe-title text-grey-10">{{ recipe.title }}</div>
        <div class="recipe-ingredients text-grey-8"><span>Ingredients:</span> {{ recipe.ingredients.join(', ') }}.</div>
        <div class="recipe-btn">
          <q-btn
            type="a"
            :href="recipe.link"
            target="_blank"
            color="primary"
            label="See this recipe online"
          >
          </q-btn>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
export default {
  name: 'Recipe',
  props: {
    recipe: { type: Object, required: true }
  }
}
</script>
