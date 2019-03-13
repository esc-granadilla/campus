<template>
  <v-layout wrap mx-5>
    <v-flex xs12 pt-2>
      <v-text-field
        xs12
        v-model="person.cedula"
        :rules="[rules.required, rules.min]"
        label="Cedula"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 pt-2>
      <v-text-field
        v-model="person.nombre"
        :rules="[rules.required, rules.min]"
        :counter="10"
        label="Nombre"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 pt-2>
      <v-text-field
        xs12
        v-model="person.primer_apellido"
        :rules="[rules.required, rules.min]"
        label="Primer Apellido"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 pt-2>
      <v-text-field
        v-model="person.segundo_apellido"
        :rules="[rules.required, rules.min]"
        :counter="10"
        label="Segundo Apellido"
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
  name: "person",
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
        min: v => v.length >= 8 || "Min 8 Caracteres"
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