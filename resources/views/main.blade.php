<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Avaliação Tecnica Delivery Much</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@1.15.4/dist/quasar.min.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <div id="app">
      <template>
        <q-layout view="hHh lpR fFf">

          <q-header elevated class="bg-primary text-white">
            <q-toolbar>
              <q-toolbar-title style="display: flex; align-items: center">
                <img src="/img/logo_delivery_much.png" height="40px" style="margin-right: 15px">
                Delivery Much Recipes
              </q-toolbar-title>
            </q-toolbar>
          </q-header>

          <q-page-container>
            <div class="row q-col-gutter-md q-mt-md q-px-md">
              <!-- Busca -->
              <div class="col-12 col-md-4">
                <q-select
                  filled
                  v-model="selectedIngredients"
                  multiple
                  :options="ingredients"
                  label="Ingredients 👩‍🍳"
                  class="full-width"
                  counter
                  :max-values="3"
                  hint="Select up to three ingredients!"
                  use-input
                  fill-input
                  @filter="filterIngredients"
                  :debounce="0"
                ></q-select>

                <q-select
                  filled
                  v-model="page"
                  :options="[1, 2, 3, 4, 5, 6, 7, 8 , 9, 10]"
                  label="Page"
                  class="full-width q-mt-lg"
                ></q-select>

                <q-btn
                  :disable="selectedIngredients.length === 0"
                  label="Search! 🔍"
                  class="full-width q-mt-lg"
                  color="primary"
                  @click="searchRecipes"
                  :title="selectedIngredients.length === 0 ? 'You must select at least one ingredient' : ''"
                ></q-btn>
              </div>

              <!-- Listagem, aparece apenas em desktop -->
              <div v-if="!$q.platform.is.mobile" class="col-md-8">
                <q-list class="recipe-list" v-if="recipes.length > 0">
                  <q-item v-for="(recipe, i) in recipes" :key="i">
                    <recipe :recipe="recipe"></recipe>
                  </q-item>
                </q-list>
                <div v-else class="no-results text-grey-6">
                  <q-icon name="search"></q-icon>
                  <span>@{{ noRecipesText }}</span>
                </div>
              </div>
            </div>

            <!-- Dialog com visualização em mobile -->
            <q-dialog v-if="$q.platform.is.mobile" v-model="recipesDialog">
              <q-card>
                <q-card-section class="row items-center q-pb-none">
                  <q-btn icon="close" flat round dense v-close-popup />
                </q-card-section>

                <q-separator></q-separator>

                <q-card-section style="max-height: 75vh" class="scroll">
                  <q-list class="recipe-list" v-if="recipes.length > 0">
                    <q-item v-for="(recipe, i) in recipes" :key="i">
                      <recipe :recipe="recipe"></recipe>
                    </q-item>
                  </q-list>
                </q-card-section>
              </q-card>
            </q-dialog>
          </q-page-container>

        </q-layout>
      </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@1.15.4/dist/quasar.umd.modern.min.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>
