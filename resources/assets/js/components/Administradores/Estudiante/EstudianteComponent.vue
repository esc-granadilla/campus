<template>
   <v-form ref="form">
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="estudiante.nombre"
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
               v-model="estudiante.primer_apellido"
               :rules="[rules.required, rules.between]"
               counter
               label="Primer Apellido"
               name="primer_apellido"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               v-model="estudiante.segundo_apellido"
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
                     v-model="estudiante.fecha_nacimiento"
                     label="Fecha Nacimiento"
                     name="fecha_nacimiento"
                     prepend-icon="event"
                     required
                     readonly
                     v-on="on"
                  ></v-text-field>
               </template>
               <v-date-picker
                  ref="picker"
                  v-model="estudiante.fecha_nacimiento"
                  :max="fechamax()"
                  min="1990-01-01"
                  @change="save"
               ></v-date-picker>
            </v-menu>
         </v-flex>
      </v-layout>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="sections"
               item-text="seccion"
               item-value="id"
               return-object
               v-model="section"
               label="Sección"
               d-block
            ></v-select>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="adecuaciones"
               item-text="text"
               item-value="value"
               return-object
               v-model="estudiante.adecuacion"
               label="Adecuaciòn"
               d-block
               :rules="[rules.required]"
            ></v-select>
         </v-flex>
      </v-layout>
   </v-form>
</template>

<script>
export default {
   name: "estudiante_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         rules: {
            required: value => !!value || "Requerido.",
            between: v =>
               (!!v && (v.length >= 3 && v.length < 41)) ||
               "Entre 3 y 40 Caracteres"
         },
         estudiante: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: null,
            section_id: null,
            adecuacion: "",
            estado: 1
         },
         sections: [],
         section: {},
         adecuaciones: ["Ninguna", "Moderada", "Significativa"],
         menu: false
      };
   },
   methods: {
      fechamax() {
         let date = new Date();
         date.setFullYear(date.getFullYear() - 5);
         return date.toISOString().substr(0, 10);
      },
      save(date) {
         this.$refs.menu.save(date);
      }
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.estudiante));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.estudiante.id = val.id;
            this.estudiante.cedula = val.cedula;
            this.estudiante.nombre = val.nombre;
            this.estudiante.primer_apellido = val.primer_apellido;
            this.estudiante.segundo_apellido = val.segundo_apellido;
            this.estudiante.fecha_nacimiento = val.fecha_nacimiento;
            this.estudiante.adecuacion = val.adecuacion;
            this.estudiante.section_id = val.section_id;
            this.estudiante.estado = val.estado;
            this.estudiante.seccion = val.seccion;
            this.section = val.seccion;
         }
      },
      section(val) {
         if (!!val) {
            this.estudiante.seccion = val;
            this.estudiante.section_id = val.id;
         }
      },
      restaurar(val) {
         if (val) {
            this.$refs.form.reset();
            this.section = {};
         }
      },
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   },
   mounted() {
      axios.get("/sections").then(res => (this.sections = res.data));
   }
};
</script>

<style scoped>
</style>