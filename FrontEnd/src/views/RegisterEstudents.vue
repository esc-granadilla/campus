<template>
  <div id="appregister">
    <v-layout justify-center mt-5>
      <v-flex xs12 md6 offset-md3>
        <v-card>
          <v-progress-linear color="success" height="5" :value="nextindex * 33.3"></v-progress-linear>
          <v-img class="black--text" height="200px" :src="image">
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12>
                  <span class="headline font-italic" text-xs-center>Datos Estudiante</span>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>

          <div>
            <UserComponent :class="{'d-none': nextindex>1}"></UserComponent>
            <PersonComponent :class="{'d-none': nextindex!==2}"></PersonComponent>
            <div :class="{'d-none': nextindex<3}">
              <v-layout wrap mx-5>
                <v-flex xs12 d-flex>
                  <v-select :items="grado" label="Grado"></v-select>
                </v-flex>
                <v-flex xs12 d-flex>
                  <v-select :items="adecuacion" label="Adecuaciòn"></v-select>
                </v-flex>
              </v-layout>
            </div>
          </div>

          <v-card-actions>
            <v-btn round dark flat color="green" block @click="next" :class="registrar">Registarce</v-btn>
            <v-btn round dark flat color="blue" block @click="next" :class="ocultarNext">Siguiente</v-btn>
            <v-btn round block dark flat color="red" @click="back" :class="ocultarback">Atras</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>

      <v-flex></v-flex>
    </v-layout>
  </div>
</template>

<script>
import UserComponent from "@/components/Register/UserComponent.vue";
import PersonComponent from "@/components/Register/PersonComponent.vue";

export default {
  name: "appregister",
  components: {
    UserComponent,
    PersonComponent
  },
  data() {
    return {
      nextindex: 1,
      ocultarNext: "no",
      ocultarback: "si",
      registrar: "si",
      grado: ["Primero", "Segundo", "Tercero", "Cuarto", "Quinto"],
      adecuacion: ["Ninguna", "Moderada", "Significativa"],
      image: require("@/assets/img/studens1.jpg")
    };
  },
  methods: {
    next() {
      this.nextindex++;
      this.ocultarNext = this.nextindex > 2 ? "si" : "no";
      this.ocultarback = this.nextindex < 2 ? "si" : "no";
      this.registrar = this.nextindex === 3 ? "no" : "si";
    },
    back() {
      this.nextindex--;
      this.ocultarNext = this.nextindex > 2 ? "si" : "no";
      this.ocultarback = this.nextindex < 2 ? "si" : "no";
      this.registrar = this.nextindex === 3 ? "no" : "si";
    }
  }
};
</script>

<style scoped>
.nooo {
  height: 40px;
  background-color: black;
}
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
