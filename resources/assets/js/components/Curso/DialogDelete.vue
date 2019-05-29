<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogdelete" max-width="290">
         <v-card>
            <v-card-title class="headline">Eliminar curso?</v-card-title>

            <v-card-text error>
               <v-alert
                  :value="true"
                  color="error"
                  icon="priority_high"
                  outline
               >Seguro que quieres eliminar este curso.</v-alert>
            </v-card-text>

            <v-card-actions>
               <v-spacer></v-spacer>

               <v-btn
                  color="grey darken-3"
                  flat="flat"
                  @click="dialogdelete = false,$emit('speak', {dialogdelete:false,Delete:false})"
               >NO</v-btn>

               <v-btn
                  color="red darken-2"
                  flat="flat"
                  @click="dialogdelete = false,$emit('speak', {dialogdelete:false,Delete:true})"
               >SI</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return { dialogdelete: false };
   },
   props: ["dialogDeletes"],
   watch: {
      dialogDeletes(val) {
         this.dialogdelete = val;
      }
   }
};
</script>