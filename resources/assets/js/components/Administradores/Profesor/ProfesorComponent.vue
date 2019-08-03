<template>
   <v-form ref="form">
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="profesor.nombre"
               :rules="[rules.required, rules.between]"
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
               :rules="[rules.required, rules.between]"
               counter
               label="Primer Apellido"
               name="primer_apellido"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="profesor.segundo_apellido"
               :rules="[rules.required, rules.between]"
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
                     required
                     v-on="on"
                  ></v-text-field>
               </template>
               <v-date-picker
                  ref="picker"
                  v-model="profesor.fecha_nacimiento"
                  :max="fechamax()"
                  min="1940-01-01"
                  @change="save"
               ></v-date-picker>
            </v-menu>
         </v-flex>
      </v-layout>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 d-flex px-3>
            <v-text-field
               v-model="profesor.puesto"
               :rules="[rules.required, rules.between]"
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
                     required
                     readonly
                     v-on="on"
                  ></v-text-field>
               </template>
               <v-date-picker
                  ref="picker"
                  v-model="profesor.fecha_ingreso"
                  :max="new Date().toISOString().substr(0, 10)"
                  min="1940-01-01"
                  @change="save2"
               ></v-date-picker>
            </v-menu>
         </v-flex>
         <v-flex xs6 d-flex px-3>
            <v-text-field
               v-model="profesor.telefono1"
               :rules="[rules.required, rules.telefono]"
               :counter="8"
               xs12
               label="1º Telefono"
               name="telefono1"
            ></v-text-field>
         </v-flex>
         <v-flex xs6 d-flex px-3>
            <v-text-field
               v-model="profesor.telefono2"
               :rules="[rules.telefono2]"
               :counter="8"
               xs12
               label="2º Telefono"
               name="telefono2"
            ></v-text-field>
         </v-flex>
      </v-layout>
   </v-form>
</template>

<script>
export default {
   name: "asignatura_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         rules: {
            required: value => !!value || "Requerido.",
            telefono: v =>
               (!!v && v.length == 8) || "EL telefonico no es valido",
            telefono2: v => !v || v.length == 8 || "EL telefonico no es valido",
            between: v =>
               (!!v && (v.length >= 3 && v.length < 41)) ||
               "Entre 3 y 40 Caracteres"
         },
         profesor: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: "",
            puesto: "",
            fecha_ingreso: "",
            telefono1: "",
            telefono2: "",
            estado: 1
         },
         menu: false,
         menu2: false
      };
   },
   methods: {
      fechamax() {
         let date = new Date();
         date.setFullYear(date.getFullYear() - 18);
         return date.toISOString().substr(0, 10);
      },
      save(date) {
         this.$refs.menu.save(date);
      },
      save2(date) {
         this.$refs.menu2.save(date);
      }
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.profesor));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.profesor.id = val.id;
            this.profesor.cedula = val.cedula;
            this.profesor.nombre = val.nombre;
            this.profesor.primer_apellido = val.primer_apellido;
            this.profesor.segundo_apellido = val.segundo_apellido;
            this.profesor.fecha_nacimiento = val.fecha_nacimiento;
            this.profesor.puesto = val.puesto;
            this.profesor.fecha_ingreso = val.fecha_ingreso;
            this.profesor.telefono1 = val.telefono1;
            this.profesor.telefono2 = val.telefono2;
            this.profesor.estado = val.estado;
         }
      },
      restaurar(val) {
         if (val) this.$refs.form.reset();
      },
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      },
      menu2(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   }
};
</script>

<style scoped>
</style>