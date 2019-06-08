
<template>
   <v-layout row justify-center>
      <v-dialog v-model="open" persistent max-width="900px">
         <v-card>
            <v-card-title>
               <span class="headline">Edite la tarea</span>
            </v-card-title>
            <v-card-text>
               <taskcomponent :tarea="tarea" :type="'edit'" v-on:speak="CerrarMethod($event)"></taskcomponent>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue darken-1" flat @click="Cerrar">Cerrar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   props: ["tarea", "dialogEdit"],
   data() {
      return {
         open: false
      };
   },
   methods: {
      CerrarMethod: function(msj) {
         this.open = msj.Open;
         this.$emit("speak", {
            Open: msj.Open,
            Status: "success"
         });
      },
      Cerrar() {
         this.open = false;
         this.$emit("speak", {
            Open: false,
            Status: "none"
         });
      }
   },
   watch: {
      dialogEdit(val) {
         this.open = val;
      }
   }
};
</script>

<style scoped>
</style>
