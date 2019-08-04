<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogCreate" persistent :max-width="width">
         <template v-slot:activator="{ on }">
            <v-btn class="green lighten-4" fab small absolute top left block v-on="on">+</v-btn>
         </template>
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
                        :restaurar="dialogCreate"
                        :datos="null"
                     ></component>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue darken-1" flat @click="dialogCreate = false">Cerrar</v-btn>
               <v-btn color="blue darken-1" flat @click="save=true">Salvar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   props: ["componente", "title", "width"],
   data() {
      return {
         dialogCreate: false,
         save: false
      };
   },
   methods: {
      validar: function(data) {
         if (data != null) {
            this.dialogCreate = false;
            this.$emit("speak", data);
         }
         this.save = false;
      }
   }
};
</script>

<style scoped>
</style>