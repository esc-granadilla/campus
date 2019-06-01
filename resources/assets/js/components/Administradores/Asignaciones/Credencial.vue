<template>
   <v-flex md10 xs12 offset-md1>
      <v-flex xs12 pt-2 px-3>
         <v-toolbar dark color="green" class="py-1">
            <v-spacer></v-spacer>
            <v-toolbar-title>Roles de Maestros</v-toolbar-title>
            <v-spacer></v-spacer>
         </v-toolbar>
         <v-card>
            <v-card-title>
               Profesores
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
               :items="profesores"
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
                  <td>{{ props.item.nombre }}</td>
                  <td class="text-center">{{ props.item.cedula }}</td>
                  <td class="text-center">{{ props.item.puesto }}</td>
                  <td class="text-center">{{ props.item.telefono }}</td>
                  <td class="text-center">
                     <v-checkbox
                        :id="'a'+props.item.id"
                        v-model="props.item.administrador"
                        @click="checkadmin(props.item)"
                     ></v-checkbox>
                  </td>
                  <td class="text-center">
                     <v-checkbox
                        :id="'p'+props.item.id"
                        v-model="props.item.profesor"
                        @click="checkprofe(props.item)"
                     ></v-checkbox>
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
   </v-flex>
</template>

<script>
export default {
   data() {
      return {
         profesores: [],
         search: "",
         procheck: true,
         admcheck: true,
         headers: [
            {
               text: "Nombre",
               align: "left",
               sortable: false,
               value: "nombre"
            },
            { text: "Cedula", value: "cedula" },
            { text: "Puesto", value: "puesto" },
            { text: "Telefono", value: "telefono" },
            { text: "Administrador", value: "administrador" },
            { text: "Profesor", value: "profesor" }
         ]
      };
   },
   mounted() {
      axios.get("/roltouser").then(res => (this.profesores = res.data));
   },
   methods: {
      checkadmin(index) {
         if (this.admcheck) {
            let elt = document.getElementById("a" + index.id);
            if (elt.checked) {
               axios.post("credencial/" + index.user_id, {
                  rol: "Administrador",
                  attach: false
               });
               index.administrador = false;
            } else {
               axios.post("credencial/" + index.user_id, {
                  rol: "Administrador",
                  attach: true
               });
               index.administrador = true;
            }
         }
         this.admcheck = !this.admcheck;
      },
      checkprofe(index) {
         if (this.procheck) {
            let elt = document.getElementById("p" + index.id);
            if (elt.checked) {
               axios.post("credencial/" + index.user_id, {
                  rol: "Profesor",
                  attach: false
               });
               index.profesor = false;
            } else {
               axios.post("credencial/" + index.user_id, {
                  rol: "Profesor",
                  attach: true
               });
               index.profesor = true;
            }
         }
         this.procheck = !this.procheck;
      }
   }
};
</script>

<style scoped>
</style>