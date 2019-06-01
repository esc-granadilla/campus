
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogCreate" persistent max-width="300px">
         <template v-slot:activator="{ on }">
            <v-btn class="green lighten-4" fab small absolute top left block v-on="on">+</v-btn>
         </template>
         <v-card>
            <v-card-title>
               <span class="headline">Curso Nuevo</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-select
                           :items="profesores"
                           item-text="name"
                           item-value="id"
                           return-object
                           v-model="curso.profesor"
                           label="*Profesor"
                           d-block
                        ></v-select>
                        <v-select
                           :items="asignaturas"
                           item-text="nombre"
                           item-value="id"
                           return-object
                           v-model="curso.asignatura"
                           label="*Asignatura"
                           d-block
                        ></v-select>
                        <v-select
                           :items="secciones"
                           item-text="seccion"
                           item-value="id"
                           return-object
                           v-model="curso.seccion"
                           label="*Sección"
                           d-block
                        ></v-select>
                     </v-form>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue darken-1" flat @click="dialogCreate = false">Cerrar</v-btn>
               <v-btn color="blue darken-1" flat @click="validar">Salvar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         dialogCreate: false,
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
   methods: {
      validar() {
         this.dialogCreate = false;
         this.$emit("speak", this.curso);
      }
   },
   mounted() {
      let self = this;
      axios.get("/subjects").then(res => (this.asignaturas = res.data));
      axios.get("/sections").then(res => (this.secciones = res.data));
      axios.get("/teachers").then(function(res) {
         res.data.forEach(profesor => {
            profesor.name = `${profesor.nombre} ${profesor.primer_apellido} ${
               profesor.segundo_apellido
            }`;
         });
         self.profesores = res.data;
      });
   }
};
</script>

<style scoped>
</style>
