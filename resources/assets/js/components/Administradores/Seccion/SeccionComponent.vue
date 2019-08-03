<template>
   <v-form ref="form">
      <v-text-field
         xs12
         v-model="section.seccion"
         :rules="[rules.required, rules.between]"
         counter
         label="*Sección"
         name="seccion"
         required
      ></v-text-field>
      <v-select
         :items="grados"
         item-text="text"
         item-value="value"
         return-object
         v-model="grado"
         label="Grado"
         d-block
      ></v-select>
   </v-form>
</template>

<script>
export default {
   name: "seccion_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         rules: {
            required: v => !!v || "Requerido.",
            between: v =>
               (!!v && (v.length >= 3 && v.length < 11)) ||
               "Entre 3 y 10 Caracteres"
         },
         section: {
            id: null,
            seccion: "",
            grade_id: null,
            estado: 1
         },
         grado: { value: 1, text: "Primero" },
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" },
            { value: 6, text: "Sexto" }
         ]
      };
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.section));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.section.id = val.id;
            this.section.seccion = val.seccion;
            this.section.grade_id = val.grade_id;
            this.section.estado = val.estado;
            this.grado = this.grados.find(function(c) {
               return c.value == val.grade_id;
            });
         }
      },
      grado(val) {
         if (!!val) this.section.grade_id = this.grado.value;
      },
      restaurar(val) {
         if (val) {
            this.$refs.form.reset();
            this.grado = { value: 1, text: "Primero" };
         }
      }
   }
};
</script>

<style scoped>
</style>