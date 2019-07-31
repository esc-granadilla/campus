
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" :max-width="width">
         <v-card>
            <v-card-title>
               <span class="headline">{{ title }}</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <component
                        :is="componente"
                        v-on:speak="validar($event)"
                        :validar="save"
                        :restaurar="!dialogedit"
                        :datos="editData"
                     ></component>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn
                  color="blue darken-1"
                  flat
                  @click="dialogedit = false,$emit('speak', {dialogedit:false,Edit:false,data:null})"
               >Cerrar</v-btn>
               <v-btn color="blue darken-1" flat @click="save = true">Salvar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         dialogedit: false,
         save: false
      };
   },
   props: ["dialogEdits", "editData", "componente", "title", "width"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      }
   },
   methods: {
      validar: function(data) {
         if (data != null) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               data: data
            });
         }
         this.save = false;
      }
   }
};
</script>

<style scoped>
</style>
