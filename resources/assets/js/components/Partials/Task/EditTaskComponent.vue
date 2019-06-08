<template>
   <v-layout>
      <dialogdelete
         :dialogDeletes="dialogDelete"
         :text="text"
         :title="title"
         v-on:speak="borrarMethod($event)"
      ></dialogdelete>
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
// import dialogedit from "./DialogEdit.vue";

export default {
   components: {
      // dialogedit,
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
         this.tarea = this.tareas.find(function(c) {
            return c.id == id;
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
