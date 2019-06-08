<template>
   <v-layout wrap row>
      <dialogdelete
         :dialogDeletes="dialogDelete"
         :text="text"
         :title="title"
         v-on:speak="borrarMethod($event)"
      ></dialogdelete>
      <dialogedit :dialogEdit="dialogEdit" :tarea="tarea" v-on:speak="editarMethod($event)"></dialogedit>
      <v-flex xs6>
         <v-text-field label="Listado de tareas" single-line hide-details readonly></v-text-field>
      </v-flex>
      <v-flex xs6>
         <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar por Titulo"
            single-line
            hide-details
         ></v-text-field>
      </v-flex>

      <v-data-table
         :headers="headers"
         :items="tareas"
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
            >{{ props.item.descripcion }}</td>
            <td
               class="text-xs-right"
               :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
            >{{ props.item.valor }}</td>
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
   </v-layout>
</template>

<script>
import dialogdelete from "../../Modals/DialogDelete.vue";
import dialogedit from "../../Modals/Task/EditDialog.vue";

export default {
   components: {
      dialogedit,
      dialogdelete
   },
   props: ["tareas"],
   data: () => ({
      search: "",
      dialogDelete: false,
      dialogEdit: false,
      mensaje: "",
      title: "Eliminar Tarea?",
      text: "Seguro que quieres eliminar esta Tarea.",
      tarea: {
         id: null
      },
      mensaje: "",
      headers: [
         {
            text: "Titulo:",
            align: "left",
            sortable: false,
            value: "titulo"
         },
         { text: "Descripción:", align: "center", value: "descripcion" },
         {
            text: "Valor:",
            align: "right",
            value: "valor"
         },
         { text: "Editar", align: "center", value: "" },
         { text: "Eliminar", align: "center", value: "" }
      ]
   }),
   methods: {
      buscar(id) {
         let self = this;
         axios.get("questionsfortask/" + id).then(function(res) {
            let item = self.tareas.find(function(c) {
               return c.id == id;
            });
            item.preguntas = res.data;
            self.tarea = item;
         });
      },
      eliminar() {
         let self = this;
         if (this.tarea.id != null) {
            axios.delete("tasks/" + this.tarea.id).then(function(res) {
               self.mensaje = res.data;
               if (res.data.type === "success") {
                  self.$emit("speak", {
                     Open: false
                  });
               }
            });
         }
      },
      borrarMethod: function(msg) {
         this.dialogDelete = msg.dialogdelete;
         if (msg.Delete) this.eliminar();
      },
      editarMethod: function(msg) {
         this.dialogEdit = msg.Open;
         if (msg.Status == "success")
            this.$emit("speak", {
               Open: msg.Open
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
   }
};
</script>

<style scoped>
</style>
