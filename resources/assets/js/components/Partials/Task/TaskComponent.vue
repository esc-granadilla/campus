<template>
   <v-layout row wrap>
      <v-flex xs12 v-for="(item, index) in tarea.preguntas" :key="item.id">
         <v-flex xs12>
            <p class="headline">{{index+1}}) {{item.pregunta}}</p>
         </v-flex>
         <v-flex xs12>
            <p class="mb">Seleccione su respueta:</p>
            <v-radio-group row light v-model="item.answer" class="mb mt flex xs12">
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="A)" value="A)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_a"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="B)" value="B)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_b"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="C)" value="C)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_c"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="D)" value="D)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_d"></v-text-field>
                  </v-layout>
               </v-flex>
            </v-radio-group>
         </v-flex>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["tarea", "type"],
   data() {
      return {};
   },
   methods: {},
   watch: {}
};
</script>

<style>
.mb {
   margin-bottom: 0px;
   padding-bottom: 0px;
}
.mt {
   margin-top: 0px;
   padding-top: 0px;
}
.v-input--selection-controls .v-input__control {
   width: 100%;
}
</style>

