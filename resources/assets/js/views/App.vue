<template>
   <div id="Appbar">
      <v-toolbar fixed style="z-index: 15;" dark class="grey darken-4">
         <div class="hidden-md-and-up">
            <v-menu bottom left>
               <template v-slot:activator="{ on }">
                  <v-btn dark icon v-on="on">
                     <v-icon>more_vert</v-icon>
                  </v-btn>
               </template>

               <v-list>
                  <v-list-tile v-for="(item, i) in items" :key="i" @click="route(item.ruta)">
                     <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile>
               </v-list>
            </v-menu>
         </div>
         <v-list-tile avatar @click="route('/')">
            <v-list-tile-avatar>
               <img src="../../img/logo.png">
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
            @click="route(item.ruta)"
         >
            <v-btn flat>{{ item.title }}</v-btn>
         </v-toolbar-items>
      </v-toolbar>
   </div>
</template>

<script>
export default {
   data() {
      return {};
   },
   methods: {
      route(ruta) {
         if (ruta === "/logout") {
            document.getElementById("logout-form").submit();
         } else location.href = ruta;
      }
   },
   computed: {
      items() {
         if (this.login === "true") {
            return [
               { title: "Administración", ruta: "/admin" },
               { title: "Home", ruta: "/home" },
               { title: this.name, ruta: "#" },
               { title: "Cerrar Sessión", ruta: "/logout" }
            ];
         }
         return [
            { title: "Home", ruta: "/" },
            { title: "Registrarse", ruta: "/register" },
            { title: "Ingresar", ruta: "/login" }
         ];
      }
   },
   props: ["login", "name"]
};
</script>

<style scoped lang="css">
a {
   margin-left: 0.5em;
   margin-right: 0.5em;
   color: white;
}
#Appbar {
   font-family: "Roboto", sans-serif;
}
</style>