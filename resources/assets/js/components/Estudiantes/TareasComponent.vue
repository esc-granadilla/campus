<template>
   <v-tabs fixed-tabs>
      <v-tab v-for="n in 3" :key="n">{{ titulos[n-1] }}</v-tab>
      <v-tab-item v-for="n in 3" :key="n">
         <v-card flat>
            <v-card-text>
               <showtaskscomponent :data="tareas[n-1]" v-on:speak="update($event)"></showtaskscomponent>
            </v-card-text>
         </v-card>
      </v-tab-item>
   </v-tabs>
</template>

<script>
export default {
   data() {
      return {
         titulos: ["Pendientes", "Realisadas", "Sin realizar"],
         tareas: [
            { edit: true, tasks: [] },
            { edit: false, tasks: [] },
            { edit: false, tasks: [] }
         ]
      };
   },
   methods: {
      update(msj) {
         let self = this;
         axios.get("studenttasks").then(function(res) {
            self.tareas[1].tasks = res.data.realizadas;
            self.tareas[2].tasks = res.data.norealizadas;
            self.tareas[0].tasks = res.data.pendientes;
         });
      }
   },
   mounted() {
      let self = this;
      axios.get("studenttasks").then(function(res) {
         self.tareas[1].tasks = res.data.realizadas;
         self.tareas[2].tasks = res.data.norealizadas;
         self.tareas[0].tasks = res.data.pendientes;
      });
   }
};
</script>

<style scoped>
</style>
