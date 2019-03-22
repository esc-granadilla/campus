<template>
   <v-layout wrap mx-5>
      <v-flex xs12 pt-2>
         <v-text-field
            xs12
            v-model="user.email"
            :rules="emailRules"
            label="E-mail"
            name="email"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="user.name"
            :rules="[rules.required, rules.min]"
            :counter="8"
            label="Usuario"
            name="name"
            required
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="user.password"
            :append-icon="show ? 'visibility' : 'visibility_off'"
            :rules="[rules.required, rules.min, rules.max]"
            :type="show ? 'text' : 'password'"
            name="password"
            label="Ingrese su Contraseña"
            hint="Min 8 Caracteres a 32"
            :counter="8"
            @click:append="show = !show"
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="user.password_confirmation"
            :append-icon="show ? 'visibility' : 'visibility_off'"
            :rules="[rules.required, rules.min, rules.max]"
            :type="show ? 'text' : 'password'"
            name="password_confirmation"
            label="Confirme su Contraseña"
            hint="Min 8 Caracteres a 32"
            :counter="8"
            @click:append="show = !show"
         ></v-text-field>
      </v-flex>
   </v-layout>
</template>
                 
<script>
export default {
   name: "usercomponent",
   data() {
      return {
         show: false,
         user: {
            name: "",
            email: "",
            password: "",
            password_confirmation: ""
         },
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length <= 32 || "Maximo 32 Caracteres"
         },
         emailRules: [
            v => !!v || "E-mail es requerido",
            v => /.+@.+/.test(v) || "E-mail debe ser valido"
         ]
      };
   },
   methods: {}
};
</script>

<style scoped>
</style>
