<template>
   <v-container>
      <v-layout row wrap v-show="!selected">
         <v-flex xs12 v-for="(item, index) in data.tasks" :key="index">
            <v-card>
               <v-card-title
                  primary-title
                  class="text-capitalize title font-weight-regular"
               >{{item.titulo}}</v-card-title>
               <v-divider light></v-divider>
               <v-card-text>
                  <v-layout row>
                     <v-flex xs7 sm8>
                        <p>{{item.descripcion}}</p>
                     </v-flex>
                     <v-flex xs5 sm4>
                        <v-layout justify-end row>
                           <div
                              class="text-sm-left subheading font-weight-medium"
                              style="width: 120px;"
                           >Valor: {{item.valor}}</div>
                        </v-layout>
                        <v-layout justify-end row>
                           <div class="text-sm-left" style="width: 120px;">Inicio: {{item.inicio}}</div>
                        </v-layout>
                        <v-layout justify-end row>
                           <div class="text-sm-left" style="width: 120px;">Final: {{item.final}}</div>
                        </v-layout>
                        <v-layout justify-end row>
                           <div
                              class="text-sm-left"
                              style="width: 120px;"
                           >Trimestre: {{item.trimestre}}</div>
                        </v-layout>
                     </v-flex>
                  </v-layout>
               </v-card-text>
               <v-divider light v-show="data.edit"></v-divider>
               <v-card-actions class="pa-3 jcr" v-show="data.edit">
                  <v-btn flat dark color="green" @click="realizar(item)">Realizar Prueba</v-btn>
               </v-card-actions>
            </v-card>
            <br>
         </v-flex>
      </v-layout>
      <v-layout row wrap v-if="selected">
         <taskcomponent :tarea="task" :type="'none'"></taskcomponent>
         <v-flex xs12 class="pa-3 text-xs-right">
            <v-btn color="red darken-1" outline flat @click="selected = false; task = null;">Cerrar</v-btn>
         </v-flex>
      </v-layout>
   </v-container>
</template>

<script>
export default {
   props: ["data"],
   data() {
      return {
         selected: false,
         task: null
      };
   },
   methods: {
      realizar(task) {
         this.task = task;
         this.task.preguntas = [];
         task.questions.forEach(q => {
            let quest = {
               id: q.id,
               task_id: q.task_id,
               pregunta: q.pregunta,
               opcion_a: q.opcion_a,
               opcion_b: q.opcion_b,
               opcion_c: q.opcion_c,
               opcion_d: q.opcion_d
            };
            this.task.preguntas.push(quest);
         });
         this.selected = true;
      }
   }
};
</script>

<style scoped>
.jcr {
   justify-content: flex-end;
}
</style>
