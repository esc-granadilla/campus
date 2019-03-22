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
      <v-data-table :headers="headers" :items="dessertss" :search="search">
         <template v-slot:items="props">
            <td>{{ props.item.nombre }}</td>
            <td class="text-xs-right">{{ props.item.cedula }}</td>
            <td class="text-xs-right">{{ props.item.puesto }}</td>
            <td class="text-xs-right">{{ props.item.telefono }}</td>
            <td class="text-xs-right">
               <v-checkbox v-model="props.item.administrador"></v-checkbox>
            </td>
            <td class="text-xs-right">
               <v-checkbox v-model="props.item.profesor"></v-checkbox>
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
         roles: [],
         search: "",
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
      axios.get("/profesors").then(res => (this.profesores = res.data));
      axios.get("/roles").then(res => (this.roles = res.data));
   },
   computed: {
      roless: function() {
         var bar = [];
         for (var i = 0, l = this.roles.length; i < l; i++) {
            bar[i] = this.roles[i];
         }
         bar.sort(function(a, b) {
            if (a.nombre > b.nombre) {
               return 1;
            }
            if (a.nombre < b.nombre) {
               return -1;
            }
            return 0;
         }).pop();
         return bar;
      },
      dessertss: function() {
         var des = [];
         var j = 0;
         for (var i = 0, l = this.profesores.length; i < l; i++) {
            if (this.profesores[i].estado === 1) {
               des[j] = {
                  nombre: this.profesores[i].nombre,
                  cedula: this.profesores[i].cedula,
                  puesto: this.profesores[i].puesto,
                  telefono: this.profesores[i].telefono1,
                  administrador: false,
                  profesor: false
               };
               j++;
            }
         }
         return des;
      }
   },
   methods: {}
};
</script>

<style scoped>
</style>


