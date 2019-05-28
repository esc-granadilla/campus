<template>
   <div>
      <v-flex md10 xs12 offset-md1>
         <v-layout wrap row>
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Listado de Estudiantes</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <dialogedit
                     :dialogEdits="dialogEdit"
                     :editSeccions="seccions"
                     :editEstudiante="student"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>
                  <v-card-title>
                     <v-spacer></v-spacer>Estudiantes
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
                     :items="students"
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
                        >{{ props.item.fecha_nacimiento }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.adecuacion }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.seccion }}</td>
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
import dialogdelete from "../Estudiantes/DialogDelete.vue";
import dialogedit from "../Estudiantes/DialogEdit.vue";

export default {
   name: "estudiantecomponent",
   components: {
      dialogdelete,
      dialogedit
   },
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         student: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: "",
            adecuacion: "",
            section_id: null,
            seccion: "",
            estado: 0
         },
         alert: false,
         students: [],
         seccions: [],
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
               text: "Fecha Nacimiento",
               align: "center",
               value: "fecha_nacimiento"
            },
            { text: "adecuacion", align: "center", value: "adecuacion" },
            { text: "Seccion", align: "center", value: "seccion" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ]
      };
   },
   methods: {
      buscar(id) {
         this.student = this.students.find(function(c) {
            return c.id == id;
         });
      },
      eliminar() {
         var self = this;
         if (this.student.id != null) {
            axios.delete("students/" + this.student.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/students").then(function(res) {
                  self.students = res.data;
                  self.llenarSeccion();
               });
            });
         }
      },
      editar() {
         var self = this;
         if (this.student.id != null) {
            axios
               .put("students/" + this.student.id, this.student)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios.get("/students").then(function(res) {
                     self.students = res.data;
                     self.llenarSeccion();
                  });
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
            this.student = msg.estudiante;
            this.editar();
         } else {
            this.student = {
               id: null,
               cedula: "",
               nombre: "",
               primer_apellido: "",
               segundo_apellido: "",
               fecha_nacimiento: "",
               adecuacion: "",
               section_id: null,
               estado: 0
            };
         }
      },
      llenarSeccion() {
         let self = this;
         this.students.forEach(function(estudiante) {
            if (estudiante.section_id != null) {
               estudiante.seccion = self.seccions.find(function(c) {
                  return c.id == estudiante.section_id;
               }).seccion;
            } else {
               estudiante.seccion = "No Asignada";
            }
         });
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
      var self = this;
      axios.get("/sections").then(function(res) {
         self.seccions = res.data;
         axios.get("/students").then(function(res) {
            self.students = res.data;
            self.llenarSeccion();
         });
      });
   }
};
</script>

<style scoped>
.v-table thead tr:first-child {
   background-color: black;
}
</style>