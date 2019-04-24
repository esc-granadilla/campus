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
            :rules="[rules.required, rules.min , rules.max]"
            :counter="32"
            label="Usuario"
            name="name"
            int="Min 6 Caracteres a 32"
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
            hint="Min 6 Caracteres a 32"
            :counter="32"
            @click:append="show = !show"
         ></v-text-field>
      </v-flex>
      <v-flex xs12 pt-2>
         <v-text-field
            v-model="user.password_confirmation"
            :append-icon="show1 ? 'visibility' : 'visibility_off'"
            :rules="ConfirmationRules"
            :type="show1 ? 'text' : 'password'"
            name="password_confirmation"
            label="Confirme su Contraseña"
            hint="Min 6 Caracteres a 32"
            :counter="32"
            @click:append="show1 = !show1"
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
         show1: false,
         user: {
            name: "",
            email: "",
            password: "",
            password_confirmation: ""
         },
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 6 || "Min 6 Caracteres",
            max: v => v.length <= 32 || "Maximo 32 Caracteres"
         },
         emailRules: [
            v => !!v || "E-mail es requerido",
            v => /.+@.+/.test(v) || "E-mail debe ser valido"
         ],
         ConfirmationRules: [
            v => !!v || "Confirmacion de comtraseña requerida",
            v => v == this.user.password || "Las contraseñas no concuerdan"
         ]
      };
   },
   methods: {}
};
</script>

<style scoped>
</style>
