<template>
   <div>
      <v-btn
         round
         outline
         color="success"
         dark
         @click="dialogCreate = true"
         v-if="accion=='create'"
      >Crear Noticia</v-btn>
      <v-layout row justify-center>
         <v-dialog v-model="dialogCreate" persistent max-width="600px">
            <v-card>
               <v-card-title>
                  <span class="headline">Noticia Nueva</span>
               </v-card-title>
               <v-card-text>
                  <v-form ref="form">
                     <v-text-field
                        xs12
                        v-model="news.titulo"
                        :rules="[rules.required, rules.between]"
                        counter
                        label="*Titulo"
                        name="titulo"
                        required
                     ></v-text-field>
                     <v-textarea
                        v-model="news.descripcion"
                        auto-grow
                        :rules="[rules.max]"
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
                     <createfiledialog v-on:speak="fileMethod($event)"></createfiledialog>
                  </v-form>
                  <small>*Campos requeridos</small>
                  <v-flex v-if="news.files.length > 0" v-bar class="resultContainer">
                     <v-layout row wrap>
                        <v-flex v-for="fi in news.files" :key="fi.id">
                           <v-img
                              :aspect-ratio="16/9"
                              v-if="fi.tipo === 'imagen'"
                              :src="fi.link"
                              height="150px"
                           >
                              <v-layout pa-2 column fill-height class="lightbox white--text">
                                 <v-spacer></v-spacer>
                                 <v-flex shrink>
                                    <div class="subheading">{{fi.titulo}}</div>
                                    <v-icon
                                       small
                                       color="red lighten-2"
                                       @click="deletefile(fi)"
                                    >delete</v-icon>
                                 </v-flex>
                              </v-layout>
                           </v-img>
                           <v-img
                              :aspect-ratio="16/9"
                              v-if="fi.tipo !== 'imagen'"
                              :src="'storage/imagen/'+fi.tipo+'.jpg'"
                              height="150px"
                           >
                              <v-layout pa-2 column fill-height class="lightbox white--text">
                                 <v-spacer></v-spacer>
                                 <v-flex shrink>
                                    <div class="subheading">{{fi.titulo}}</div>
                                    <div class="body-1">{{fi.link}}</div>
                                    <v-icon
                                       small
                                       color="red lighten-2"
                                       @click="deletefile(fi)"
                                    >delete</v-icon>
                                 </v-flex>
                              </v-layout>
                           </v-img>
                        </v-flex>
                     </v-layout>
                  </v-flex>
               </v-card-text>
               <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" flat @click="restaurar();dialogCreate = false;">Cerrar</v-btn>
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
   props: ["tipo", "data", "accion"],
   data() {
      return {
         dialogCreate: false,
         rules: {
            required: value => !!value || "Requerido.",
            between: v =>
               (!!v && (v.length >= 3 && v.length < 61)) ||
               "Entre 3 y 60 Caracteres",
            max: v => v.length <= 250 || "Maximo 250 Caracteres"
         },
         mensaje: "",
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
            if (
               (this.news.contenido == null || this.news.contenido == "") &&
               (this.news.files == null || this.news.files.length == 0)
            ) {
               this.mensajeerror(
                  "La noticia tiene que tener archivos o contenido escrito."
               );
               return;
            }
            let data = {
               id: this.news.id,
               titulo: this.news.titulo,
               descripcion: this.news.descripcion,
               contenido: this.news.contenido,
               fecha: this.news.fecha,
               tipo: this.tipo,
               files: this.news.files,
               estado: 1
            };
            let self = this;
            if (this.accion == "create") {
               axios.post("news", data).then(function(res) {
                  self.mensaje = res.data;
                  if (res.data.type == "success") {
                     self.dialogCreate = false;
                     self.$emit("speak", data);
                     self.restaurar();
                  }
               });
            } else {
               axios.put("news/" + data.id, data).then(function(res) {
                  self.mensaje = res.data;
                  if (res.data.type == "success") {
                     self.dialogCreate = false;
                     self.$emit("speak", data);
                     self.restaurar();
                  }
               });
            }
         }
      },
      fileMethod: function(msj) {
         this.news.files.push(msj);
      },
      deletefile(f) {
         this.news.files = this.news.files.filter(r => r.link != f.link);
      },
      mensajeerror(texto) {
         this.$toast.error(texto, {
            y: "top",
            timeout: 6000
         });
      },
      restaurar() {
         this.news = {
            id: null,
            titulo: "",
            descripcion: "",
            contenido: "",
            fecha: "",
            tipo: this.tipo,
            files: [],
            estado: 1
         };
         this.$refs.form.resetValidation();
      }
   },
   watch: {
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
      },
      data(val) {
         if (val != null) {
            this.news = {
               id: val.id,
               titulo: val.titulo,
               descripcion: val.descripcion,
               contenido: val.contenido,
               fecha: val.fecha,
               tipo: val.tipo,
               files: val.files,
               estado: 1
            };
            this.dialogCreate = true;
         }
      }
   }
};
</script>

<style scope>
.resultContainer {
   height: 150px;
}
</style>
