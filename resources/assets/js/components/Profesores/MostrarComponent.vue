<template>
   <v-card>
      <v-card-title>
         Profesores
         <v-spacer></v-spacer>
         <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar por Cedula"
            single-line
            hide-details
         ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="lista" :search="search">
         <template v-slot:items="props">
            <td>{{ props.item.cedula }}</td>
            <td class="text-center">{{ props.item.nombre }}</td>
            <td class="text-center">{{ props.item.apellidos }}</td>
            <td class="text-center">{{ props.item.fecha_nacimiento }}</td>
            <td class="text-center">{{ props.item.puesto }}</td>
            <td class="text-center">{{ props.item.fecha_ingreso }}</td>
            <td class="text-center">{{ props.item.telefonos }}</td>
         </template>
         <v-alert
            v-slot:no-results
            :value="true"
            color="error"
            icon="warning"
         >Tu busqueda por "{{ search }}" no encontro resultados.</v-alert>
      </v-data-table>
   </v-card>
</template>

<script>
export default {
   data() {
      return {
         profesores: [],
         search: "",
         headers: [
            {
               text: "Cedula",
               align: "left",
               sortable: false,
               value: "cedula"
            },
            { text: "Nombre", value: "nombre" },
            { text: "Apellidos", value: "apellidos" },
            { text: "Fecha Nacimiento", value: "fecha_nacimiento" },
            { text: "Puesto", value: "puesto" },
            { text: "Fecha de Ingreso", value: "fecha_ingreso" },
            { text: "Telefonos", value: "telefonos" }
         ]
      };
   },
   computed: {
      lista: function() {
         var lis = [];
         for (let index = 0; index < this.profesores.length; index++) {
            lis[index] = {
               cedula: this.profesores[index].cedula,
               nombre: this.profesores[index].nombre,
               apellidos:
                  this.profesores[index].primer_apellido +
                  " " +
                  this.profesores[index].segundo_apellido,
               fecha_nacimiento: this.profesores[index].fecha_nacimiento,
               puesto: this.profesores[index].puesto,
               fecha_ingreso: this.profesores[index].fecha_ingreso,
               telefonos:
                  this.profesores[index].telefono1 +
                  (this.profesores[index].telefono2 !== null
                     ? " - " + this.profesores[index].telefono2
                     : "")
            };
         }
         return lis;
      }
   },
   mounted() {
      axios.get("/profesors").then(res => (this.profesores = res.data));
   }
};
</script>

<style scoped>
</style>