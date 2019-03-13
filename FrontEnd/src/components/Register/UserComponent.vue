<template>
  <v-layout wrap mx-5>
    <v-flex xs12 pt-2>
      <v-text-field
        xs12
        v-model="user.email"
        :rules="[rules.required, rules.min]"
        label="E-mail"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 pt-2>
      <v-text-field
        v-model="user.name"
        :rules="[rules.required, rules.min]"
        :counter="10"
        label="Usuario"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 pt-2>
      <v-text-field
        v-model="user.password"
        :append-icon="show ? 'visibility' : 'visibility_off'"
        :rules="[rules.required, rules.min]"
        :type="show ? 'text' : 'password'"
        name="input-10-1"
        label="Ingrese su Contraseña"
        hint="Min 8 Caracteres"
        counter
        @click:append="show = !show"
      ></v-text-field>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  name: "user",
  data() {
    return {
      show: false,
      user: {
        password: "",
        name: "",
        email: ""
      },
      rules: {
        required: value => !!value || "Requerido.",
        min: v => v.length >= 8 || "Min 8 Caracteres"
      }
    };
  },
  methods: {}
};
</script>

<style scoped>
</style>
