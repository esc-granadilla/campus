<template>
   <v-layout wrap row>
      <v-toolbar color="blue darken-2" dark xs12 class="mar">
         <v-text-field
            class="mx-3"
            flat
            label="Buscar por Cedula"
            prepend-inner-icon="search"
            solo-inverted
            v-model="search"
            @keydown="buscar()"
         ></v-text-field>
      </v-toolbar>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="estudiante.nombre"
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
               v-model="estudiante.primer_apellido"
               :rules="[rules.required, rules.mini]"
               counter
               label="Primer Apellido"
               name="primer_apellido"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="estudiante.segundo_apellido"
               :rules="[rules.required, rules.mini]"
               counter
               label="Segundo Apellido"
               name="segundo_apellido"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-menu
               ref="menu"
               v-model="menu"
               :close-on-content-click="false"
               :nudge-right="40"
               lazy
               transition="scale-transition"
               offset-y
               full-width
               min-width="290px"
            >
               <template v-slot:activator="{ on }">
                  <v-text-field
                     v-model="estudiante.fecha_nacimiento"
                     label="Fecha Nacimiento"
                     name="fecha_nacimiento"
                     prepend-icon="event"
                     readonly
                     v-on="on"
                  ></v-text-field>
               </template>
               <v-date-picker
                  ref="picker"
                  v-model="estudiante.fecha_nacimiento"
                  :max="new Date().toISOString().substr(0, 10)"
                  min="1950-01-01"
                  @change="save"
               ></v-date-picker>
            </v-menu>
         </v-flex>
      </v-layout>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="grados"
               item-text="text"
               item-value="value"
               return-object
               v-model="grado"
               label="Grado"
               d-block
            ></v-select>
         </v-flex>
         <v-text-field v-model="gradotxt" name="grado" v-show="false" required></v-text-field>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="adecuaciones"
               item-text="text"
               item-value="value"
               return-object
               v-model="adecuacion"
               label="Adecuaciòn"
               d-block
            ></v-select>
         </v-flex>
         <v-text-field v-model="adecuaciontxt" name="adecuacion" v-show="false" required></v-text-field>
         <v-flex xs12 d-flex px-3 mt-5>
            <v-btn round dark flat color="green" block @click="editar">Actualizar Datos</v-btn>
         </v-flex>
      </v-layout>
   </v-layout>
</template>

<script>
export default {
   name: "editarcomponent",
   data() {
      return {
         search: "",
         estudiante: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: null,
            grado: "",
            adecuacion: ""
         },
         grado: { value: 1, text: "Primero" },
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" }
         ],
         adecuacion: { value: 1, text: "Ninguna" },
         adecuaciones: [
            { value: 1, text: "Ninguna" },
            { value: 2, text: "Moderada" },
            { value: 3, text: "Significativa" }
         ],
         menu: false,
         mensaje: [],
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         }
      };
   },
   watch: {
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   },
   methods: {
      save(date) {
         this.$refs.menu.save(date);
      },
      buscar(event) {
         var self = this;
         if (window.event.keyCode == 13) {
            axios
               .get("estudiantes/" + this.search)
               .then(res => (this.estudiante = res.data));
         }
      },
      editar() {
         if (this.estudiante.id != null) {
            axios
               .put("estudiantes/" + this.estudiante.id, this.estudiante)
               .then(res => (this.mensaje = res.data));
         }
      }
   },
   computed: {
      gradotxt: function() {
         this.estudiante.grado = this.grado.value;
         return this.grado.value;
      },
      adecuaciontxt: function() {
         this.estudiante.adecuacion = this.adecuacion.text;
         return this.adecuacion.text;
      }
   },
   watch: {
      estudiante: function(val) {
         if (val.grado === "") {
            this.grado = { value: 1, text: "Primero" };
            this.adecuacion = { value: 1, text: "Ninguna" };
         } else {
            this.grado = this.grados.find(function(element) {
               return element.value == val.grado;
            });
            this.adecuacion = this.adecuaciones.find(function(element) {
               return element.text == val.adecuacion;
            });
         }
      }
   }
};
</script>

<style scoped>
.mar {
   margin-bottom: 5em;
}
</style>