<template>
   <v-layout row justify-center>
      <v-dialog v-model="open" persistent max-width="800px">
         <v-card>
            <v-card-text>
               <shownewscomponent :news="news"></shownewscomponent>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="red darken-1" flat @click="cerrar">Cerrar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   props: ["news"],
   data() {
      return {
         open: false
      };
   },
   methods: {
      cerrar() {
         this.open = false;
         this.$emit("speak", false);
      }
   },
   watch: {
      news(val) {
         if (val != null) this.open = true;
      }
   }
};
</script>