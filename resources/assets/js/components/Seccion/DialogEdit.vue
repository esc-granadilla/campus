
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="300px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Sección</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-text-field
                           xs12
                           v-model="seccion.seccion"
                           :rules="[rules.required, rules.max]"
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
                        <v-text-field v-model="gradotxt" name="grade_id" v-show="false" required></v-text-field>
                     </v-form>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn
                  color="blue darken-1"
                  flat
                  @click="dialogedit = false, seccion = seccionstock,$emit('speak', {dialogedit:false,Edit:false,seccion:seccion})"
               >Cerrar</v-btn>
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
         dialogedit: false,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length <= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         },
         seccion: {
            id: null,
            seccion: "",
            grade_id: null,
            estado: 1
         },
         seccionstock: {
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
   props: ["dialogEdits", "editSection"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editSection(val) {
         this.seccion.id = val.id;
         this.seccion.seccion = val.seccion;
         this.seccion.grade_id = val.grade_id;
         this.seccion.estado = val.estado;
         this.grado = this.grados.find(function(c) {
            return c.value == val.grade_id;
         });
      }
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               seccion: this.seccion
            });
         }
      }
   },
   computed: {
      gradotxt: function() {
         if (this.grado == null) {
            this.grado = this.grados[0];
            this.seccion.seccion = "";
         }
         this.seccion.grade_id = this.grado.value;
         return this.grado.value;
      }
   }
};
</script>

<style scoped>
</style>
