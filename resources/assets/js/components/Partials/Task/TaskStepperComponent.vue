<template>
   <v-stepper v-model="e6" vertical>
      <v-stepper-step :complete="e6 > 1" step="1">
         Seleccione la asignatura de la tarea.
         <small>Selección unica</small>
      </v-stepper-step>

      <v-stepper-content step="1">
         <v-card color="white" class="mb-2" height="200px" light v-bar>
            <v-layout row>
               <v-layout align-center px-3>
                  <v-flex xs4>
                     <v-text-field label="Titulo" v-model="tarea.titulo"></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                     <v-text-field label="Descripción" v-model="tarea.descripcion"></v-text-field>
                  </v-flex>
                  <v-flex xs2>
                     <v-text-field label="Valor" v-model="tarea.valor" :mask="mask"></v-text-field>
                  </v-flex>
               </v-layout>
               <v-flex xs12>
                  <v-radio-group v-model="tarea.subject_id" row light>
                     <v-radio
                        v-for="item in subjects"
                        :key="item.id"
                        :label="item.nombre"
                        :value="item.id"
                        color="success"
                        class="pa-3"
                     ></v-radio>
                  </v-radio-group>
               </v-flex>
            </v-layout>
         </v-card>
         <v-btn color="primary" @click="e6 = part1">Siguiente</v-btn>
         <v-btn flat @click="close">Cancelar</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="e6 > 2" step="2">
         Ingrese las preguntas y opciones de respuesta.
         <small>Seleccione la respuesta correpta</small>
      </v-stepper-step>

      <v-stepper-content step="2">
         <v-card color="white" class="mb-2" height="200px" light>
            <v-layout row>
               <v-flex xs8 v-show="!next">
                  <v-card-text class="headline">
                     <v-textarea
                        name="pregunta"
                        box
                        :label="(puntero + 1) + ' Pregunta:'"
                        class="ma-2"
                        v-model="pregunta.pregunta"
                        auto-grow
                     ></v-textarea>
                  </v-card-text>
               </v-flex>
               <v-flex xs8 v-show="next" class="pa-3">
                  <span class="headline" style="color:#333;">Respuestas:</span>
                  <v-radio-group row light v-model="respuesta" class="mp">
                     <v-flex xs6 v-for="item in pregunta.respuestas" :key="item.id">
                        <v-layout align-center>
                           <v-radio :label="item.id" :value="item.id" color="primary"></v-radio>
                           <v-text-field placeholder="Ingrese su respuesta" v-model="item.opcion"></v-text-field>
                        </v-layout>
                     </v-flex>
                  </v-radio-group>
               </v-flex>
               <v-flex xs4>
                  <v-card-text class="headline">
                     <span style="color:#333;">Opciones:</span>
                  </v-card-text>
                  <v-switch
                     v-model="next"
                     :label="next ? 'Preguntas' : 'Respuestas'"
                     color="indigo"
                     class="mp"
                     hide-details
                  ></v-switch>
                  <v-btn outline color="primary" @click="agregar">Agregar</v-btn>
                  <v-btn outline color="error" @click="eliminar">Eliminar</v-btn>
                  <v-btn outline @click="volver">Volver a la anterior</v-btn>
               </v-flex>
            </v-layout>
         </v-card>
         <v-btn color="primary" @click="e6 = part2">Siguiente</v-btn>
         <v-btn flat @click="e6 = 1">Volver</v-btn>
         <v-btn flat @click="close">Cancelar</v-btn>
      </v-stepper-content>

      <v-stepper-step step="3">Confirme el custionario creado.</v-stepper-step>
      <v-stepper-content step="3">
         <v-card color="white" class="mb-2" height="200px" v-bar light px-2>
            <taskcomponent :type="'success'" :tarea="tareatemp"></taskcomponent>
         </v-card>
         <v-btn color="primary" @click="crear">Crear</v-btn>
         <v-btn flat @click="e6 = 2">Volver</v-btn>
         <v-btn flat @click="close">Cancelar</v-btn>
      </v-stepper-content>
   </v-stepper>
</template>

<script>
export default {
   data() {
      return {
         e6: 1,
         mask: "##.##",
         subjects: [],
         numero: 1,
         puntero: 0,
         mensaje: "",
         next: false,
         pregunta: {
            id: 0,
            task_id: 0,
            pregunta: "",
            opcion_a: "",
            opcion_b: "",
            opcion_c: "",
            opcion_d: "",
            respuestas: [
               { id: "A)", opcion: "", selected: false },
               { id: "B)", opcion: "", selected: false },
               { id: "C)", opcion: "", selected: false },
               { id: "D)", opcion: "", selected: false }
            ]
         },
         respuesta: null,
         tarea: {
            titulo: "",
            valor: "",
            descripcion: "",
            respuestas: "",
            subject_id: null,
            preguntas: []
         },
         tareatemp: {
            titulo: "",
            valor: "",
            descripcion: "",
            respuestas: "",
            subject_id: null,
            preguntas: []
         }
      };
   },
   props: ["sheet"],
   watch: {
      sheet(val) {
         if (!val) this.e6 = 1;
      },
      respuesta(val) {
         this.pregunta.respuestas.forEach(res => {
            res.selected = val == res.id;
         });
      },
      puntero(val) {
         if (this.tarea.preguntas[val] == null) {
            this.pregunta = {
               id: 0,
               task_id: 0,
               pregunta: "",
               opcion_a: "",
               opcion_b: "",
               opcion_c: "",
               opcion_d: "",
               respuestas: [
                  { id: "A)", opcion: "", selected: false },
                  { id: "B)", opcion: "", selected: false },
                  { id: "C)", opcion: "", selected: false },
                  { id: "D)", opcion: "", selected: false }
               ]
            };
            this.respuesta = null;
         } else {
            this.pregunta = this.tarea.preguntas[val];
            this.pregunta.respuestas.forEach(item => {
               if (item.selected) this.respuesta = item.id;
            });
         }
      },
      mensaje(val) {
         if (val.type === "success")
            this.$toast.success(val.message, {
               y: "top",
               timeout: 6000
            });
         else
            this.$toast.error(val.message, {
               y: "top",
               timeout: 6000
            });
      }
   },
   computed: {
      part1() {
         return this.tarea.subject_id != null &&
            this.tarea.titulo != "" &&
            this.tarea.valor != "" &&
            this.tarea.descripcion != ""
            ? 2
            : 1;
      },
      part2() {
         if (
            this.puntero == this.numero - 1 &&
            this.pregunta.pregunta != "" &&
            this.pregunta.respuestas[0].opcion != "" &&
            this.pregunta.respuestas[1].opcion != "" &&
            this.pregunta.respuestas[2].opcion != "" &&
            this.pregunta.respuestas[3].opcion != "" &&
            this.respuesta != null
         ) {
            this.pregunta.id = this.numero;
            this.tarea.preguntas.push(this.pregunta);
            this.puntero = this.numero++;
         }
         if (this.tarea.preguntas.length > 0) {
            this.formatear();
            this.tareatemp = this.tarea;
         }
         return this.tarea.preguntas.length > 0 ? 3 : 2;
      }
   },
   methods: {
      close() {
         this.$emit("speak", false);
      },
      crear() {
         let self = this;
         axios.post("/tasks", this.tarea).then(function(res) {
            self.mensaje = res.data;
            if (res.data.type === "success") {
               self.e6 = 1;
               self.numero = 1;
               self.puntero = 0;
               self.next = false;
               self.pregunta = {
                  id: 0,
                  task_id: 0,
                  pregunta: "",
                  opcion_a: "",
                  opcion_b: "",
                  opcion_c: "",
                  opcion_d: "",
                  respuestas: [
                     { id: "A)", opcion: "", selected: false },
                     { id: "B)", opcion: "", selected: false },
                     { id: "C)", opcion: "", selected: false },
                     { id: "D)", opcion: "", selected: false }
                  ]
               };
               self.respuesta = null;
               self.tarea = {
                  titulo: "",
                  valor: "",
                  descripcion: "",
                  respuestas: "",
                  subject_id: null,
                  preguntas: []
               };
               self.tarea.subject_id = null;
               self.$emit("speak", false);
            }
         });
      },
      agregar() {
         if (
            this.pregunta.pregunta != "" &&
            this.pregunta.respuestas[0].opcion != "" &&
            this.pregunta.respuestas[1].opcion != "" &&
            this.pregunta.respuestas[2].opcion != "" &&
            this.pregunta.respuestas[3].opcion != "" &&
            this.respuesta != null
         ) {
            if (this.tarea.preguntas.length != this.puntero) {
               this.puntero = this.numero - 1;
            } else {
               this.pregunta.id = this.numero;
               this.tarea.preguntas.push(this.pregunta);
               this.puntero = this.numero++;
            }
         }
      },
      eliminar() {
         if (
            this.tarea.preguntas.length > 0 &&
            this.tarea.preguntas[this.puntero] != null
         ) {
            let res = [];
            this.tarea.preguntas.forEach(item => {
               if (this.tarea.preguntas[this.puntero].id != item.id) {
                  if (item.id > this.tarea.preguntas[this.puntero].id)
                     item.id--;
                  res.push(item);
               }
            });
            this.tarea.preguntas = res;
            this.numero--;
            this.puntero--;
         }
      },
      volver() {
         if (this.puntero == 0) this.puntero = this.numero - 1;
         else this.puntero--;
      },
      formatear() {
         let questions = this.tarea.preguntas;
         this.tarea.respuestas = "";
         for (let index = 0; index < questions.length; index++) {
            for (let i = 0; i < 4; i++) {
               switch (i) {
                  case 0:
                     this.tarea.preguntas[index].opcion_a =
                        questions[index].respuestas[i].opcion;
                     break;
                  case 1:
                     this.tarea.preguntas[index].opcion_b =
                        questions[index].respuestas[i].opcion;
                     break;
                  case 2:
                     this.tarea.preguntas[index].opcion_c =
                        questions[index].respuestas[i].opcion;
                     break;
                  case 3:
                     this.tarea.preguntas[index].opcion_d =
                        questions[index].respuestas[i].opcion;
                     break;
               }
               if (questions[index].respuestas[i].selected)
                  this.tarea.respuestas +=
                     questions[index].respuestas[i].id + ",";
            }
         }
      }
   },
   mounted() {
      var self = this;
      axios.get("/subjects").then(function(res) {
         self.subjects = res.data;
      });
   }
};
</script>
<style scoped>
.mp {
   margin-top: 0%;
   padding-top: 0%;
}
</style>
