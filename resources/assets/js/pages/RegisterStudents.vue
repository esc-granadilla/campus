<template>
   <div id="registerstudents">
      <v-layout justify-center mt-3>
         <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
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
                              class="headline font-italic font-weight-black"
                              text-xs-center
                           >{{title}}</h2>
                        </v-flex>
                     </v-layout>
                  </v-container>
               </v-img>

               <div>
                  <usercomponent v-show="!(nextindex>1)"></usercomponent>
                  <personcomponent v-show="!(nextindex!==2)"></personcomponent>
                  <div v-show="!(nextindex<3)">
                     <v-layout wrap mx-5>
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
                              <hr />
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    xs12
                                    v-model="encargado.cedula"
                                    :rules="[rules.required, rules.cedula]"
                                    label="Cedula"
                                    name="encargado_cedula"
                                    :mask="mask"
                                    :return-masked-value="false"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.nombre"
                                    :rules="[rules.required, rules.between]"
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
                                    :rules="[rules.required, rules.between]"
                                    counter
                                    label="Primer Apellido"
                                    name="encargado_apellido1"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.segundo_apellido"
                                    :rules="[rules.required, rules.between]"
                                    counter
                                    label="Segundo Apellido"
                                    name="encargado_apellido2"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.parentesco"
                                    :rules="[rules.required, rules.between]"
                                    label="Parentesco"
                                    name="encargado_parentesco"
                                    v-if="ocultarParentesco !== 'si'"
                                 ></v-text-field>
                              </v-flex>
                              <v-flex xs12 pt-2>
                                 <v-text-field
                                    v-model="encargado.telefono"
                                    :rules="[rules.required, rules.telefono]"
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
         title: "",
         nextindex: 1,
         ocultarNext: "no",
         ocultarback: "si",
         ocultarParentesco: "si",
         registrar: "si",
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
            telefono: v => v.length == 8 || "EL telefonico no es valido",
            cedula: v => v.length == 9 || "La cedula no es valida",
            between: v =>
               (v.length >= 3 && v.length < 41) || "Entre 3 y 40 Caracteres"
         },
         emailRules: [
            v => !!v || "E-mail es requerido",
            v => /.+@.+\..+/.test(v) || "E-mail debe ser valido"
         ],
         error: false,
         mask: "#-####-####"
      };
   },
   methods: {
      next() {
         this.getErrors();
         if (!this.error) {
            this.nextindex++;
            this.ocultarNext = this.nextindex > 2 ? "si" : "no";
            this.ocultarback = this.nextindex < 2 ? "si" : "no";
            this.registrar = this.nextindex === 3 ? "no" : "si";
         }
      },
      back() {
         this.nextindex--;
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
      getErrors() {
         this.error = false;
         var self = this;
         if (this.nextindex == 1) {
            var i = 0;
            $("input").each(function(index, value) {
               if (i < 5 && i > 0) {
                  if ($(this).val() == "" && !self.error) {
                     self.$toast.error("Ingrese todos los datos", {
                        y: "top",
                        timeout: 6000
                     });
                     self.error = true;
                  }
               }
               i++;
            });
         } else if (this.nextindex == 2) {
            var i = 0;
            $("input").each(function(index, value) {
               if (i < 10 && i > 4) {
                  if ($(this).val() == "" && !self.error) {
                     self.$toast.error("Ingrese todos los datos", {
                        y: "top",
                        timeout: 6000
                     });
                     self.error = true;
                  }
               }
               i++;
            });
         }
      }
   },
   computed: {
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
</style>
