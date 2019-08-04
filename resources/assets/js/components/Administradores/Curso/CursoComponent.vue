<template>
   <v-form ref="form">
      <v-select
         :items="profesores"
         item-text="name"
         item-value="id"
         return-object
         v-model="curso.profesor"
         label="*Profesor"
         d-block
         :rules="[rules.required]"
      ></v-select>
      <v-select
         :items="asignaturas"
         item-text="nombre"
         item-value="id"
         return-object
         v-model="curso.asignatura"
         label="*Asignatura"
         d-block
         :rules="[rules.required]"
      ></v-select>
      <v-select
         :items="secciones"
         item-text="seccion"
         item-value="id"
         return-object
         v-model="curso.seccion"
         label="*Sección"
         d-block
         :rules="[rules.required]"
      ></v-select>
   </v-form>
</template>

<script>
export default {
   name: "curso_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         curso: {
            id: null,
            nombre: "",
            profesor: null,
            seccion: null,
            asignatura: null,
            section_id: null,
            teacher_id: null,
            subject_id: null,
            estado: 1
         },
         asignaturas: [],
         profesores: [],
         rules: {
            required: value => !!value || "Requerido."
         },
         secciones: []
      };
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.curso));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.curso.id = val.id;
            this.curso.nombre = val.nombre;
            this.curso.profesor = val.profesor;
            this.curso.seccion = val.seccion;
            this.curso.asignatura = val.asignatura;
            this.curso.section_id = val.section_id;
            this.curso.teacher_id = val.teacher_id;
            this.curso.subject_id = val.subject_id;
            this.curso.estado = val.estado;
         }
      },
      restaurar(val) {
         if (val) this.$refs.form.reset();
      }
   },
   mounted() {
      let self = this;
      axios.get("/subjects").then(res => (this.asignaturas = res.data));
      axios.get("/sections").then(res => (this.secciones = res.data));
      axios.get("/teachers").then(function(res) {
         res.data.forEach(profesor => {
            profesor.name = `${profesor.nombre} ${profesor.primer_apellido} ${profesor.segundo_apellido}`;
         });
         self.profesores = res.data;
      });
   }
};
</script>

<style scoped>
</style>