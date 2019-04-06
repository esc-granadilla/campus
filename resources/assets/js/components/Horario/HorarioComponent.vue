<template>
   <div>
      <div class="alert">
         <v-alert v-model="alert" dismissible :type="alerttype">{{ mensaje.message }}</v-alert>
      </div>
      <v-flex md8 xs12 offset-md2>
         <v-layout wrap row>
            <!--<v-flex xs12 pt-2 px-3>
               <v-card fluid class="elevation-12">
                  <v-toolbar dark class="py-1">
                     <v-toolbar-title>Horario</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>
                  <v-flex md10 xs12 offset-md1>
                     <v-card-text>
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
                                    <v-btn
                                       round
                                       dark
                                       flat
                                       color="red"
                                       block
                                       @click="eliminar"
                                    >Eliminar</v-btn>
                                 </v-flex>
                              </v-layout>
                           </v-flex>
                        </v-layout>
                     </v-card-text>
                  </v-flex>
               </v-card>
            </v-flex>-->
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Horario</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <dialogedit
                     :dialogEdits="dialogEdit"
                     :editHorario="horario"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>
                  <v-card-title>
                     <v-spacer></v-spacer>Horarios
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
                        <td
                           class="text-xs-left"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.desde }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.hasta }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >
                           <v-btn
                              flat
                              small
                              color="primary"
                              @click="buscar(props.item.id),dialogEdit = true"
                           >Editar</v-btn>
                        </td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >
                           <v-btn
                              flat
                              small
                              color="error"
                              dark
                              @click.stop="buscar(props.item.id),dialogDelete = true"
                           >Eliminar</v-btn>
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
   </div>
</template>

<script>
import dialogcreate from "../Horario/DialogCreate.vue";
import dialogdelete from "../Horario/DialogDelete.vue";
import dialogedit from "../Horario/DialogEdit.vue";

export default {
   components: {
      dialogcreate,
      dialogdelete,
      dialogedit
   },
   name: "cursocomponent",
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
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
            { text: "Hasta:", align: "center", value: "hasta" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ],
         alert: false,
         alerttype: "success"
      };
   },
   methods: {
      buscar(id) {
         this.horario = this.horarios.find(function(h) {
            return h.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         this.horario = msg;
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
      },
      borrarMethod: function(msg) {
         this.dialogDelete = msg.dialogdelete;
         if (msg.Delete) this.eliminar();
      },
      editarMethod: function(msg) {
         this.dialogEdit = msg.dialogedit;
         if (msg.Edit) {
            this.horario = msg.horario;
            this.editar();
         } else {
            this.horario = {
               id: null,
               desde: null,
               hasta: null,
               estado: ""
            };
         }
      }
   },
   watch: {
      mensaje(val) {
         this.alert = true;
      }
   },
   mounted() {
      axios.get("/horarios").then(res => (this.horarios = res.data));
   }
};
</script>

<style scoped>
.alert {
   position: absolute;
   z-index: 2;
   right: 0;
}
</style>
