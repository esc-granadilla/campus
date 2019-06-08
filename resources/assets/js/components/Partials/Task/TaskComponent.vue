<template>
   <v-layout row wrap>
      <v-flex xs12 v-for="(item, index) in tarea.preguntas" :key="item.id">
         <v-flex xs12 v-if="type != 'edit'">
            <p class="headline">{{index+1}}) {{item.pregunta}}</p>
         </v-flex>
         <v-flex xs12 v-if="type == 'edit'">
            <v-textarea
               name="pregunta"
               box
               :label="(index + 1) + ' Pregunta:'"
               class="ma-2"
               v-model="item.pregunta"
               auto-grow
            ></v-textarea>
         </v-flex>
         <v-flex xs12>
            <p class="mb">Seleccione su respueta:</p>
            <v-radio-group row light v-model="item.answer" class="mb mt flex xs12">
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="A)" value="A)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_a" :readonly="type != 'edit'"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="B)" value="B)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_b" :readonly="type != 'edit'"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="C)" value="C)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_c" :readonly="type != 'edit'"></v-text-field>
                  </v-layout>
               </v-flex>
               <v-flex xs6>
                  <v-layout align-center>
                     <v-radio label="D)" value="D)" color="primary"></v-radio>
                     <v-text-field v-model="item.opcion_d" :readonly="type != 'edit'"></v-text-field>
                  </v-layout>
               </v-flex>
            </v-radio-group>
         </v-flex>
      </v-flex>
      <v-flex xs12 class="text-xs-right">
         <v-btn outline color="primary" @click="Editar" v-if="type == 'edit'">Editar</v-btn>
         <v-btn outline color="success" @click="Calificar" v-if="type == 'none'">Enviar a Calificar</v-btn>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["tarea", "type"],
   data() {
      return {
         mensaje: ""
      };
   },
   methods: {
      Editar() {
         let editar = true;
         let respuestas = "";
         let self = this;
         this.tarea.preguntas.forEach(pregunta => {
            if (
               pregunta.pregunta == "" ||
               pregunta.opcion_a == "" ||
               pregunta.opcion_b == "" ||
               pregunta.opcion_c == "" ||
               pregunta.answer == "" ||
               pregunta.opcion_ == ""
            )
               editar = false;
            respuestas += pregunta.answer + ",";
         });
         if (editar) {
            this.tarea.respuestas = respuestas;
            axios.put("tasks/" + this.tarea.id, this.tarea).then(function(res) {
               self.mensaje = res.data;
               if (res.data.type === "success")
                  self.$emit("speak", {
                     Open: false
                  });
            });
         } else
            this.mensaje = {
               type: "error",
               message: "Complete todo el formulario."
            };
      },
      Calificar() {}
   },
   watch: {
      tarea(val) {
         if (this.type === "edit") {
            let respuestas = val.respuestas.split(",");
            for (let index = 0; index < val.preguntas.length; index++) {
               val.preguntas[index].answer = respuestas[index];
            }
         }
         if (this.type === "none") {
            this.tarea.preguntas.forEach(pregunta => {
               pregunta.answer = null;
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
   }
};
</script>

<style>
.mb {
   margin-bottom: 0px;
   padding-bottom: 0px;
}
.mt {
   margin-top: 0px;
   padding-top: 0px;
}
.v-input--selection-controls .v-input__control {
   width: 100%;
}
</style>

