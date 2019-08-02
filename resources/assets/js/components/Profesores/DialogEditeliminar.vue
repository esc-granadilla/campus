
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="800px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Profesor</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 v-model="profesor.nombre"
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
                                 v-model="profesor.primer_apellido"
                                 :rules="[rules.required, rules.mini, rules.max]"
                                 counter
                                 label="Primer Apellido"
                                 name="primer_apellido"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 v-model="profesor.segundo_apellido"
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
                                       v-model="profesor.fecha_nacimiento"
                                       label="Fecha Nacimiento"
                                       name="fecha_nacimiento"
                                       prepend-icon="event"
                                       readonly
                                       required
                                       v-on="on"
                                    ></v-text-field>
                                 </template>
                                 <v-date-picker
                                    ref="picker"
                                    v-model="profesor.fecha_nacimiento"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    min="1950-01-01"
                                    @change="save"
                                 ></v-date-picker>
                              </v-menu>
                           </v-flex>
                        </v-layout>
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 d-flex px-3>
                              <v-text-field
                                 v-model="profesor.puesto"
                                 :rules="[rules.required, rules.max, rules.mini]"
                                 counter
                                 label="Puesto"
                                 name="puesto"
                                 required
                                 xs12
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-menu
                                 ref="menu2"
                                 v-model="menu2"
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
                                       v-model="profesor.fecha_ingreso"
                                       label="Fecha Ingreso"
                                       name="fecha_ingreso"
                                       prepend-icon="event"
                                       required
                                       readonly
                                       v-on="on"
                                    ></v-text-field>
                                 </template>
                                 <v-date-picker
                                    ref="picker"
                                    v-model="profesor.fecha_ingreso"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    min="1950-01-01"
                                    @change="save2"
                                 ></v-date-picker>
                              </v-menu>
                           </v-flex>
                           <v-flex xs6 d-flex px-3>
                              <v-text-field
                                 v-model="profesor.telefono1"
                                 :rules="[rules.required, rules.min8,rules.max8]"
                                 :counter="8"
                                 xs12
                                 label="1º Telefono"
                                 name="telefono1"
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 d-flex px-3>
                              <v-text-field
                                 v-model="profesor.telefono2"
                                 :rules="[rules.min8,rules.max8]"
                                 :counter="8"
                                 xs12
                                 label="2º Telefono"
                                 name="telefono2"
                              ></v-text-field>
                           </v-flex>
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
         profesor: {
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
         profesorstock: {
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
         menu: false,
         menu2: false
      };
   },
   props: ["dialogEdits", "editProfesor"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editProfesor(val) {
         this.profesor.id = val.id;
         this.profesor.cedula = val.cedula;
         this.profesor.nombre = val.nombre;
         this.profesor.primer_apellido = val.primer_apellido;
         this.profesor.segundo_apellido = val.segundo_apellido;
         this.profesor.fecha_nacimiento = val.fecha_nacimiento;
         this.profesor.puesto = val.puesto;
         this.profesor.fecha_ingreso = val.fecha_ingreso;
         this.profesor.telefono1 = val.telefono1;
         this.profesor.telefono2 = val.telefono2;
         this.profesor.estado = val.estado;
      },
      menu(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      },
      menu2(val) {
         val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
   },
   methods: {
      save(date) {
         this.$refs.menu.save(date);
      },
      save2(date) {
         this.$refs.menu2.save(date);
      },
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               profesor: this.profesor
            });
         }
      }
   }
};
</script>

<style scoped>
</style>
