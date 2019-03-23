<template>
   <v-layout wrap row>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="curso.codigo"
               :rules="[rules.required, rules.mini]"
               counter
               label="Codigo"
               name="codigo"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="curso.nombre"
               :rules="[rules.required, rules.mini]"
               counter
               label="Nombre"
               name="nombre"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="curso.descripcion"
               :rules="[rules.required, rules.mini]"
               counter
               label="Descripción"
               name="descripcion"
            ></v-text-field>
         </v-flex>
      </v-layout>
      <v-layout wrap mx-5 xs6>
         <v-flex xs12 d-flex px-3 mt-5>
            <v-flex xs12 d-flex px-3 mt-5>
               <v-btn round dark flat color="green" block @click="crear">Crear</v-btn>
            </v-flex>
            <v-flex xs12 d-flex px-3 mt-5>
               <v-btn round dark flat color="blue" block @click="editar">Actualizar</v-btn>
            </v-flex>
            <v-btn round dark flat color="red" block @click="eliminar">Eliminar</v-btn>
         </v-flex>
      </v-layout>
      <v-card>
         <v-card-title>
            Cursos
            <v-spacer></v-spacer>
            <v-text-field
               v-model="search"
               append-icon="search"
               label="Buscar por Nombre"
               single-line
               hide-details
            ></v-text-field>
         </v-card-title>
         <v-data-table :headers="headers" :items="cursos" :search="search">
            <template v-slot:items="props">
               <td>{{ props.item.nombre }}</td>
               <td class="text-center">{{ props.item.codigo }}</td>
               <td class="text-center">{{ props.item.descripcion }}</td>
               <td class="text-center">
                  <v-btn flat small color="primary" @click="buscar(props.item.id)">Seleccionar</v-btn>
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
   </v-layout>
</template>

<script>
export default {
   name: "cursocomponent",
   data() {
      return {
         search: "",
         curso: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         },
         cursos: [],
         mensaje: [],
         headers: [
            {
               text: "Nombre",
               align: "left",
               sortable: false,
               value: "nombre"
            },
            { text: "Codigo", value: "codigo" },
            { text: "Descripción", value: "descripcion" },
            { text: "Seleccione", value: "" }
         ],
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         }
      };
   },
   methods: {
      buscar(id) {
         axios
            .get("cursos/" + id + "/edit")
            .then(res => (this.curso = res.data));
      },
      crear() {
         var self = this;
         if (this.curso.nombre != "") {
            axios.post("cursos/", this.curso).then(function(res) {
               self.mensaje = res.data;
               axios.get("/cursos").then(res => (self.cursos = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.curso.id != null) {
            axios.delete("cursos/" + this.curso.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/cursos").then(res => (self.cursos = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.curso.id != null) {
            axios
               .put("cursos/" + this.curso.id, this.curso)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios.get("/cursos").then(res => (self.cursos = res.data));
               });
         }
      }
   },
   mounted() {
      axios.get("/cursos").then(res => (this.cursos = res.data));
   }
};
</script>

<style scoped>
</style>