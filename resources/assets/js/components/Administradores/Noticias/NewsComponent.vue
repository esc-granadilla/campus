<template>
   <v-container grid-list-md>
      <v-layout justify-end>
         <createnewsdialog
            :tipo="'Global'"
            :accion="'create'"
            :data="null"
            v-on:speak="actualizarMethod($event)"
         ></createnewsdialog>
      </v-layout>
      <br>
      <selectnewscomponent :tipo="'Global'" :news="news" v-on:speak="actualizarMethod($event)"></selectnewscomponent>
   </v-container>
</template>
<script>
import createnewsdialog from "../../Modals/News/CreateNewsDialog.vue";
export default {
   components: {
      createnewsdialog
   },
   data() {
      return {
         news: []
      };
   },
   methods: {
      actualizarMethod: function(msj) {
         axios.get("news").then(res => (this.news = res.data));
      }
   },
   mounted() {
      axios.get("news").then(res => (this.news = res.data));
   }
};
</script>
<style scoped>
</style>
