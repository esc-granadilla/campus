<template>
   <div>
      <v-btn
         color="orange darken-1"
         flat
         round
         outline
         @click="dialogCreate = true"
      >Agregar Multimedia</v-btn>
      <v-layout row justify-center>
         <v-dialog v-model="dialogCreate" persistent max-width="600px">
            <v-card>
               <v-card-title>
                  <span class="headline">Subir Archivos</span>
               </v-card-title>
               <v-card-text>
                  <v-form ref="form">
                     <v-text-field
                        xs12
                        v-model="file.titulo"
                        :rules="[rules.required, rules.max , rules.min]"
                        counter
                        label="*Titulo"
                        name="titulo"
                        required
                     ></v-text-field>
                     <v-card height="300px" flat>
                        <div class="headline text-xs-center pa-5">
                           <v-flex
                              xs12
                              v-if="bottomNav == 2"
                              class="text-xs-center text-sm-center text-md-center text-lg-center"
                           >
                              <img :src="imageUrl" height="100" v-if="imageUrl">
                              <v-text-field
                                 label="*Seleccionar la imagen a compartir"
                                 @click="pickFile"
                                 v-model="imageName"
                                 name="imagenes"
                                 prepend-icon="image"
                              ></v-text-field>
                              <input
                                 type="file"
                                 style="display: none"
                                 ref="image"
                                 accept="image/*"
                                 @change="onFilePicked"
                              >
                           </v-flex>
                           <v-text-field
                              xs12
                              v-model="file.link"
                              :label="texto.label"
                              :placeholder="texto.placeholder"
                              :prepend-icon="texto.icon"
                              name="archivos"
                              v-show="bottomNav != 2"
                           ></v-text-field>
                        </div>
                        <v-bottom-nav
                           :active.sync="bottomNav"
                           :color="color"
                           :value="true"
                           absolute
                           dark
                           shift
                        >
                           <v-btn dark>
                              <span>Video</span>
                              <v-icon>ondemand_video</v-icon>
                           </v-btn>

                           <v-btn dark>
                              <span>Archivo</span>
                              <v-icon>attach_file</v-icon>
                           </v-btn>

                           <v-btn dark>
                              <span>Imagen</span>
                              <v-icon>image</v-icon>
                           </v-btn>
                        </v-bottom-nav>
                     </v-card>
                  </v-form>
                  <small>*Campos requeridos</small>
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
export default {
   props: ["tipo"],
   data() {
      return {
         dialogCreate: false,
         bottomNav: 0,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 3 || "Min 3 Caracteres",
            max: v => v.length <= 250 || "Maximo 250 Caracteres"
         },
         imageName: "",
         texto: {
            label: "*Ingrese el link del video a compartir",
            placeholder: "Solo videos de youtube",
            icon: "ondemand_video"
         },
         imageUrl: "",
         imageFile: "",
         file: {
            id: null,
            titulo: "",
            tipo: "video",
            link: "",
            news_id: ""
         }
      };
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            let newfile = {
               id: null,
               titulo: this.file.titulo,
               tipo: this.file.tipo,
               link: this.file.link,
               news_id: ""
            };
            if (this.file.tipo != "imagen" && this.file.link != "") {
               if (
                  this.file.tipo == "video" &&
                  (!this.file.link.startsWith("https://www.youtube.com") &&
                     !this.file.link.startsWith("http://www.youtube.com"))
               ) {
                  this.mensajeerror("Solo se permiten videos de youtube.");
                  return;
               }
               this.dialogCreate = false;
               this.$emit("speak", newfile);
               this.restaurar();
            } else if (this.file.tipo == "imagen" && this.imageName != "") {
               let self = this;
               let data = new FormData();
               data.append("imagen", this.imageFile, this.imageName);
               let config = {
                  headers: { "content-type": "multipart/form-data" }
               };
               axios.post("/store", data, config).then(function(res) {
                  if (res.data.name != "error") {
                     newfile.link = "/storage" + res.data.name.substr(6);
                     self.dialogCreate = false;
                     self.$emit("speak", newfile);
                     self.restaurar();
                  } else {
                     self.mensajeerror("Esta imagen no pudo ser almacenada.");
                  }
               });
            } else {
               this.mensajeerror("Debes llenar el campo del link.");
            }
         }
      },
      mensajeerror(texto) {
         this.$toast.error(texto, {
            y: "top",
            timeout: 6000
         });
      },
      restaurar() {
         this.file = {
            id: null,
            titulo: "",
            tipo: "video",
            link: "",
            news_id: ""
         };
         this.bottomNav = 0;
         this.imageName = "";
         this.imageUrl = "";
         this.imageFile = "";
         this.$refs.form.resetValidation();
      },
      pickFile() {
         this.$refs.image.click();
      },
      onFilePicked(e) {
         const files = e.target.files;
         if (files[0] !== undefined) {
            this.imageName = files[0].name;
            if (this.imageName.lastIndexOf(".") <= 0) {
               return;
            }
            if (
               this.imageName.toLocaleLowerCase().endsWith("jpg") ||
               this.imageName.toLocaleLowerCase().endsWith("jpeg") ||
               this.imageName.toLocaleLowerCase().endsWith("bmp") ||
               this.imageName.toLocaleLowerCase().endsWith("gif") ||
               this.imageName.toLocaleLowerCase().endsWith("png") ||
               this.imageName.toLocaleLowerCase().endsWith("svg")
            ) {
               const fr = new FileReader();
               fr.readAsDataURL(files[0]);
               fr.addEventListener("load", () => {
                  this.imageUrl = fr.result;
                  this.imageFile = files[0];
               });
            } else {
               this.imageName = "";
               this.imageFile = "";
               this.imageUrl = "";
            }
         } else {
            this.imageName = "";
            this.imageFile = "";
            this.imageUrl = "";
         }
      }
   },
   computed: {
      color() {
         switch (this.bottomNav) {
            case 0:
               return "indigo";
            case 1:
               return "purple";
            case 2:
               return "teal";
         }
      }
   },
   watch: {
      bottomNav(val) {
         switch (val) {
            case 0:
               this.file.tipo = "video";
               this.texto = {
                  label: "*Ingrese el link del video a compartir",
                  placeholder: "Solo videos de youtube",
                  icon: "ondemand_video"
               };
               this.file.link = "";
               break;
            case 1:
               this.file.tipo = "archivo";
               this.texto = {
                  label: "*Ingrese el link del archivo a compartir",
                  placeholder: "",
                  icon: "attach_file"
               };
               this.file.link = "";
               break;
            case 2:
               this.file.tipo = "imagen";
               this.file.link = this.imageName = this.imageFile = this.imageUrl =
                  "";
               break;
         }
      }
   }
};
</script>

<style scoped>
</style>
