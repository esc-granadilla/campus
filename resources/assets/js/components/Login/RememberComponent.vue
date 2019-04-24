<template>
   <div class="box2">
      <v-stepper class="hidden-sm-and-down">
         <v-stepper-header>
            <v-stepper-step step="1" complete>Ingresa tu correo</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="2" complete>Enviar link de resturación</v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step step="3">Accede a tu correo</v-stepper-step>
         </v-stepper-header>
      </v-stepper>
      <div class="box1">
         <v-layout justify-center>
            <v-flex xs12 sm8 md4>
               <v-card fluid class="elevation-12">
                  <v-toolbar dark class="py-3">
                     <v-toolbar-title>Olvidate tu contraseña</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>
                  <v-card-text class="pb-0">
                     <v-text-field
                        prepend-icon="email"
                        name="email"
                        label="Correo Electrónico"
                        type="text"
                        v-model="email"
                        :rules="emailRules"
                     ></v-text-field>
                     <!--</v-form>-->
                  </v-card-text>
                  <v-card-actions>
                     <!--<v-btn color="teal" @click="sendLoginRequest" block dark>Ingresar</v-btn>-->
                     <v-btn round dark color="green" block type="submit">Enviar link restauración</v-btn>
                  </v-card-actions>
               </v-card>
            </v-flex>
         </v-layout>
      </div>
   </div>
</template>

<script>
//const axios = require("axios");
export default {
   data() {
      return {
         email: "",
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
.box1 {
   margin-top: 40px;
}
.box2 {
   margin-top: 90px;
}
.father {
   background-color: red;
}
.center {
   justify-content: center;
}
</style>


