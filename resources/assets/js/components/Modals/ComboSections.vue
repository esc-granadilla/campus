<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogselect" max-width="440" persistent>
         <v-card>
            <v-card-title class="headline">Busque la Sección</v-card-title>

            <v-card-text>
               <v-combobox
                  v-model="select"
                  :items="Sections"
                  label="Seleccione la sección"
                  item-text="name"
               ></v-combobox>
            </v-card-text>

            <v-card-actions>
               <v-spacer></v-spacer>

               <v-btn
                  color="grey darken-3"
                  flat="flat"
                  @click="dialogselect = false,$emit('speak', {dialogselect:false,Selected:false,Section:select})"
               >Salir</v-btn>

               <v-btn
                  color="success"
                  flat="flat"
                  @click="dialogselect = false,$emit('speak', {dialogselect:false,Selected:true,Section:select})"
               >Aceptar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         dialogselect: false,
         Sections: [],
         select: null,
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
   props: ["dialogOpent", "sections"],
   watch: {
      dialogOpent(val) {
         this.dialogselect = val;
      },
      sections(val) {
         this.Sections = [];
         val.forEach(section => {
            section.name = `Sección: ${section.seccion} Grado: ${
               this.grados.find(function(c) {
                  return c.value == section.grade_id;
               }).text
            }`;
            this.Sections.push(section);
         });
      }
   }
};
</script>

<style scoped>
</style>
