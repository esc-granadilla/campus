<template>
   <v-container grid-list-md>
      <v-layout justify-end>
         <createnewsdialog :tipo="'Global'"></createnewsdialog>
      </v-layout>
      <br>
      <selectnewscomponent></selectnewscomponent>
   </v-container>
</template>
<script>
import createnewsdialog from "../../Modals/News/CreateNewsDialog.vue";
export default {
   components: {
      createnewsdialog
   },
   data() {
      return {};
   }
};
</script>
<style scoped>
</style>
