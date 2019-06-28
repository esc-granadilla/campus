<template>
   <v-container>
      <v-layout>
         <v-flex text-xs-center xs8 offset-xs2 sm6 offset-sm3 lg4 offset-lg4>
            <img src="../../img/401.png" alt="No autorizado" height="400">
            <v-alert
               :value="true"
               type="error"
               class="font-weight-medium"
            >No tienes permisos para ingresar a esta pagina.</v-alert>
         </v-flex>
      </v-layout>
   </v-container>
</template>

<script>
export default {
   data() {
      return {};
   }
};
</script>

<style scoped>
</style>
