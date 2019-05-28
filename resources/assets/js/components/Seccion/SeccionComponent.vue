<template>
   <div>
      <v-flex md8 xs12 offset-md2>
         <v-layout wrap row>
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Listado de Secciones</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <dialogedit
                     :dialogEdits="dialogEdit"
                     :editSection="section"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>
                  <v-card-title>
                     <v-spacer></v-spacer>Secciones
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
                     :items="sections"
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
                        >{{ props.item.seccion }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.grado }}</td>
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
import dialogcreate from "./DialogCreate.vue";
import dialogdelete from "./DialogDelete.vue";
import dialogedit from "./DialogEdit.vue";

export default {
   components: {
      dialogcreate,
      dialogdelete,
      dialogedit
   },
   name: "seccioncomponent",
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         section: {
            id: null,
            seccion: null,
            grade_id: null,
            estado: 1
         },
         grades: [],
         sections: [],
         mensaje: { type: "success", message: "" },
         headers: [
            {
               text: "Sección:",
               align: "left",
               sortable: false,
               value: "seccion"
            },
            { text: "Grado:", align: "center", value: "grado" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ]
      };
   },
   methods: {
      buscar(id) {
         this.section = this.sections.find(function(h) {
            return h.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         this.section = msg;
         if (this.section.seccion != null) {
            axios.post("sections/", self.section).then(function(res) {
               self.mensaje = res.data;
               axios.get("/sections").then(function(res) {
                  self.sections = res.data;
                  self.llenarGrado();
               });
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.section.id != null) {
            axios.delete("sections/" + self.section.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/sections").then(function(res) {
                  self.sections = res.data;
                  self.llenarGrado();
               });
            });
         }
      },
      editar() {
         var self = this;
         if (this.section.id != null) {
            axios
               .put("sections/" + self.section.id, self.section)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios.get("/sections").then(function(res) {
                     self.sections = res.data;
                     self.llenarGrado();
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
            this.section = msg.seccion;
            this.editar();
         } else {
            this.section = {
               id: null,
               seccion: null,
               grade_id: null,
               estado: 1
            };
         }
      },
      llenarGrado() {
         let self = this;
         this.sections.forEach(function(seccion) {
            seccion.grado = self.grades.find(function(c) {
               return c.id == seccion.grade_id;
            }).grado;
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
      axios.get("/grades").then(function(res) {
         self.grades = res.data;
         axios.get("/sections").then(function(res) {
            self.sections = res.data;
            self.llenarGrado();
         });
      });
   }
};
</script>

<style scoped>
</style>
