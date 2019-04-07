
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogCreate" persistent max-width="300px">
         <template v-slot:activator="{ on }">
            <v-btn class="green lighten-4" fab small absolute top left block v-on="on">+</v-btn>
         </template>
         <v-card>
            <v-card-title>
               <span class="headline">Curso Nuevo</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-dialog
                           ref="dialog"
                           v-model="modal1"
                           :return-value.sync="horario.desde"
                           persistent
                           lazy
                           full-width
                           width="290px"
                        >
                           <template v-slot:activator="{ on }">
                              <v-text-field
                                 v-model="horario.desde"
                                 label="*Desde:"
                                 prepend-icon="access_time"
                                 readonly
                                 :rules="[rules.required]"
                                 v-on="on"
                              ></v-text-field>
                           </template>
                           <v-time-picker v-if="modal1" v-model="horario.desde" full-width>
                              <v-spacer></v-spacer>
                              <v-btn flat color="primary" @click="modal1 = false">Cancel</v-btn>
                              <v-btn
                                 flat
                                 color="primary"
                                 @click="$refs.dialog.save(horario.desde)"
                              >OK</v-btn>
                           </v-time-picker>
                        </v-dialog>
                        <v-dialog
                           ref="dialog1"
                           v-model="modal2"
                           :return-value.sync="horario.hasta"
                           persistent
                           lazy
                           full-width
                           width="290px"
                        >
                           <template v-slot:activator="{ on }">
                              <v-text-field
                                 v-model="horario.hasta"
                                 label="*Hasta"
                                 prepend-icon="access_time"
                                 readonly
                                 :rules="[rules.required]"
                                 v-on="on"
                              ></v-text-field>
                           </template>
                           <v-time-picker v-if="modal2" v-model="horario.hasta" full-width>
                              <v-spacer></v-spacer>
                              <v-btn flat color="primary" @click="modal2 = false">Cancel</v-btn>
                              <v-btn
                                 flat
                                 color="primary"
                                 @click="$refs.dialog1.save(horario.hasta)"
                              >OK</v-btn>
                           </v-time-picker>
                        </v-dialog>
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
            required: value => !!value || "Requerido."
         },
         horario: {
            id: null,
            desde: null,
            hasta: null,
            estado: ""
         },
         modal2: false,
         modal1: false
      };
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogCreate = false;
            this.$emit("speak", this.horario);
         }
      }
   }
};
</script>

<style scoped>
</style>
