<template>
  <div id="app">
    <v-toolbar fixed style="z-index: 15;" dark class="grey darken-4">
      <div class="hidden-md-and-up">
        <v-menu bottom left>
          <template v-slot:activator="{ on }">
            <v-btn dark icon v-on="on">
              <v-icon>more_vert</v-icon>
            </v-btn>
          </template>

          <v-list>
            <v-list-tile v-for="(item, i) in items" :key="i" @click="$router.push(item.ruta)">
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
      </div>
      <v-list-tile avatar @click="$router.push('/')">
        <v-list-tile-avatar>
          <img src="@/assets/img/logo.png">
        </v-list-tile-avatar>

        <v-list-tile-content>
          <v-list-tile-title class="font-weight-medium font-italic">Campus Granadilla</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-spacer></v-spacer>
      <v-toolbar-items
        dark
        class="hidden-sm-and-down"
        v-for="(item, i) in items"
        :key="i"
        @click="$router.push(item.ruta)"
      >
        <v-btn flat>{{ item.title }}</v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-app>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-app>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { title: "Home", ruta: "/" },
        { title: "Registarce", ruta: "/registerestudents" },
        { title: "Ingresar", ruta: "/login" }
      ]
    };
  }
};
</script>

<style lang="css">
@import url("https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons");
</style>

<style scoped lang="css">
a {
  margin-left: 0.5em;
  margin-right: 0.5em;
  color: white;
}
#app {
  font-family: "Roboto", sans-serif;
}
</style>