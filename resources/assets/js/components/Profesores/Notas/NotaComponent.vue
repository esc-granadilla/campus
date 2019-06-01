<template>
   <v-flex>
      <combostudents
         :students="students"
         :dialogOpens="dialogOpen"
         v-on:speak="selectMethod($event)"
      ></combostudents>
      <v-flex md8 xs12 offset-md2>
         <v-layout wrap row>
            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Listado de Calificaciones</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <!-- <dialogedit
                     :dialogEdits="dialogEdit"
                     :editSection="section"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>-->
                  <v-card-title>
                     <v-spacer></v-spacer>Notas
                     <v-spacer></v-spacer>
                     <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Buscar por Titulo"
                        single-line
                        hide-details
                     ></v-text-field>
                  </v-card-title>
                  <v-data-table
                     :headers="headers"
                     :items="notas"
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
                        >{{ props.item.titulo }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.fecha }} - {{ props.item.trimestre }} Trimestre</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >Valor: {{ props.item.valor_porcentual }} - Obtenido: {{ props.item.porcentaje_obtenido }} Trimestre</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.nota }}</td>
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
   </v-flex>
</template>

<script>
import combostudents from "../../Modals/ComboStudents.vue";
import dialogdelete from "../../Modals/DialogDelete.vue";
import dialogcreate from "./DialogCreate.vue";

export default {
   components: {
      combostudents,
      dialogcreate,
      dialogdelete
   },
   data() {
      return {
         search: "",
         dialogOpen: false,
         dialogDelete: false,
         dialogEdit: false,
         title: "Eliminar Nota?",
         text: "Seguro que quieres eliminar esta Nota.",
         notas: [],
         nota: {
            id: null
         },
         students: [],
         student: null,
         mensaje: null,
         headers: [
            {
               text: "Titulo:",
               align: "left",
               sortable: false,
               value: "titulo"
            },
            { text: "Fecha:", align: "center", value: "fecha" },
            {
               text: "Porcentajes:",
               align: "center",
               value: "valor_porcentual"
            },
            { text: "Nota:", align: "center", value: "nota" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ]
      };
   },
   methods: {
      selectMethod: function(msj) {
         if (msj.Selected) {
            this.student = msj.Student;
            this.reset();
         } else this.$router.push("screenteacher");
      },
      buscar(id) {
         this.nota = this.notas.find(function(c) {
            return c.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         if (msg.titulo != "") {
            msg.student_id = this.student.id;
            axios.post("qualifications/", msg).then(function(res) {
               self.mensaje = res.data;
               self.reset();
            });
         }
      },
      reset() {
         var self = this;
         axios
            .get("/qualificationsforstudent/" + this.student.id)
            .then(function(res) {
               let qualifications = res.data;
               qualifications.forEach(qualification => {
                  let x =
                     (100 / qualification.valor_porcentual) *
                     porcentaje_obtenido;
                  qualification.nota = x.toFixed(2);
               });
               self.notas = qualifications;
               self.nota = null;
            });
      },
      eliminar() {
         var self = this;
         if (this.nota.id != null) {
            axios.delete("qualifications/" + this.nota.id).then(function(res) {
               self.mensaje = res.data;
               self.reset();
            });
         }
      },
      editar() {
         var self = this;
         if (this.nota.id != null) {
            axios
               .put("qualifications/" + this.nota.id, this.nota)
               .then(function(res) {
                  self.mensaje = res.data;
                  self.reset();
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
            this.nota = msg.nota;
            this.editar();
         } else {
            this.nota = null;
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
      let self = this;
      axios.get("/studentsforcourse").then(function(res) {
         self.students = res.data;
         self.dialogOpen = true;
      });
   }
};
</script>
