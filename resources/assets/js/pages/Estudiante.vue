<template>
   <v-flex>
      <transition name="component-fade" mode="out-in">
         <router-view :estudiante_id="estudiante_id"></router-view>
      </transition>
   </v-flex>
</template>

<script>
export default {
   props: ["estudiante_id"],
   data: () => ({})
};
</script>

<style scoped>
.component-fade-enter-active,
.component-fade-leave-active {
   transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active below version 2.1.8 */ {
   opacity: 0;
}
.component-fade-leave-active {
   animation: bounce-in 0.5s reverse;
}
.component-fade-enter {
   animation: bounce-in 0.5s;
}
@keyframes bounce-in {
   0% {
      transform: translateY(-25%);
   }
   50% {
      transform: translateY(-75%);
   }
   100% {
      transform: translateY(0%);
   }
}
</style>
