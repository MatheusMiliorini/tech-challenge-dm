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
              Receitas Delivery Much
            </q-toolbar-title>
          </q-toolbar>
        </q-header>

        <q-page-container>
          <router-view />
        </q-page-container>

        </q-layout>
      </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@1.15.4/dist/quasar.umd.modern.min.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>
