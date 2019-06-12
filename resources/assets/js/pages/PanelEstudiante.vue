<template>
   <v-layout row fill-height>
      <template>
         <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            hide-overlay
            stateless
            fill-height
         >
            <v-toolbar flat class="transparent">
               <v-toolbar-side-icon @click.stop="mini = !mini"></v-toolbar-side-icon>
               <v-toolbar-title style="text-transform:capitalize;">{{this.name}}</v-toolbar-title>
            </v-toolbar>

            <v-list class="pt-0" dense>
               <v-divider></v-divider>
               <v-list-tile
                  v-for="item in items"
                  :key="item.title"
                  @click="$router.push(item.ruta)"
               >
                  <v-list-tile-action>
                     <v-icon>{{ item.icon }}</v-icon>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
               </v-list-tile>
            </v-list>
         </v-navigation-drawer>
      </template>
      <v-flex>
         <transition name="component-fade" mode="out-in">
            <router-view></router-view>
         </transition>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["name"],
   data: () => ({
      drawer: true,
      items: [
         {
            title: "Noticias",
            icon: "notifications",
            ruta: "pnoticias"
         },
         {
            title: "Notas",
            icon: "spellcheck",
            ruta: "pnotas"
         },
         {
            title: "Promedios",
            icon: "trending_up",
            ruta: "ppromedios"
         },
         {
            title: "Tareas o Pruebas",
            icon: "local_parking",
            ruta: "ptareas"
         }
      ],
      mini: true,
      right: null,
      curso: [],
      estudiantes: []
   })
};
</script>

<style scoped>
.component-fade-enter-active,
.component-fade-leave-active {
   transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active below version 2.1.8 */ {
   opacity: 0;
}
.component-fade-leave-active {
   animation: bounce-in 0.5s reverse;
}
.component-fade-enter {
   animation: bounce-in 0.5s;
}
@keyframes bounce-in {
   0% {
      transform: scale(0);
   }
   50% {
      transform: scale(1.2);
   }
   100% {
      transform: scale(1);
   }
}
</style>
