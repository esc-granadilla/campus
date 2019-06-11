<template>
   <v-container grid-list-md>
      <v-layout justify-end>
         <createnewsdialog :tipo="'Global'" v-on:speak="actualizarMethod($event)"></createnewsdialog>
      </v-layout>
      <br>
      <selectnewscomponent :news="news" v-on:speak="actualizarMethod($event)"></selectnewscomponent>
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
         news: [],
         data: {
            tipo: "Global"
         }
      };
   },
   methods: {
      actualizarMethod: function(msj) {
         axios.get("news", this.data).then(res => (this.news = res.data));
      }
   },
   mounted() {
      axios.get("news", this.data).then(res => (this.news = res.data));
   }
};
</script>
<style scoped>
</style>
