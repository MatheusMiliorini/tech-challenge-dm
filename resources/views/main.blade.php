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
            <div class="col-md-4">
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
                clearable
                @filter="filterIngredients"
                :debounce="0"
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
          </div>
        </q-page-container>

        </q-layout>
      </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@1.15.4/dist/quasar.umd.modern.min.js"></script>

    {{-- Constantes auxiliares --}}
    <script>
      window.APP_URL = '{{ config('app.url') }}'
    </script>

    <script src="/js/app.js"></script>
  </body>
</html>
