
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="800px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Nota</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-form ref="form">
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 xs12
                                 v-model="nota.titulo"
                                 :rules="[rules.required, rules.max]"
                                 counter
                                 label="*Titulo"
                                 name="titulo"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 xs12
                                 v-model="nota.valor_porcentual"
                                 :rules="[rules.required]"
                                 label="*Valor Porcentual"
                                 name="valor_porcentual"
                                 prefix="%"
                                 :mask="mask"
                                 :return-masked-value="true"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 xs12
                                 v-model="nota.porcentaje_obtenido"
                                 :rules="[rules.required]"
                                 label="*Porcentaje Obtenido"
                                 name="porcentaje_obtenido"
                                 prefix="%"
                                 :mask="mask1"
                                 :return-masked-value="true"
                                 required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-text-field
                                 xs12
                                 v-model="nota.descripcion"
                                 counter
                                 label="Descripción"
                                 name="descripcion"
                              ></v-text-field>
                           </v-flex>
                        </v-layout>
                        <v-layout wrap mx-5 xs6>
                           <v-flex xs6 pt-2 px-3>
                              <v-menu
                                 ref="menu"
                                 v-model="menu"
                                 :close-on-content-click="false"
                                 :nudge-right="40"
                                 :return-value.sync="nota.fecha"
                                 lazy
                                 transition="scale-transition"
                                 offset-y
                                 full-width
                                 min-width="290px"
                              >
                                 <template v-slot:activator="{ on }">
                                    <v-text-field
                                       v-model="nota.fecha"
                                       label="*Fecha"
                                       prepend-icon="event"
                                       readonly
                                       v-on="on"
                                    ></v-text-field>
                                 </template>
                                 <v-date-picker v-model="nota.fecha" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn
                                       flat
                                       color="primary"
                                       @click="$refs.menu.save(nota.fecha)"
                                    >OK</v-btn>
                                 </v-date-picker>
                              </v-menu>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-select
                                 :items="tipos"
                                 :rules="[rules.required]"
                                 item-text="text"
                                 item-value="value"
                                 :menu-props="{returnValue:'value'}"
                                 v-model="nota.tipo"
                                 label="*Tipo"
                                 d-block
                              ></v-select>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-select
                                 :items="condiciones"
                                 :rules="[rules.required]"
                                 item-text="text"
                                 item-value="value"
                                 :menu-props="{returnValue:'value'}"
                                 v-model="nota.condicion"
                                 label="*Condición"
                                 d-block
                              ></v-select>
                           </v-flex>
                           <v-flex xs6 pt-2 px-3>
                              <v-select
                                 :items="trimestres"
                                 :rules="[rules.required]"
                                 item-text="text"
                                 item-value="value"
                                 :menu-props="{returnValue:'value'}"
                                 v-model="nota.trimestre"
                                 label="*Trimestre"
                                 d-block
                              ></v-select>
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
                  @click="dialogedit = false, nota = notastock,$emit('speak', {dialogedit:false,Edit:false,nota:nota})"
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
         menu: false,
         rules: {
            required: value => !!value || "Requerido.",
            max: v => v == null || v.length <= 50 || "Maximo 50 Caracteres"
         },
         mask1: "##.##",
         mask: "##",
         trimestres: [
            { text: "Primer Trimestre", value: 1 },
            { text: "Segundo Trimestre", value: 2 },
            { text: "Tercer Trimestre", value: 3 }
         ],
         condiciones: [
            { text: "Aprobada", value: "Aprobada" },
            { text: "Reprobada", value: "Reprobada" },
            { text: "Realisada", value: "Realisada" },
            { text: "No realisada", value: "No realisada" }
         ],
         tipos: [
            { text: "Examen", value: "Examen" },
            { text: "Tarea", value: "Tarea" },
            {
               text: "Trabajo o investigación",
               value: "Trabajo o investigación"
            },
            { text: "Otra", value: "Otra" }
         ],
         notastock: {
            id: null,
            titulo: "",
            valor_porcentual: "",
            porcentaje_obtenido: "",
            tipo: "",
            condicion: "",
            descripcion: "",
            trimestre: "",
            fecha: new Date().toISOString().substr(0, 10)
         },
         nota: {
            id: null
         }
      };
   },
   props: ["dialogEdits", "editNota"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editNota(val) {
         if (val == null) this.nota = this.notastock;
         else {
            this.nota.id = val.id;
            this.nota.titulo = val.titulo;
            this.nota.valor_porcentual = val.valor_porcentual;
            this.nota.porcentaje_obtenido = val.porcentaje_obtenido;
            this.nota.tipo = val.tipo;
            this.nota.condicion = val.condicion;
            this.nota.descripcion = val.descripcion;
            this.nota.trimestre = val.trimestre;
         }
      }
   },
   methods: {
      validar() {
         if (this.$refs.form.validate()) {
            this.dialogedit = false;
            this.$emit("speak", {
               dialogedit: false,
               Edit: true,
               nota: this.nota
            });
         }
      }
   }
};
</script>

<style scoped>
</style>
