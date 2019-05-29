<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogselect" max-width="440" persistent>
         <v-card>
            <v-card-title class="headline">Cree la lección</v-card-title>

            <v-card-text>
               <v-combobox v-model="day" :items="dias" label="Seleccione el dia" item-text="dia"></v-combobox>
            </v-card-text>

            <v-card-text>
               <v-combobox
                  v-model="schedule"
                  :items="horarios"
                  label="Seleccione el Horario"
                  item-text="horario"
                  :disabled="disabled"
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
         select: null,
         dias: [],
         day: null,
         horarios: [],
         disabled: false,
         schedule: null
      };
   },
   props: ["dialogOpen", "lessons"],
   watch: {
      dialogOpen(val) {
         this.dialogselect = val;
      },
      lessons(val) {
         this.dias = [];
         val.forEach(lesson => {
            this.dias.push(lesson.dia);
         });
      },
      day(val) {
         lessons.forEach(lesson => {
            if (lesson.dia.id == val.id) {
               this.horarios == lesson.horarios;
               this.horarios.forEach(horario => {
                  horario.horario = `${horario.desde} a ${horario.hasta}`;
               });
            }
         });
         this.disabled = true;
      }
   }
};
</script>

<style scoped>
</style>
