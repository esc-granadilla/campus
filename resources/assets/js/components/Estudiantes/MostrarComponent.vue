<template>
   <v-flex md10 xs12 offset-md1>
      <v-flex xs12 pt-2 px-3>
         <v-toolbar dark color="green" class="py-1">
            <v-spacer></v-spacer>
            <v-toolbar-title>Listado de Estudiantes</v-toolbar-title>
            <v-spacer></v-spacer>
         </v-toolbar>
         <v-card>
            <v-card-title>
               Estudiantes
               <v-spacer></v-spacer>
               <v-text-field
                  v-model="search"
                  append-icon="search"
                  label="Buscar por Cedula"
                  single-line
                  hide-details
               ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="estudiantes" :search="search">
               <template v-slot:items="props">
                  <td>{{ props.item.cedula }}</td>
                  <td class="text-center">{{ props.item.nombre }}</td>
                  <td
                     class="text-center"
                  >{{ props.item.primer_apellido }} {{' '}} {{ props.item.segundo_apellido }}</td>
                  <td class="text-center">{{ props.item.fecha_nacimiento }}</td>
                  <td class="text-center">{{ props.item.grado }}</td>
                  <td class="text-center">{{ props.item.adecuacion }}</td>
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
         search: "",
         headers: [
            {
               text: "Cedula",
               align: "left",
               sortable: false,
               value: "cedula"
            },
            { text: "Nombre", value: "nombre" },
            { text: "Apellidos", value: "primer_apellido" },
            { text: "Fecha Nacimiento", value: "fecha_nacimiento" },
            { text: "Grado", value: "grado" },
            { text: "Adecuación", value: "adecuacion" }
         ],
         estudiantes: []
      };
   },
   mounted() {
      axios.get("/estudiantes").then(res => (this.estudiantes = res.data));
   }
};
</script>

<style scoped>
</style>