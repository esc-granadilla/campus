<template>
   <v-form ref="form">
      <v-text-field
         xs12
         v-model="data.codigo"
         :rules="[rules.required, rules.mini]"
         counter
         label="*Codigo"
         name="codigo"
         required
      ></v-text-field>

      <v-text-field
         xs12
         v-model="data.nombre"
         :rules="[rules.required, rules.between]"
         counter
         label="*Nombre"
         name="nombre"
         required
      ></v-text-field>
      <v-text-field xs12 v-model="data.descripcion" counter label="Descripción" name="descripcion"></v-text-field>
   </v-form>
</template>

<script>
export default {
   name: "asignatura_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         rules: {
            required: value => !!value || "Requerido.",
            between: v =>
               (v.length >= 3 && v.length < 41) || "Entre 3 y 40 Caracteres",
            mini: v =>
               (v.length >= 3 && v.length < 9) || "Entre 3 y 8 Caracteres"
         },
         data: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         }
      };
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", this.data);
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.data.id = val.id;
            this.data.codigo = val.codigo;
            this.data.nombre = val.nombre;
            this.data.descripcion = val.descripcion;
            this.data.estado = val.estado;
         }
      },
      restaurar(val) {
         if (val)
            this.data = {
               id: null,
               codigo: "",
               nombre: "",
               descripcion: "",
               estado: ""
            };
      }
   }
};
</script>

<style scoped>
</style>