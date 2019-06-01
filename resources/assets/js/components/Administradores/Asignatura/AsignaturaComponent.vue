<template>
   <v-flex md8 xs12 offset-md2>
      <v-layout wrap row>
         <v-flex xs12 pt-2 px-3>
            <v-toolbar dark color="green" class="py-1">
               <v-spacer></v-spacer>
               <v-toolbar-title>Listado de Asignaturas</v-toolbar-title>
               <v-spacer></v-spacer>
            </v-toolbar>
            <v-card>
               <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
               <dialogdelete
                  :text="text"
                  :title="title"
                  :dialogDeletes="dialogDelete"
                  v-on:speak="borrarMethod($event)"
               ></dialogdelete>
               <dialogedit
                  :dialogEdits="dialogEdit"
                  :editAsignacion="asignatura"
                  v-on:speak="editarMethod($event)"
               ></dialogedit>
               <v-card-title>
                  <v-spacer></v-spacer>Asignaturas
                  <v-spacer></v-spacer>
                  <v-text-field
                     v-model="search"
                     append-icon="search"
                     label="Buscar por Nombre"
                     single-line
                     hide-details
                  ></v-text-field>
               </v-card-title>
               <v-data-table
                  :headers="headers"
                  :items="asignaturas"
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
                     >{{ props.item.nombre }}</td>
                     <td
                        class="text-xs-center"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >{{ props.item.codigo }}</td>
                     <td
                        class="text-xs-center"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >{{ props.item.descripcion }}</td>
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
import dialogcreate from "./DialogCreate.vue";
import dialogdelete from "../../Modals/DialogDelete.vue";
import dialogedit from "./DialogEdit.vue";

export default {
   name: "asignaturacomponent",
   components: {
      dialogcreate,
      dialogdelete,
      dialogedit
   },
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         title: "Eliminar Asignatura?",
         text: "Seguro que quieres eliminar esta Asignatura.",
         asignatura: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         },
         asignaturas: [],
         mensaje: { type: "success", message: "" },
         headers: [
            {
               text: "Nombre",
               align: "left",
               sortable: false,
               value: "nombre"
            },
            { text: "Codigo", align: "center", value: "codigo" },
            { text: "Descripción", align: "center", value: "descripcion" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ],
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         }
      };
   },
   methods: {
      buscar(id) {
         this.asignatura = this.asignaturas.find(function(c) {
            return c.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         this.asignatura = msg;
         if (this.asignatura.nombre != "") {
            axios.post("subjects/", this.asignatura).then(function(res) {
               self.mensaje = res.data;
               axios
                  .get("/subjects")
                  .then(res => (self.asignaturas = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.asignatura.id != null) {
            axios.delete("subjects/" + this.asignatura.id).then(function(res) {
               self.mensaje = res.data;
               axios
                  .get("/subjects")
                  .then(res => (self.asignaturas = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.asignatura.id != null) {
            axios
               .put("/subjects/" + this.asignatura.id, this.asignatura)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios
                     .get("/subjects")
                     .then(res => (self.asignaturas = res.data));
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
            this.asignatura = msg.asignatura;
            this.editar();
         } else {
            this.asignatura = {
               id: null,
               codigo: "",
               nombre: "",
               descripcion: "",
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
      axios.get("/subjects").then(res => (this.asignaturas = res.data));
   }
};
</script>

<style scoped>
.v-table thead tr:first-child {
   background-color: black;
}
</style>