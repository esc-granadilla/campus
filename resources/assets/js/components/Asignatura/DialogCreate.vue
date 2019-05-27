
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogCreate" persistent max-width="300px">
         <template v-slot:activator="{ on }">
            <v-btn class="green lighten-4" fab small absolute top left block v-on="on">+</v-btn>
         </template>
         <v-card>
            <v-card-title>
               <span class="headline">Asignatura Nueva</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-text-field
                           xs12
                           v-model="asignatura.codigo"
                           :rules="[rules.required, rules.mini]"
                           counter
                           label="*Codigo"
                           name="codigo"
                           required
                        ></v-text-field>

                        <v-text-field
                           xs12
                           v-model="asignatura.nombre"
                           :rules="[rules.required, rules.mini]"
                           counter
                           label="*Nombre"
                           name="nombre"
                           required
                        ></v-text-field>
                        <v-text-field
                           xs12
                           v-model="asignatura.descripcion"
                           counter
                           label="Descripción"
                           name="descripcion"
                        ></v-text-field>
                     </v-form>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue darken-1" flat @click="dialogCreate = false">Cerrar</v-btn>
               <v-btn color="blue darken-1" flat @click="validar">Salvar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         dialogCreate: false,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         },
         asignatura: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: 1
         }
      };
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogCreate = false;
            this.$emit("speak", this.asignatura);
         }
      }
   }
};
</script>

<style scoped>
</style>
