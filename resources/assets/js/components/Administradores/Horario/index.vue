<template>
   <v-flex md8 xs12 offset-md2>
      <v-layout wrap row>
         <v-flex xs12 pt-2 px-3>
            <v-toolbar dark color="green" class="py-1">
               <v-spacer></v-spacer>
               <v-toolbar-title>Listado de Horarios</v-toolbar-title>
               <v-spacer></v-spacer>
            </v-toolbar>
            <v-card>
               <dialogcreate
                  v-on:speak="crearMethod($event)"
                  componente="horario_component"
                  title="Horario Nuevo"
                  width="300px"
               ></dialogcreate>
               <dialogdelete
                  :text="text"
                  :title="title"
                  :dialogDeletes="dialogDelete"
                  v-on:speak="borrarMethod($event)"
               ></dialogdelete>
               <dialogedit
                  :dialogEdits="dialogEdit"
                  :editData="horario"
                  v-on:speak="editarMethod($event)"
                  componente="horario_component"
                  title="Editar Horario"
                  width="300px"
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
               <v-data-table
                  :headers="headers"
                  :items="horarios"
                  :search="search"
                  rowsPerPageText="Elementos por página:"
                  rowsPerPageAll="Todos"
                  pageText="{0}-{1} de {2}"
                  noResultsText="Ningún resultado a mostrar"
                  nextPage="Página siguiente"
                  prevPage="Página anterior"
                  noDataText="Ningún dato disponible"
               >
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
</template>

<script>
export default {
   name: "horariocomponent",
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         title: "Eliminar Horario?",
         text: "Seguro que quieres eliminar este Horario.",
         horario: {
            id: null,
            desde: null,
            hasta: null,
            estado: ""
         },
         horarios: [],
         mensaje: { type: "success", message: "" },
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
         ]
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
            axios.post("schedules", self.horario).then(function(res) {
               self.mensaje = res.data;
               axios.get("/schedules").then(res => (self.horarios = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.horario.id != null) {
            axios.delete("schedules/" + self.horario.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/schedules").then(res => (self.horarios = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.horario.id != null) {
            axios
               .put("schedules/" + self.horario.id, self.horario)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios
                     .get("/schedules")
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
            this.horario = msg.data;
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
         if (val.type === "success")
            this.$toast.success(val.message, {
               y: "top",
               timeout: 6000
            });
         else
            this.$toast.error(val.message, {
               y: "top",
               timeout: 6000
            });
      }
   },
   mounted() {
      axios.get("/schedules").then(res => (this.horarios = res.data));
   }
};
</script>

<style scoped>
</style>
