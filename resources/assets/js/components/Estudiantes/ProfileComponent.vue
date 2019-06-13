<template>
   <v-layout row justify-center max-width="800px" mt-3>
      <v-card class="panel">
         <v-card-title>
            <span class="headline">Mi Perfil</span>
         </v-card-title>
         <v-card-text class="cardbottom">
            <v-container grid-list-md class="cardbottom">
               <v-layout wrap>
                  <v-form ref="form" class="panel">
                     <v-layout xs12>
                        <v-flex xs5 class="text-xs-center">
                           <img
                              :src="estudiante.foto!='none'?estudiante.foto:'/storage/imagen/default-user.png'"
                              height="125"
                           >
                           <v-flex
                              v-if="edit"
                              class="text-xs-center text-sm-center text-md-center text-lg-center"
                           >
                              <v-text-field
                                 label="*Seleccionar la imagen"
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
                        </v-flex>
                        <v-flex xs7>
                           <v-card-title primary-title class="justify-center">
                              <div>
                                 <div class="headline">Cedula: {{estudiante.cedula}}</div>
                                 <div>Sección: {{estudiante.seccion}}</div>
                                 <div>Edad: {{edad}}</div>
                              </div>
                           </v-card-title>
                        </v-flex>
                     </v-layout>
                     <v-layout wrap>
                        <v-flex xs6>
                           <v-text-field
                              v-model="estudiante.nombre"
                              label="Ingrese el Nombre"
                              prefix="Nombre: "
                              :rules="[rules.required, rules.max , rules.min]"
                              solo
                              :readonly="!edit"
                           ></v-text-field>
                        </v-flex>
                        <v-flex xs6>
                           <v-menu
                              ref="menu"
                              v-model="menu"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              lazy
                              transition="scale-transition"
                              offset-y
                              full-width
                              min-width="290px"
                           >
                              <template v-slot:activator="{ on }">
                                 <v-text-field
                                    v-model="estudiante.fecha_nacimiento"
                                    prefix="Nacimiento: "
                                    solo
                                    readonly
                                    required
                                    v-on="on"
                                    v-show="edit"
                                 ></v-text-field>
                                 <v-text-field
                                    v-model="estudiante.fecha_nacimiento"
                                    prefix="Nacimiento: "
                                    solo
                                    readonly
                                    required
                                    v-show="!edit"
                                 ></v-text-field>
                              </template>
                              <v-date-picker
                                 ref="picker"
                                 v-model="estudiante.fecha_nacimiento"
                                 :max="new Date().toISOString().substr(0, 10)"
                                 min="1950-01-01"
                                 @change="save"
                              ></v-date-picker>
                           </v-menu>
                        </v-flex>
                     </v-layout>
                     <v-layout wrap>
                        <v-flex xs6>
                           <v-text-field
                              v-model="estudiante.primer_apellido"
                              label="Ingrese el Apellido"
                              prefix="(1)Apellido: "
                              :rules="[rules.required, rules.max , rules.min]"
                              solo
                              :readonly="!edit"
                           ></v-text-field>
                        </v-flex>
                        <v-flex xs6>
                           <v-text-field
                              v-model="estudiante.segundo_apellido"
                              label="Ingrese el Apellido"
                              prefix="(2)Apellido: "
                              solo
                              :rules="[rules.required, rules.max , rules.min]"
                              :readonly="!edit"
                           ></v-text-field>
                        </v-flex>
                     </v-layout>
                  </v-form>
               </v-layout>
            </v-container>
         </v-card-text>
         <v-card-actions>
            <v-spacer></v-spacer>
            <v-flex align-center xs2 mb-2>
               <v-btn fab dark small color="warning" @click="edit=true" v-if="!edit">
                  <v-icon small>edit</v-icon>
               </v-btn>
               <v-btn fab dark small color="error" @click="edit=false" v-if="edit">
                  <v-icon small>close</v-icon>
               </v-btn>
               <v-btn fab dark small color="green" @click="validar()" v-if="edit">
                  <v-icon small>save</v-icon>
               </v-btn>
            </v-flex>
         </v-card-actions>
      </v-card>
   </v-layout>
</template>

<script>
export default {
   props: ["student"],
   data() {
      return {
         estudiante: {
            id: null,
            cedula: 0,
            fecha_nacimiento: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            seccion: "",
            foto: ""
         },
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 3 || "Min 3 Caracteres",
            max: v => v.length <= 100 || "Maximo 100 Caracteres",
            min8: v => v.length == 0 || v.length == 8 || "Debe ser de 8 Numeros"
         },
         imageName: "",
         mensaje: "",
         menu: false,
         edit: false
      };
   },
   methods: {
      save(date) {
         this.$refs.menu.save(date);
      },
      pickFile() {
         this.$refs.image.click();
      },
      validar() {
         if (this.$refs.form.validate()) {
            let self = this;
            axios
               .put("students/" + this.estudiante.id, this.estudiante)
               .then(function(res) {
                  self.mensaje = res.data;
                  if (res.data.type === "success") self.edit = false;
               });
         } else {
            this.$toast.error("Llene todos los campos.", {
               y: "top",
               timeout: 6000
            });
         }
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
               let self = this;
               let data = new FormData();
               data.append("imagen", files[0], this.imageName);
               let config = {
                  headers: { "content-type": "multipart/form-data" }
               };
               axios.post("/store", data, config).then(function(res) {
                  if (res.data.name != "error") {
                     self.estudiante.foto =
                        "/storage" + res.data.name.substr(6);
                  } else {
                     self.$toast.error("No se pudo cargar esta imagen", {
                        y: "top",
                        timeout: 6000
                     });
                  }
               });
            } else {
               this.imageName = "";
            }
         } else {
            this.imageName = "";
         }
      }
   },
   computed: {
      edad() {
         let fecha = this.estudiante.fecha_nacimiento.split("-");
         let hoy = new Date();
         let edad = hoy.getFullYear() - parseInt(fecha[0]);
         if (
            hoy.getMonth() + 1 >= parseInt(fecha[1]) &&
            hoy.getDate() >= parseInt(fecha[2])
         )
            edad++;
         return edad;
      }
   },
   watch: {
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
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
   mounted() {
      this.estudiante = JSON.parse(this.student);
   }
};
</script>

<style scoped>
.panel {
   width: 800px;
}
.cardbottom {
   padding-bottom: 0px;
   padding-top: 0px;
}
</style>
