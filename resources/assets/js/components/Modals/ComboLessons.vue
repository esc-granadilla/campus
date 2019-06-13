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
                  @click="dialogselect = false,$emit('speak', {dialogselect:false,Selected:false,Lesson:select})"
               >Salir</v-btn>

               <v-btn color="success" flat="flat" @click="salvar">Aceptar</v-btn>
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
         select: {
            id: null,
            dia: null,
            horario: null,
            schedule_id: null,
            day_id: null,
            course_id: null
         },
         dias: [],
         day: null,
         horarios: [],
         disabled: true,
         schedule: null
      };
   },
   props: ["dialogOpen", "lessons"],
   methods: {
      salvar() {
         if (this.select.day_id != null && this.select.schedule_id != null) {
            this.dialogselect = false;
            this.$emit("speak", {
               dialogselect: false,
               Selected: true,
               Lesson: this.select
            });
         } else
            this.$toast.error("Ingrese todos los datos", {
               y: "top",
               timeout: 6000
            });
      }
   },
   watch: {
      dialogOpen(val) {
         this.dialogselect = val;
      },
      lessons(val) {
         this.dias = [];
         val.forEach(lesson => {
            this.dias.push(lesson.dia);
         });
         this.day = null;
         this.horarios = [];
         this.disabled = true;
         this.schedule = null;
         this.select.day_id = null;
         this.select.schedule_id = null;
      },
      day(val) {
         if (val != null) {
            this.lessons.forEach(lesson => {
               if (lesson.dia.id == val.id) {
                  if (Array.isArray(lesson.horario)) {
                     this.horarios = lesson.horario;
                     this.horarios.forEach(horario => {
                        horario.horario = `${horario.desde} a ${horario.hasta}`;
                     });
                  } else {
                     this.horarios = [];
                     this.horarios[0] = lesson.horario["1"];
                     this.horarios[0].horario = `${this.horarios[0].desde} a ${
                        this.horarios[0].hasta
                     }`;
                  }
               }
            });
            this.select.dia = val;
            this.select.day_id = val.id;
            this.disabled = false;
         }
      },
      schedule(val) {
         if (val != null) {
            this.select.horario = val;
            this.select.schedule_id = val.id;
         }
      }
   }
};
</script>

<style scoped>
</style>
