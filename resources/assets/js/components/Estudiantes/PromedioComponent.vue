<template>
   <v-layout align-center class="my-3 mx-3">
      <v-item-group v-model="window" class="shrink mr-4" mandatory tag="v-flex">
         <v-item v-for="n in length" :key="n">
            <div slot-scope="{ active, toggle }">
               <v-btn :input-value="active" icon @click="toggle">
                  <v-icon>{{icons[n-1]}}</v-icon>
               </v-btn>
            </div>
         </v-item>
      </v-item-group>

      <v-flex>
         <v-window v-model="window" class="elevation-1" vertical>
            <v-window-item v-for="n in length" :key="n">
               <v-card flat>
                  <v-card-text>
                     <v-layout align-center mb-3>
                        <v-avatar color="blue" class="mr-3">
                           <v-icon>assessment</v-icon>
                        </v-avatar>
                        <strong class="title">Trimestre {{ n }}</strong>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="Calcular(n)">
                           <v-icon>cached</v-icon>
                        </v-btn>
                     </v-layout>
                     <keep-alive v-if="n-1==window">
                        <component :data="select" :is="currentPage"></component>
                     </keep-alive>
                  </v-card-text>
               </v-card>
            </v-window-item>
         </v-window>
      </v-flex>
   </v-layout>
</template>

<script>
import estaditicacomponent from "../Partials/EstudianteEstadisticaComponent.vue";
export default {
   components: {
      home: {
         template: `<div>
                 <h4>Proceda a calcular <v-icon>cached</v-icon>. Para desplegar la infomación.</h4>
                 </div>`,
         data: function() {
            return {};
         },
         props: ["data"]
      },
      estaditicacomponent
   },
   data: () => ({
      length: 3,
      currentPage: "home",
      select: 0,
      icons: ["filter_1", "filter_2", "filter_3"],
      window: 0
   }),
   methods: {
      Calcular(n) {
         this.currentPage = "estaditicacomponent";
         this.select = n;
      }
   },
   watch: {
      window(val) {
         this.currentPage = "home";
      }
   }
};
</script>

<style scoped>
</style>
