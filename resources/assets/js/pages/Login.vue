<template>
   <div class="box1">
      <ul class="bubble-boxes mt-5">
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
      </ul>
      <v-layout justify-center>
         <v-flex xs12 sm8 md4>
            <v-card fluid class="elevation-12">
               <v-toolbar dark class="py-3">
                  <v-toolbar-title>Ingreso al sistema</v-toolbar-title>
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
                  <v-text-field
                     v-model="password"
                     :append-icon="show1 ? 'visibility' : 'visibility_off'"
                     :rules="[rules.required, rules.min]"
                     :type="show1 ? 'text' : 'password'"
                     name="password"
                     label="Contraseña"
                     hint="At least 8 characters"
                     prepend-icon="lock"
                     counter
                     @click:append="show1 = !show1"
                  ></v-text-field>
                  <v-switch class="center" v-model="switch1" label="Recordarme" name="remember"></v-switch>
               </v-card-text>
               <v-card-actions>
                  <v-btn round dark color="green" block type="submit">Ingresar</v-btn>
                  <v-spacer></v-spacer>
                  <p style="font-size:12pt;">
                     <a href="/password/reset">Recuperar contraseña</a>
                  </p>
               </v-card-actions>
            </v-card>
         </v-flex>
      </v-layout>
   </div>
</template>

<script>
export default {
   data() {
      return {
         show1: false,
         email: "",
         password: "",
         switch1: true,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 8 || "Min 8 caracteres"
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
.box1 {
   margin-top: 150px;
}
.father {
   background-color: red;
}
.center {
   justify-content: center;
}
.bubble-boxes {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 40%;
}

.bubble-boxes li {
   position: absolute;
   list-style: none;
   display: flex;
   width: 20px;
   height: 20px;
   background: rgba(255, 255, 255, 0.2);
   animation: animate 25s linear infinite;
   bottom: -800px;
}

.bubble-boxes li:nth-child(1) {
   left: 25%;
   width: 80px;
   height: 80px;
   animation-delay: 0;
}

.bubble-boxes li:nth-child(2) {
   left: 10%;
   width: 20px;
   height: 20px;
   animation-delay: 2s;
   animation-duration: 12s;
}

.bubble-boxes li:nth-child(3) {
   left: 70%;
   width: 20px;
   height: 20px;
   animation-delay: 4s;
}

.bubble-boxes li:nth-child(4) {
   left: 40%;
   width: 60px;
   height: 60px;
   animation-delay: 0s;
   animation-duration: 18s;
}

.bubble-boxes li:nth-child(5) {
   left: 65%;
   width: 20px;
   height: 20px;
   animation-delay: 0s;
}

.bubble-boxes li:nth-child(6) {
   left: 75%;
   width: 110px;
   height: 110px;
   animation-delay: 3s;
}

.bubble-boxes li:nth-child(7) {
   left: 35%;
   width: 150px;
   height: 150px;
   animation-delay: 7s;
}

.bubble-boxes li:nth-child(8) {
   left: 50%;
   width: 25px;
   height: 25px;
   animation-delay: 15s;
   animation-duration: 45s;
}

.bubble-boxes li:nth-child(9) {
   left: 20%;
   width: 15px;
   height: 15px;
   animation-delay: 2s;
   animation-duration: 35s;
}

.bubble-boxes li:nth-child(10) {
   left: 85%;
   width: 150px;
   height: 150px;
   animation-delay: 0s;
   animation-duration: 12s;
}

@keyframes animate {
   0% {
      transform: translateY(0) rotate(0deg);
      opacity: 1;
      border-radius: 0;
   }

   100% {
      transform: translateY(-1000px) rotate(720deg);
      opacity: 1;
      border-radius: 50%;
   }
}
</style>


