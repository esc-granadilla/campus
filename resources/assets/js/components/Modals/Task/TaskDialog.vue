
<template>
   <div>
      <v-btn round outline color="primary" dark @click="open = true">Editar Tareas</v-btn>
      <v-layout row justify-center>
         <v-dialog v-model="open" persistent max-width="900px">
            <v-card>
               <v-card-title>
                  <span class="headline">Seleccione la tarea</span>
               </v-card-title>
               <v-card-text>
                  <edittaskcomponent :tareas="tareas" v-on:speak="CerrarMethod($event)"></edittaskcomponent>
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="open = false">Cerrar</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
      </v-layout>
   </div>
</template>

<script>
export default {
   data() {
      return {
         open: false,
         tareas: []
      };
   },
   methods: {
      CerrarMethod: function(msj) {
         this.open = msj.Open;
      }
   },
   watch: {
      open(val) {
         if (val) {
            axios.get("/tasks").then(res => (this.tareas = res.data));
         }
      }
   }
};
</script>

<style scoped>
</style>
