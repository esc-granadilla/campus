<template>
   <v-layout wrap mx-5>
      <v-flex xs12 pt-2>
         <v-text-field
            xs12
            v-model="person.cedula"
            :rules="[rules.required, rules.min]"
            label="Cedula"
            name="cedula"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="person.nombre"
            :rules="[rules.required, rules.mini]"
            counter
            label="Nombre"
            name="nombre"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            xs12
            v-model="person.primer_apellido"
            :rules="[rules.required, rules.mini]"
            counter
            label="Primer Apellido"
            name="primer_apellido"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="person.segundo_apellido"
            :rules="[rules.required, rules.mini]"
            counter
            label="Segundo Apellido"
            name="segundo_apellido"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
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
                  v-model="person.date"
                  label="Fecha Nacimiento"
                  name="fecha_nacimiento"
                  prepend-icon="event"
                  readonly
                  v-on="on"
               ></v-text-field>
            </template>
            <v-date-picker
               ref="picker"
               v-model="person.date"
               :max="new Date().toISOString().substr(0, 10)"
               min="1950-01-01"
               @change="save"
            ></v-date-picker>
         </v-menu>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   name: "personcomponent",
   data() {
      return {
         show: false,
         person: {
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            date: null
         },
         menu: false,
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
      }
   }
};
</script>

<style scoped>
</style>