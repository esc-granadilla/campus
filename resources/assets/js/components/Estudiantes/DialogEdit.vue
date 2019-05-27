
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="800px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Estudiante</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 v-model="estudiante.nombre"
                                 :rules="[rules.required, rules.mini, rules.max]"
                                 counter
                                 label="Nombre"
                                 name="nombre"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 xs12
                                 v-model="estudiante.primer_apellido"
                                 :rules="[rules.required, rules.mini, rules.max]"
                                 counter
                                 label="Primer Apellido"
                                 name="primer_apellido"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 v-model="estudiante.segundo_apellido"
                                 :rules="[rules.required, rules.mini, rules.max]"
                                 counter
                                 label="Segundo Apellido"
                                 name="segundo_apellido"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
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
                                       label="Fecha Nacimiento"
                                       name="fecha_nacimiento"
                                       prepend-icon="event"
                                       required
                                       readonly
                                       v-on="on"
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
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 pt-2 px-3>
                              <v-select
                                 :items="grados"
                                 item-text="text"
                                 item-value="value"
                                 return-object
                                 v-model="grado"
                                 label="Grado"
                                 d-block
                              ></v-select>
                           </v-flex>
                           <v-text-field v-model="gradotxt" name="grado" v-show="false" required></v-text-field>
                           <v-flex xs6 pt-2 px-3>
                              <v-select
                                 :items="adecuaciones"
                                 item-text="text"
                                 item-value="value"
                                 return-object
                                 v-model="adecuacion"
                                 label="Adecuaciòn"
                                 d-block
                              ></v-select>
                           </v-flex>
                           <v-text-field
                              v-model="adecuaciontxt"
                              name="adecuacion"
                              v-show="false"
                              required
                           ></v-text-field>
                        </v-layout>
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
                  @click="dialogedit = false, profesor = profesorstock,$emit('speak', {dialogedit:false,Edit:false,profesor:profesor})"
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
            max8: v => v.length <= 8 || "Maximo 8 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         },
         estudiante: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: "",
            puesto: "",
            fecha_ingreso: "",
            telefono1: "",
            telefono2: "",
            estado: 1
         },
         estudiantestock: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: "",
            puesto: "",
            fecha_ingreso: "",
            telefono1: "",
            telefono2: "",
            estado: 1
         },
         grado: { value: 1, text: "Primero" },
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" }
         ],
         adecuacion: { value: 1, text: "Ninguna" },
         adecuaciones: [
            { value: 1, text: "Ninguna" },
            { value: 2, text: "Moderada" },
            { value: 3, text: "Significativa" }
         ],
         menu: false
      };
   },
   props: ["dialogEdits", "editEstudiante"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editEstudiante(val) {
         this.estudiante.id = val.id;
         this.estudiante.cedula = val.cedula;
         this.estudiante.nombre = val.nombre;
         this.estudiante.primer_apellido = val.primer_apellido;
         this.estudiante.segundo_apellido = val.segundo_apellido;
         this.estudiante.fecha_nacimiento = val.fecha_nacimiento;
         this.estudiante.adecuacion = val.adecuacion;
         this.estudiante.section_id = val.section_id;
         this.estudiante.estado = val.estado;
      },
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   },
   methods: {
      save(date) {
         this.$refs.menu.save(date);
      },
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               estudiante: this.estudiante
            });
         }
      }
   },
   computed: {
      gradotxt: function() {
         this.estudiante.grado = this.grado.value;
         return this.grado.value;
      },
      adecuaciontxt: function() {
         this.estudiante.adecuacion = this.adecuacion.text;
         return this.adecuacion.text;
      }
   }
};
</script>

<style scoped>
</style>
