
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="300px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Horario</span>
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
               <v-btn
                  color="blue darken-1"
                  flat
                  @click="dialogedit = false, horario = horariostock,$emit('speak', {dialogedit:false,Edit:false,horario:horario})"
               >Cerrar</v-btn>
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
         dialogedit: false,
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
         modal1: false,
         horariostock: {
            id: null,
            desde: null,
            hasta: null,
            estado: ""
         }
      };
   },
   props: ["dialogEdits", "editHorario"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editHorario(val) {
         this.horario.id = val.id;
         this.horario.desde = val.desde;
         this.horario.hasta = val.hasta;
         this.horario.estado = val.estado;
      }
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               horario: this.horario
            });
         }
      }
   }
};
</script>

<style scoped>
</style>
