<template>
   <div id="registerstudents">
      <v-layout justify-center mt-5>
         <v-flex xs12 md6 offset-md3>
            <v-card>
               <v-progress-linear
                  color="success"
                  height="5"
                  class="mb-0 mt-3"
                  :value="nextindex * 33.3"
               ></v-progress-linear>
               <v-img class="black--text" height="200px" :src="image">
                  <v-container fill-height fluid>
                     <v-layout fill-height>
                        <v-flex xs12 style="text-align: center;">
                           <h2
                              class="headline font-italic espejo font-weight-black"
                              text-xs-center
                           >{{title}}</h2>
                        </v-flex>
                     </v-layout>
                  </v-container>
               </v-img>

               <div>
                  <usercomponent :class="{'d-none': nextindex>1}"></usercomponent>
                  <personcomponent :class="{'d-none': nextindex!==2}"></personcomponent>
                  <div :class="{'d-none': nextindex<3}">
                     <v-layout wrap mx-5>
                        <v-flex xs12 d-flex>
                           <v-select
                              :items="grados"
                              item-text="text"
                              item-value="value"
                              return-object
                              v-model="grado"
                              label="Grado"
                              d-block
                           ></v-select>
                        </v-flex>
                        <v-text-field v-model="gradotxt" name="grado" v-show="false" required></v-text-field>
                        <v-flex xs12 d-flex>
                           <v-select
                              :items="adecuaciones"
                              item-text="text"
                              item-value="value"
                              return-object
                              v-model="adecuacion"
                              label="Adecuaciòn"
                              d-block
                           ></v-select>
                        </v-flex>
                        <v-text-field
                           v-model="adecuaciontxt"
                           name="adecuacion"
                           v-show="false"
                           required
                        ></v-text-field>
                        <div :class="ocultarParentesco">
                           <v-layout wrap>
                              <h3 mt-3>Datos encargado del estudiante</h3>
                              <hr>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    xs12
                                    v-model="encargado.cedula"
                                    :rules="[rules.required, rules.min]"
                                    label="Cedula"
                                    name="encargado_cedula"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.nombre"
                                    :rules="[rules.required, rules.mini]"
                                    counter
                                    label="Nombre"
                                    name="encargado_nombre"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    xs12
                                    v-model="encargado.primer_apellido"
                                    :rules="[rules.required, rules.mini]"
                                    counter
                                    label="Primer Apellido"
                                    name="encargado_apellido1"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.segundo_apellido"
                                    :rules="[rules.required, rules.mini]"
                                    counter
                                    label="Segundo Apellido"
                                    name="encargado_apellido2"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.parentesco"
                                    :rules="[rules.required, rules.mini]"
                                    label="Parentesco"
                                    name="encargado_parentesco"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.telefono"
                                    :rules="[rules.required, rules.min8]"
                                    :counter="8"
                                    label="Telefono"
                                    name="encargado_telefono"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    xs12
                                    v-model="encargado.email"
                                    :rules="emailRules"
                                    label="E-mail"
                                    name="encargado_email"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                           </v-layout>
                        </div>
                        <v-btn round block dark flat color="info" @click="show">{{encargadotext}}</v-btn>
                     </v-layout>
                  </div>
               </div>

               <v-card-actions>
                  <v-btn
                     round
                     dark
                     flat
                     color="green"
                     block
                     type="submit"
                     :class="registrar"
                  >Registarce</v-btn>
                  <v-btn
                     round
                     dark
                     flat
                     color="blue"
                     block
                     @click="next"
                     :class="ocultarNext"
                  >Siguiente</v-btn>
                  <v-btn round block dark flat color="red" @click="back" :class="ocultarback">Atras</v-btn>
               </v-card-actions>
            </v-card>
         </v-flex>

         <v-flex></v-flex>
      </v-layout>
   </div>
</template>

<script>
import usercomponent from "../components/Register/UserComponent.vue";
import personcomponent from "../components/Register/PersonComponent.vue";

export default {
   name: "registerstudents",
   components: {
      usercomponent,
      personcomponent
   },
   data() {
      return {
         title: "Datos Usuario",
         nextindex: 1,
         ocultarNext: "no",
         ocultarback: "si",
         ocultarParentesco: "si",
         registrar: "si",
         grado: { value: 1, text: "Primero" },
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" }
         ],
         adecuacion: { value: 1, text: "Ninguna" },
         adecuaciones: [
            { value: 1, text: "Ninguna" },
            { value: 2, text: "Moderada" },
            { value: 3, text: "Significativa" }
         ],
         image: require("../../img/studens11.jpg"),
         encargadotext: "Ingresar Encargado",
         encargado: {
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            parentesco: "",
            telefono: "",
            email: ""
         },
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         },
         emailRules: [
            v => !!v || "E-mail es requerido",
            v => /.+@.+/.test(v) || "E-mail debe ser valido"
         ]
      };
   },
   methods: {
      next() {
         this.nextindex++;
         this.title = this.nextindex > 1 ? "Datos Estudiante" : "Datos Usuario";
         this.ocultarNext = this.nextindex > 2 ? "si" : "no";
         this.ocultarback = this.nextindex < 2 ? "si" : "no";
         this.registrar = this.nextindex === 3 ? "no" : "si";
      },
      back() {
         this.nextindex--;
         this.title = this.nextindex > 1 ? "Datos Estudiante" : "Datos Usuario";
         this.ocultarNext = this.nextindex > 2 ? "si" : "no";
         this.ocultarback = this.nextindex < 2 ? "si" : "no";
         this.registrar = this.nextindex === 3 ? "no" : "si";
      },
      show() {
         if (this.ocultarParentesco === "si") {
            this.ocultarParentesco = "no";
            this.title = "Datos Encargado";
            this.encargadotext = "No incluir Encargado";
         } else {
            this.ocultarParentesco = "si";
            this.encargado.cedula = "";
            this.encargado.nombre = "";
            this.encargado.primer_apellido = "";
            this.encargado.segundo_apellido = "";
            this.encargado.parentesco = "";
            this.encargado.telefono = "";
            this.encargado.email = "";
            this.title = "Datos Estudiante";
            this.encargadotext = "Ingresar Encargado";
         }
      },
      getText() {
         var values = this.grados.map(function(o) {
            return o.value;
         });
         var index = values.indexOf(this.grado);
         this.gradotxt = this.grados[index].text;
      }
   },
   computed: {
      gradotxt: function() {
         return this.grado.value;
      },
      adecuaciontxt: function() {
         return this.adecuacion.text;
      }
   }
};
</script>

<style scoped>
.no {
   display: block;
}
.si {
   display: none;
}
.headline {
   font-size: 20px !important;
}
.espejo {
   -webkit-box-reflect: below -15px -webkit-gradient(
         linear,
         left top,
         left bottom,
         from(transparent),
         to(rgba(255, 255, 255, 0.7))
      );
}
</style>
