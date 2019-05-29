<template>
   <div>
      <v-flex md8 xs12 offset-md2>
         <v-layout wrap row>
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Listado de Cursos</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <v-card-title>
                     <v-spacer></v-spacer>Cursos
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
                     :items="cursos"
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
                        >{{ props.item.profesor.nombre }} {{ props.item.profesor.primer_apellido }} {{ props.item.profesor.segundo_apellido }}</td>
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
import dialogcreate from "../Curso/DialogCreate";
import dialogdelete from "../Curso/DialogDelete.vue";

export default {
   name: "cursocomponent",
   components: {
      dialogcreate,
      dialogdelete
   },
   data() {
      return {
         search: "",
         dialogDelete: false,
         curso: {
            id: null,
            nombre: "",
            section_id: null,
            teacher_id: null,
            subject_id: null,
            profesor: {
               nombre: "",
               primer_apellido: "",
               segundo_apellido: ""
            }
         },
         cursos: [],
         mensaje: { type: "success", message: "" },
         headers: [
            {
               text: "Nombre",
               align: "left",
               sortable: false,
               value: "nombre"
            },
            { text: "Profesor", align: "center", value: "codigo" },
            { text: "Eliminar", align: "center", value: "" }
         ]
      };
   },
   methods: {
      buscar(id) {
         this.curso = this.cursos.find(function(c) {
            return c.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         if (
            msg.asignatura != null &&
            msg.seccion != null &&
            msg.profesor != null
         ) {
            msg.nombre = `${msg.asignatura.nombre} ${msg.seccion.seccion}`;
            msg.subject_id = msg.asignatura.id;
            msg.teacher_id = msg.profesor.id;
            msg.section_id = msg.seccion.id;
            this.curso = msg;
            axios.post("courses/", this.curso).then(function(res) {
               self.mensaje = res.data;
               axios.get("/courses").then(res => (self.cursos = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.curso.id != null) {
            axios.delete("courses/" + this.curso.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/courses").then(res => (self.cursos = res.data));
            });
         }
      },
      borrarMethod: function(msg) {
         this.dialogDelete = msg.dialogdelete;
         if (msg.Delete) this.eliminar();
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
      axios.get("/courses").then(res => (this.cursos = res.data));
   }
};
</script>

<style scoped>
.v-table thead tr:first-child {
   background-color: black;
}
</style>