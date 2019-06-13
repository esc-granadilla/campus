<template>
   <div class="text-xs-right">
      <v-bottom-sheet v-model="sheet">
         <template v-slot:activator>
            <v-btn round outline color="success" dark>Crear Tareas</v-btn>
         </template>
         <v-list dark>
            <v-subheader>Complete los pasos para crear la Tarea.</v-subheader>
            <!-- <v-list-tile> -->
            <tasksteppercomponent :sheet="sheet" v-on:speak="closeMethod($event)"></tasksteppercomponent>
            <!-- </v-list-tile> -->
            <!-- <v-list-tile v-for="tile in tiles" :key="tile.title" @click="sheet = false">
               <v-list-tile-avatar>
                  <v-avatar size="32px" tile>
                     <img
                        :src="`https://cdn.vuetifyjs.com/images/bottom-sheets/${tile.img}`"
                        :alt="tile.title"
                     >
                  </v-avatar>
               </v-list-tile-avatar>
               <v-list-tile-title>{{ tile.title }}</v-list-tile-title>
            </v-list-tile>-->
         </v-list>
      </v-bottom-sheet>
   </div>
</template>

<script>
export default {
   data: () => ({
      sheet: false,
      tiles: [{ img: "keep.png", title: "Keep" }]
   }),
   methods: {
      closeMethod: function(msj) {
         this.sheet = msj;
      }
   }
};
</script>

<style scoped>
/* .something {
   color: var(--v-primary-base);
   background-color: var(--v-accent-darken2);
} */
</style>
