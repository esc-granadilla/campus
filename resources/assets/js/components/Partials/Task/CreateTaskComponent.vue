<template>
   <div class="text-xs-right">
      <v-bottom-sheet v-model="sheet">
         <template v-slot:activator>
            <v-btn round outline color="success" dark>Crear Tareas</v-btn>
         </template>
         <v-list dark>
            <v-subheader>Complete los pasos para crear la Tarea.</v-subheader>
            <tasksteppercomponent :sheet="sheet" v-on:speak="closeMethod($event)"></tasksteppercomponent>
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
</style>
