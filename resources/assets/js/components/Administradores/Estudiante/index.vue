<template>
   <v-flex md10 xs12 offset-md1>
      <v-layout wrap row>
         <v-flex xs12 pt-2 px-3>
            <v-toolbar dark color="green" class="py-1">
               <v-spacer></v-spacer>
               <v-toolbar-title>Listado de Estudiantes</v-toolbar-title>
               <v-spacer></v-spacer>
            </v-toolbar>
            <v-card>
               <dialogdelete
                  :text="text"
                  :title="title"
                  :dialogDeletes="dialogDelete"
                  v-on:speak="borrarMethod($event)"
               ></dialogdelete>
               <dialogedit
                  :dialogEdits="dialogEdit"
                  :editData="student"
                  v-on:speak="editarMethod($event)"
                  componente="estudiante_component"
                  title="Editar Estudiante"
                  width="800px"
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
                     >{{ props.item.seccion.seccion }}</td>
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
   name: "estudiantecomponent",
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         title: "Eliminar Estudiante?",
         text: "Seguro que quieres eliminar este Estudiante.",
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
               this.restaurar();
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
                  this.restaurar();
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
            this.student = msg.data;
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
      llenarSeccion(students) {
         let self = this;
         students.forEach(function(estudiante) {
            if (estudiante.section_id != null) {
               estudiante.seccion = self.seccions.find(function(c) {
                  return c.id == estudiante.section_id;
               });
            } else {
               estudiante.seccion = "No Asignada";
            }
         });
         this.students = students;
      },
      restaurar() {
         var self = this;
         axios.get("/sections").then(function(res) {
            self.seccions = res.data;
            axios.get("/students").then(function(res) {
               self.llenarSeccion(res.data);
            });
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
      this.restaurar();
   }
};
</script>

<style scoped>
.v-table thead tr:first-child {
   background-color: black;
}
</style>