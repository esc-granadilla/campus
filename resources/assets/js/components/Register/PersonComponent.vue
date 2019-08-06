<template>
   <v-layout wrap mx-5>
      <v-flex xs12 pt-2>
         <v-text-field
            xs12
            v-model="person.cedula"
            :rules="[rules.required, rules.cedula]"
            :mask="mask"
            label="Cedula"
            name="cedula"
            :return-masked-value="false"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="person.nombre"
            :rules="[rules.required, rules.between]"
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
            :rules="[rules.required, rules.between]"
            counter
            label="Primer Apellido"
            name="primer_apellido"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="person.segundo_apellido"
            :rules="[rules.required, rules.between]"
            counter
            label="Segundo Apellido"
            name="segundo_apellido"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-menu
            ref="menu"
            id="menufecha"
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
               :max="fechamax()"
               min="1940-01-01"
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
            cedula: v => v.length == 9 || "La cedula no es valida",
            between: v =>
               (v.length >= 3 && v.length < 41) || "Entre 3 y 40 Caracteres"
         },
         mask: "#########"
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
      fechamax() {
         let date = new Date();
         date.setFullYear(date.getFullYear() - 5);
         return date.toISOString().substr(0, 10);
      }
   }
};
</script>

<style>
.v-date-picker-table--date {
   min-height: 350px;
}
</style>