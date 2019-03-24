<template>
   <v-flex md6 xs12 offset-md3>
      <v-layout wrap row>
         <v-flex xs12 pt-2 px-3>
            <v-card fluid class="elevation-12">
               <v-toolbar dark class="py-1">
                  <v-toolbar-title>Curso</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-flex md10 xs12 offset-md1>
                  <v-card-text class="pb-0">
                     <v-layout wrap row>
                        <v-flex xs12 md7>
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
                                    label="Desde:"
                                    prepend-icon="access_time"
                                    readonly
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
                                    label="Hasta"
                                    prepend-icon="access_time"
                                    readonly
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
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs12 md3>
                           <v-layout align-end justify-end fill-height wrap>
                              <v-flex xs3 md12>
                                 <v-btn round dark flat color="green" block @click="crear">Crear</v-btn>
                              </v-flex>
                              <v-flex xs3 md12>
                                 <v-btn
                                    round
                                    dark
                                    flat
                                    color="blue"
                                    block
                                    @click="editar"
                                 >Actualizar</v-btn>
                              </v-flex>
                              <v-flex xs3 md12>
                                 <v-btn round dark flat color="red" block @click="eliminar">Eliminar</v-btn>
                              </v-flex>
                           </v-layout>
                        </v-flex>
                     </v-layout>
                  </v-card-text>
               </v-flex>
            </v-card>
         </v-flex>
         <v-flex xs12 pt-2 px-3>
            <v-card>
               <v-card-title>
                  Horarios
                  <v-spacer></v-spacer>
                  <v-text-field
                     v-model="search"
                     append-icon="search"
                     label="Buscar por Hora"
                     single-line
                     hide-details
                  ></v-text-field>
               </v-card-title>
               <v-data-table :headers="headers" :items="horarios" :search="search">
                  <template v-slot:items="props">
                     <td>{{ props.item.desde }}</td>
                     <td class="text-center">{{ props.item.hasta }}</td>
                     <td class="text-center">
                        <v-btn flat small color="primary" @click="buscar(props.item.id)">Seleccionar</v-btn>
                     </td>
                  </template>
                  <v-alert
                     v-slot:no-results
                     :value="true"
                     color="error"
                     icon="warning"
                  >Tu busqueda por "{{ search }}" no encontro resultados.</v-alert>
               </v-data-table>
            </v-card>
         </v-flex>
      </v-layout>
   </v-flex>
</template>

<script>
export default {
   name: "cursocomponent",
   data() {
      return {
         search: "",
         horario: {
            id: null,
            desde: null,
            hasta: null,
            estado: ""
         },
         horarios: [],
         mensaje: [],
         headers: [
            {
               text: "Desde:",
               align: "left",
               sortable: false,
               value: "desde"
            },
            { text: "Hasta:", value: "hasta" },
            { text: "Seleccione", value: "" }
         ],
         modal2: false,
         modal1: false
      };
   },
   methods: {
      buscar(id) {
         axios
            .get("horarios/" + id + "/edit")
            .then(res => (this.horario = res.data));
      },
      crear() {
         var self = this;
         if (this.horario.desde != null) {
            axios.post("horarios/", self.horario).then(function(res) {
               self.mensaje = res.data;
               axios.get("/horarios").then(res => (self.horarios = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.horario.id != null) {
            axios.delete("horarios/" + self.horario.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/horarios").then(res => (self.horarios = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.horario.id != null) {
            axios
               .put("horarios/" + self.horario.id, self.horario)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios
                     .get("/horarios")
                     .then(res => (self.horarios = res.data));
               });
         }
      }
   },
   mounted() {
      axios.get("/horarios").then(res => (this.horarios = res.data));
   }
};
</script>

<style scoped>
</style>
