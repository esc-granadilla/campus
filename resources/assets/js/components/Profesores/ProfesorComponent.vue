<template>
   <div>
      <v-flex md10 xs12 offset-md1>
         <v-layout wrap row>
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Listado de Profesores</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <v-btn
                     class="green lighten-4"
                     fab
                     small
                     absolute
                     top
                     left
                     block
                     @click="crearMethod"
                  >+</v-btn>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <dialogedit
                     :dialogEdits="dialogEdit"
                     :editProfesor="teacher"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>
                  <v-card-title>
                     <v-spacer></v-spacer>Profesores
                     <v-spacer></v-spacer>
                     <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Buscar por Cedula"
                        single-line
                        hide-details
                     ></v-text-field>
                  </v-card-title>
                  <v-data-table
                     :headers="headers"
                     :items="teachers"
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
                        >{{ props.item.cedula }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.nombre }} {{ props.item.primer_apellido }} {{ props.item.segundo_apellido }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >Nacimiento: {{ props.item.fecha_nacimiento }} Ingreso: {{ props.item.fecha_ingreso }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.puesto }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.telefono1 }} {{ props.item.telefono2 }}</td>
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
import dialogdelete from "../Profesores/DialogDelete.vue";
import dialogedit from "../Profesores/DialogEdit.vue";

export default {
   name: "profesorcomponent",
   components: {
      dialogdelete,
      dialogedit
   },
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         teacher: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: "",
            puesto: "",
            fecha_ingreso: "",
            telefono1: "",
            telefono2: ""
         },
         alert: false,
         teachers: [],
         mensaje: { type: "success", message: "" },
         headers: [
            {
               text: "Cedula",
               align: "left",
               sortable: false,
               value: "cedula"
            },
            { text: "Nombre Completo", align: "center", value: "nombre" },
            {
               text: "Fechas",
               align: "center",
               value: "fecha_nacimiento"
            },
            { text: "Puesto", align: "center", value: "puesto" },
            { text: "Telefonos", align: "center", value: "telefono1" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ]
      };
   },
   methods: {
      buscar(id) {
         this.teacher = this.teachers.find(function(c) {
            return c.id == id;
         });
      },
      crearMethod() {
         location.href = "teachers/create";
      },
      eliminar() {
         var self = this;
         if (this.teacher.id != null) {
            axios.delete("teachers/" + this.teacher.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/teachers").then(res => (self.teachers = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.teacher.id != null) {
            axios
               .put("teachers/" + this.teacher.id, this.teacher)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios
                     .get("/teachers")
                     .then(res => (self.teachers = res.data));
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
            this.teacher = msg.profesor;
            this.editar();
         } else {
            this.teacher = {
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
      axios.get("/teachers").then(res => (this.teachers = res.data));
   }
};
</script>

<style scoped>
.v-table thead tr:first-child {
   background-color: black;
}
</style>