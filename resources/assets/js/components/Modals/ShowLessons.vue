<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogselect" max-width="640" persistent>
         <v-card>
            <v-card-title class="headline">Horario de Lecciones</v-card-title>
            <v-card-text>
               <v-list class="pt-0" dense>
                  <v-divider></v-divider>
                  <v-list-tile v-for="item in lessons" :key="item.dia">
                     <v-list-tile-content>
                        <v-list-tile-title>{{ item.dia }}</v-list-tile-title>
                     </v-list-tile-content>
                     <v-list-tile v-for="it in item.horario" :key="it.id">
                        <v-list-tile-content>
                           <v-list-tile-title>{{ it.desde }} a {{ it.hasta }}</v-list-tile-title>
                        </v-list-tile-content>
                     </v-list-tile>
                  </v-list-tile>
               </v-list>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn
                  color="red darken-3"
                  flat="flat"
                  @click="dialogselect = false,$emit('speak', false)"
               >Salir</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         lessons: [],
         dialogselect: false
      };
   },
   props: ["dialogOpen", "course"],
   watch: {
      dialogOpen(val) {
         this.dialogselect = val;
      },
      course(val) {
         axios
            .get("/lessonsforcourse/" + val)
            .then(res => (this.lessons = res.data));
      }
   }
};
</script>

<style scoped>
</style>
