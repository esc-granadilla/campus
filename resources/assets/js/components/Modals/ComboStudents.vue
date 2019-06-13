<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogselect" max-width="440" persistent>
         <v-card>
            <v-card-title class="headline">Busque al Estudiante</v-card-title>

            <v-card-text>
               <v-combobox
                  v-model="select"
                  :items="Students"
                  label="Seleccione el estudiante"
                  item-text="name"
               ></v-combobox>
            </v-card-text>

            <v-card-actions>
               <v-spacer></v-spacer>

               <v-btn
                  color="grey darken-3"
                  flat="flat"
                  @click="dialogselect = false,$emit('speak', {dialogselect:false,Selected:false,Student:select})"
               >Salir</v-btn>

               <v-btn
                  color="success"
                  flat="flat"
                  @click="dialogselect = false,$emit('speak', {dialogselect:false,Selected:true,Student:select})"
               >Agregar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return { dialogselect: false, Students: [], select: null };
   },
   props: ["dialogOpens", "students"],
   watch: {
      dialogOpens(val) {
         this.dialogselect = val;
      },
      students(val) {
         this.Students = [];
         val.forEach(student => {
            student.name = `${student.cedula} ${student.nombre} ${
               student.primer_apellido
            } ${student.segundo_apellido}`;
            this.Students.push(student);
         });
      }
   }
};
</script>

<style scoped>
</style>
