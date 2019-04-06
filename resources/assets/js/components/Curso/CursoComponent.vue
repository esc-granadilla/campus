<template>
   <div>
      <div class="alert">
         <v-alert v-model="alert" dismissible :type="alerttype">{{ mensaje.message }}</v-alert>
      </div>
      <v-flex md8 xs12 offset-md2>
         <v-layout wrap row>
            <!--<v-flex xs12 pt-2 px-3>
               <v-card fluid class="elevation-12">
                  <v-toolbar dark class="py-1">
                     <v-toolbar-title>Curso</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>
                  <v-flex md10 xs12 offset-md1>
                     <v-card-text>
                        <v-layout wrap row>
                           <v-flex xs12 md7>
                              <v-text-field
                                 xs6
                                 v-model="curso.codigo"
                                 :rules="[rules.required, rules.mini]"
                                 counter
                                 label="Codigo"
                                 name="codigo"
                                 required
                              ></v-text-field>

                              <v-text-field
                                 xs6
                                 v-model="curso.nombre"
                                 :rules="[rules.required, rules.mini]"
                                 counter
                                 label="Nombre"
                                 name="nombre"
                                 required
                              ></v-text-field>
                              <v-text-field
                                 xs6
                                 v-model="curso.descripcion"
                                 :rules="[rules.mini]"
                                 counter
                                 label="Descripción"
                                 name="descripcion"
                              ></v-text-field>
                           </v-flex>
                           <v-spacer></v-spacer>
                           <v-flex xs12 md3>
                              <v-layout align-end justify-end fill-height wrap>
                                 <v-flex xs3 md12>
                                    <v-btn round dark flat color="green" block @click="crear">Crear</v-btn>
                                 </v-flex>
                                 <v-flex xs3 md12>
                                    <v-btn
                                       round
                                       dark
                                       flat
                                       color="blue"
                                       block
                                       @click="editar"
                                    >Actualizar</v-btn>
                                 </v-flex>
                                 <v-flex xs3 md12>
                                    <v-btn
                                       round
                                       dark
                                       flat
                                       color="red"
                                       block
                                       @click="eliminar"
                                    >Eliminar</v-btn>
                                 </v-flex>
                              </v-layout>
                           </v-flex>
                        </v-layout>
                     </v-card-text>
                  </v-flex>
               </v-card>
            </v-flex>-->

            <v-flex xs12 pt-2 px-3>
               <v-toolbar dark color="green" class="py-1">
                  <v-spacer></v-spacer>
                  <v-toolbar-title>Curso</v-toolbar-title>
                  <v-spacer></v-spacer>
               </v-toolbar>
               <v-card>
                  <dialogcreate v-on:speak="crearMethod($event)"></dialogcreate>
                  <dialogdelete :dialogDeletes="dialogDelete" v-on:speak="borrarMethod($event)"></dialogdelete>
                  <dialogedit
                     :dialogEdits="dialogEdit"
                     :editCurso="curso"
                     v-on:speak="editarMethod($event)"
                  ></dialogedit>
                  <v-card-title>
                     <v-spacer></v-spacer>Cursos
                     <v-spacer></v-spacer>
                     <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Buscar por Nombre"
                        single-line
                        hide-details
                     ></v-text-field>
                  </v-card-title>
                  <v-data-table :headers="headers" :items="cursos" :search="search">
                     <template v-slot:items="props">
                        <td
                           class="text-xs-left"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.nombre }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.codigo }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >{{ props.item.descripcion }}</td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >
                           <v-btn
                              flat
                              small
                              color="primary"
                              @click="buscar(props.item.id),dialogEdit = true"
                           >Editar</v-btn>
                        </td>
                        <td
                           class="text-xs-center"
                           :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                        >
                           <v-btn
                              flat
                              small
                              color="error"
                              dark
                              @click.stop="buscar(props.item.id),dialogDelete = true"
                           >Eliminar</v-btn>
                        </td>
                     </template>
                     <v-alert
                        v-slot:no-results
                        :value="true"
                        color="error"
                        icon="warning"
                     >Tu busqueda por "{{ search }}" no encontro resultados.</v-alert>
                  </v-data-table>
               </v-card>
            </v-flex>
         </v-layout>
      </v-flex>
   </div>
</template>

<script>
import dialogcreate from "../Curso/DialogCreate.vue";
import dialogdelete from "../Curso/DialogDelete.vue";
import dialogedit from "../Curso/DialogEdit.vue";

export default {
   name: "cursocomponent",
   components: {
      dialogcreate,
      dialogdelete,
      dialogedit
   },
   data() {
      return {
         search: "",
         dialogDelete: false,
         dialogEdit: false,
         curso: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         },
         alert: false,
         alerttype: "success",
         cursos: [],
         mensaje: [],
         headers: [
            {
               text: "Nombre",
               align: "left",
               sortable: false,
               value: "nombre"
            },
            { text: "Codigo", align: "center", value: "codigo" },
            { text: "Descripción", align: "center", value: "descripcion" },
            { text: "Editar", align: "center", value: "" },
            { text: "Eliminar", align: "center", value: "" }
         ],
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         }
      };
   },
   methods: {
      buscar(id) {
         this.curso = this.cursos.find(function(c) {
            return c.id == id;
         });
      },
      crearMethod: function(msg) {
         var self = this;
         this.curso = msg;
         if (this.curso.nombre != "") {
            axios.post("cursos/", this.curso).then(function(res) {
               self.mensaje = res.data;
               axios.get("/cursos").then(res => (self.cursos = res.data));
            });
         }
      },
      eliminar() {
         var self = this;
         if (this.curso.id != null) {
            axios.delete("cursos/" + this.curso.id).then(function(res) {
               self.mensaje = res.data;
               axios.get("/cursos").then(res => (self.cursos = res.data));
            });
         }
      },
      editar() {
         var self = this;
         if (this.curso.id != null) {
            axios
               .put("cursos/" + this.curso.id, this.curso)
               .then(function(res) {
                  self.mensaje = res.data;
                  axios.get("/cursos").then(res => (self.cursos = res.data));
               });
         }
      },
      borrarMethod: function(msg) {
         this.dialogDelete = msg.dialogdelete;
         if (msg.Delete) this.eliminar();
      },
      editarMethod: function(msg) {
         this.dialogEdit = msg.dialogedit;
         if (msg.Edit) {
            this.curso = msg.curso;
            this.editar();
         } else {
            this.curso = {
               id: null,
               codigo: "",
               nombre: "",
               descripcion: "",
               estado: ""
            };
         }
      }
   },
   watch: {
      mensaje(val) {
         this.alert = true;
      }
   },
   mounted() {
      axios.get("/cursos").then(res => (this.cursos = res.data));
   }
};
</script>

<style scoped>
.alert {
   position: absolute;
   z-index: 2;
   right: 0;
}
.v-table thead tr:first-child {
   background-color: black;
}
</style>