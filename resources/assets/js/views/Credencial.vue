<template>
   <div>
      <h1>Hola desde credenciales</h1>
   </div>
</template>

<script>
export default {
   data() {
      return {
         profesores: [],
         roles: []
      };
   },
   mounted() {
      axios.get("/profesors").then(res => (this.profesores = res.data));
      axios.get("/roles").then(res => (this.roles = res.data));
   },
   methods: {}
};
</script>

<style scoped>
</style>


