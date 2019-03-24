<template>
   <div id="registerprofesor">
      <v-layout justify-center mt-2>
         <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
            <v-card>
               <v-progress-linear
                  color="success"
                  height="5"
                  class="mb-0 mt-3"
                  :value="nextindex * 33.3"
               ></v-progress-linear>
               <v-img
                  class="black--text"
                  :class="subheading"
                  aspect-ratio="4"
                  height="200px"
                  contain
                  :src="image"
               >
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
                           <v-text-field
                              v-model="puesto"
                              :rules="[rules.required, rules.max]"
                              counter
                              label="Puesto"
                              name="puesto"
                              required
                           ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
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
                                    v-model="date"
                                    label="Fecha Ingreso"
                                    name="fecha_ingreso"
                                    prepend-icon="event"
                                    readonly
                                    xs12
                                    v-on="on"
                                 ></v-text-field>
                              </template>
                              <v-date-picker
                                 ref="picker"
                                 v-model="date"
                                 :max="new Date().toISOString().substr(0, 10)"
                                 min="1950-01-01"
                                 @change="save"
                              ></v-date-picker>
                           </v-menu>
                        </v-flex>
                        <v-flex xs12 d-flex>
                           <v-text-field
                              v-model="telefono1"
                              :rules="[rules.required, rules.min8]"
                              :counter="8"
                              label="1º Telefono"
                              name="telefono1"
                           ></v-text-field>
                        </v-flex>
                        <v-flex xs12 d-flex>
                           <v-text-field
                              v-model="telefono2"
                              :rules="[rules.min8]"
                              :counter="8"
                              label="2º Telefono"
                              name="telefono2"
                           ></v-text-field>
                        </v-flex>
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
   name: "registerprofesor",
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
         registrar: "si",
         menu: false,
         puesto: "",
         date: null,
         telefono1: "",
         telefono2: "",
         image: require("../../img/profebanner.jpg"),
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         }
      };
   },
   methods: {
      next() {
         this.nextindex++;
         this.title = this.nextindex > 1 ? "Datos Maestro" : "Datos Usuario";
         this.ocultarNext = this.nextindex > 2 ? "si" : "no";
         this.ocultarback = this.nextindex < 2 ? "si" : "no";
         this.registrar = this.nextindex === 3 ? "no" : "si";
      },
      back() {
         this.nextindex--;
         this.title = this.nextindex > 1 ? "Datos Maestro" : "Datos Usuario";
         this.ocultarNext = this.nextindex > 2 ? "si" : "no";
         this.ocultarback = this.nextindex < 2 ? "si" : "no";
         this.registrar = this.nextindex === 3 ? "no" : "si";
      },
      save(date) {
         this.$refs.menu.save(date);
      }
   },
   watch: {
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   },
   computed: {}
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
