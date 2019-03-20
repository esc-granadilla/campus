<template>
   <div class="box1">
      <v-layout justify-center>
         <v-flex xs12 sm8 md4>
            <v-card fluid class="elevation-12">
               <v-toolbar dark>
                  <v-toolbar-title>Ingreso al sistema</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card-text>
                  <!--<v-form>-->
                  <v-text-field
                     prepend-icon="email"
                     name="email"
                     label="Correo Electrónico"
                     type="text"
                  ></v-text-field>
                  <v-text-field
                     id="contraseña"
                     prepend-icon="lock"
                     name="password"
                     label="Contraseña"
                     type="password"
                  ></v-text-field>

                  <!--</v-form>-->
               </v-card-text>
               <v-card-actions>
                  <!--<v-btn color="teal" @click="sendLoginRequest" block dark>Ingresar</v-btn>-->
                  <v-btn round dark flat color="green" block type="submit">Ingresar</v-btn>
                  <v-spacer></v-spacer>
                  <p style="font-size:10pt;">
                     <a href="#">Recuperar contraseña</a>
                  </p>
               </v-card-actions>
            </v-card>
         </v-flex>
      </v-layout>
   </div>
</template>

<script>
//const axios = require("axios");
export default {
   data() {
      return {
         form: {
            email: "",
            password: ""
         }
      };
   },
   methods: {}
};
</script>

<style scoped>
.box1 {
   margin-top: 250px;
}
.father {
   background-color: red;
}
</style>


