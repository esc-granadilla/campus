<template>
   <div>
      <div class="alert">
         <v-alert v-model="alert" dismissible :type="alerttype">{{ mensaje.message }}</v-alert>
      </div>
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
                  v-model="profesor.nombre"
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
                  v-model="profesor.primer_apellido"
                  :rules="[rules.required, rules.mini]"
                  counter
                  label="Primer Apellido"
                  name="primer_apellido"
                  required
               ></v-text-field>
            </v-flex>
            <v-flex xs6 pt-2 px-3>
               <v-text-field
                  v-model="profesor.segundo_apellido"
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
                        v-model="profesor.fecha_nacimiento"
                        label="Fecha Nacimiento"
                        name="fecha_nacimiento"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                     ></v-text-field>
                  </template>
                  <v-date-picker
                     ref="picker"
                     v-model="profesor.fecha_nacimiento"
                     :max="new Date().toISOString().substr(0, 10)"
                     min="1950-01-01"
                     @change="save"
                  ></v-date-picker>
               </v-menu>
            </v-flex>
         </v-layout>
         <v-layout wrap mx-5 xs6>
            <v-flex xs6 d-flex px-3>
               <v-text-field
                  v-model="profesor.puesto"
                  :rules="[rules.required, rules.max]"
                  counter
                  label="Puesto"
                  name="puesto"
                  required
                  xs12
               ></v-text-field>
            </v-flex>
            <v-flex xs6 pt-2 px-3>
               <v-menu
                  ref="menu2"
                  v-model="menu2"
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
                        v-model="profesor.fecha_ingreso"
                        label="Fecha Ingreso"
                        name="fecha_ingreso"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                     ></v-text-field>
                  </template>
                  <v-date-picker
                     ref="picker"
                     v-model="profesor.fecha_ingreso"
                     :max="new Date().toISOString().substr(0, 10)"
                     min="1950-01-01"
                     @change="save2"
                  ></v-date-picker>
               </v-menu>
            </v-flex>
            <v-flex xs6 d-flex px-3>
               <v-text-field
                  v-model="profesor.telefono1"
                  :rules="[rules.required, rules.min8]"
                  :counter="8"
                  xs12
                  label="1º Telefono"
                  name="telefono1"
               ></v-text-field>
            </v-flex>
            <v-flex xs6 d-flex px-3>
               <v-text-field
                  v-model="profesor.telefono2"
                  :rules="[rules.min8]"
                  :counter="8"
                  xs12
                  label="2º Telefono"
                  name="telefono2"
               ></v-text-field>
            </v-flex>
            <v-flex xs12 d-flex px-3 mt-5>
               <v-btn round dark flat color="green" block @click="editar">Actualizar Datos</v-btn>
            </v-flex>
         </v-layout>
      </v-layout>
   </div>
</template>

<script>
export default {
   name: "editarcomponent",
   data() {
      return {
         search: "",
         profesor: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: null,
            puesto: "",
            fecha_ingreso: null,
            telefono1: "",
            telefono2: ""
         },
         menu: false,
         menu2: false,
         alert: false,
         alerttype: "success",
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
      },
      menu2(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      },
      mensaje(val) {
         this.alert = true;
      }
   },
   methods: {
      save(date) {
         this.$refs.menu.save(date);
      },
      save2(date) {
         this.$refs.menu2.save(date);
      },
      buscar(event) {
         if (window.event.keyCode == 13) {
            axios
               .get("profesors/" + this.search + "/edit")
               .then(res => (this.profesor = res.data));
         }
      },
      editar() {
         if (this.profesor.id != null) {
            axios
               .put("profesors/" + this.search, this.profesor)
               .then(res => (this.mensaje = res.data));
         }
      }
   }
};
</script>

<style scoped>
.mar {
   margin-bottom: 5em;
}
.alert {
   position: absolute;
   z-index: 2;
   right: 0;
}
</style>