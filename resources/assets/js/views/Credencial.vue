<template>
   <v-card>
      <v-card-title>
         Profesores
         <v-spacer></v-spacer>
         <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
         ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="profesores" :search="search">
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
         >Your search for "{{ search }}" found no results.</v-alert>
      </v-data-table>
   </v-card>
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
               axios.post("/credencial", {
                  user_id: index.user_id,
                  rol: "Administrador",
                  attach: false
               });
               index.administrador = false;
            } else {
               axios.post("/credencial", {
                  user_id: index.user_id,
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
               axios.post("/credencial", {
                  user_id: index.user_id,
                  rol: "Profesor",
                  attach: false
               });
               index.profesor = false;
            } else {
               axios.post("/credencial", {
                  user_id: index.user_id,
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