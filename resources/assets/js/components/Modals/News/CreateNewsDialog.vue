<template>
   <div>
      <v-btn round outline color="success" dark @click="dialogCreate = true">Crear Noticia</v-btn>
      <v-layout row justify-center>
         <v-dialog v-model="dialogCreate" persistent max-width="600px">
            <v-card>
               <v-card-title>
                  <span class="headline">Sección Nueva</span>
               </v-card-title>
               <v-card-text>
                  <v-form ref="form">
                     <v-text-field
                        xs12
                        v-model="news.titulo"
                        :rules="[rules.required, rules.max , rules.min]"
                        counter
                        label="*Titulo"
                        name="titulo"
                        required
                     ></v-text-field>
                     <v-textarea
                        v-model="news.descripcion"
                        auto-grow
                        box
                        color="deep-purple"
                        label="Descripción"
                        rows="1"
                     ></v-textarea>
                     <v-textarea
                        v-model="news.contenido"
                        auto-grow
                        box
                        color="deep-purple"
                        label="Contenido"
                        rows="1"
                     ></v-textarea>
                     <createfiledialog></createfiledialog>
                  </v-form>
                  <small>*Campos requeridos</small>
                  <v-flex xs12 v-if="news.files.length > 0"></v-flex>
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" flat @click="dialogCreate = false">Cerrar</v-btn>
                  <v-btn color="green darken-1" flat @click="validar">Salvar</v-btn>
               </v-card-actions>
            </v-card>
         </v-dialog>
      </v-layout>
   </div>
</template>

<script>
import createfiledialog from "./CreateFileDialog.vue";
export default {
   components: {
      createfiledialog
   },
   props: ["tipo"],
   data() {
      return {
         dialogCreate: false,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 3 || "Min 9 Caracteres",
            max: v => v.length <= 250 || "Maximo 250 Caracteres"
         },
         news: {
            id: null,
            titulo: "",
            descripcion: "",
            contenido: "",
            fecha: "",
            tipo: this.tipo,
            files: [],
            estado: 1
         }
      };
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogCreate = false;
            this.$emit("speak", this.news);
         }
      }
   }
};
</script>

<style scoped>
</style>
