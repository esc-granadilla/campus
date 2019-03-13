<template>
  <div id="appregister">
    <v-layout justify-center mt-5>
      <v-flex sm12>
        <UserComponent :class="{'d-none': nextindex>1}"></UserComponent>
        <PersonComponent :class="{'d-none': nextindex!==2}"></PersonComponent>
        <div class="nooo" :class="{'d-none': nextindex<3}"></div>
        <div>
          <v-btn
            color="blue"
            block
            flat
            dark
            round
            @click="next"
            :class="{'d-none': nextindex>2}"
          >Siguiente</v-btn>
          <v-btn
            color="red"
            block
            flat
            dark
            round
            @click="back"
            :class="{'d-none': nextindex<2}"
          >Atras</v-btn>
        </div>
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
      nextindex: 1
    };
  },
  methods: {
    next() {
      this.nextindex++;
    },
    back() {
      this.nextindex--;
    }
  }
};
</script>

<style scoped>
.nooo {
  height: 40px;
  background-color: black;
}
</style>
