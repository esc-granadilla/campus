<template>
   <div>
      <div class="alert">
         <v-alert v-model="alert" dismissible :type="alerttype">{{ mensaje.message }}</v-alert>
      </div>
      <v-layout justify-center wrap>
         <v-card class="mar2" absolute>
            <v-layout justify-center wrap>
               <v-flex md10 class="mar">
                  <v-toolbar color="green" dark tabs>
                     <v-flex v-if="ocualtarTab">
                        <v-text-field
                           class="mx-3"
                           flat
                           label="Buscar Cedula"
                           prepend-inner-icon="search"
                           solo-inverted
                           v-model="search"
                           @keydown="buscarProfesor()"
                        ></v-text-field>
                     </v-flex>
                     <v-flex v-if="ocualtarTab2">
                        <v-text-field
                           class="mx-3"
                           flat
                           label="Buscar Nombre"
                           prepend-inner-icon="search"
                           solo-inverted
                           v-model="search"
                           @keydown="buscarCurso()"
                        ></v-text-field>
                     </v-flex>
                     <v-layout v-if="ocualtarTab3" xs12 justify-center align-center wrap>
                        <v-btn block flat xs12 round @click="enviar">Asignar Profesor al curso</v-btn>
                     </v-layout>
                     <template v-slot:extension>
                        <v-tabs v-model="tabs" centered color="transparent" slider-color="white">
                           <v-tab
                              v-for="a in accions"
                              :key="a.id"
                              :disabled="a.invisible"
                           >{{ a.text }}</v-tab>
                        </v-tabs>
                     </template>
                  </v-toolbar>

                  <v-tabs-items v-model="tabs">
                     <v-tab-item :key="1">
                        <div>
                           <v-layout row>
                              <v-flex xs12>
                                 <div v-bar class="tm">
                                    <v-list subheader two-line>
                                       <v-subheader>Profesores</v-subheader>
                                       <v-list-tile
                                          @click.prevent="selectedProfesor(p)"
                                          v-for="p in profesores"
                                          :key="p.id"
                                       >
                                          <v-list-tile-action>
                                             <v-checkbox
                                                v-model="p.selected"
                                                @click.prevent="selectedProfesor(p)"
                                             ></v-checkbox>
                                          </v-list-tile-action>

                                          <v-list-tile-content>
                                             <v-list-tile-title>{{'Ced: '}}{{ p.cedula }}{{' - '}}{{ p.nombre }}{{' '}}{{ p.primer_apellido }}{{' '}}{{ p.segundo_apellido }}</v-list-tile-title>
                                             <v-list-tile-sub-title>{{'Puesto: '}}{{ p.puesto }}{{' - Telefono: '}}{{ p.telefono1 }}</v-list-tile-sub-title>
                                          </v-list-tile-content>
                                       </v-list-tile>
                                    </v-list>
                                 </div>
                              </v-flex>
                           </v-layout>
                        </div>
                     </v-tab-item>
                     <v-tab-item :key="2">
                        <div>
                           <v-layout row>
                              <v-flex xs12>
                                 <v-subheader class="mt-4">
                                    <v-select
                                       :items="grados"
                                       item-text="text"
                                       item-value="value"
                                       return-object
                                       v-model="grado"
                                       label="Seleccione el Grado"
                                       d-block
                                       @change="obtenerHorarios"
                                    ></v-select>
                                 </v-subheader>
                                 <div v-bar class="tm">
                                    <v-list subheader two-line>
                                       <v-subheader>Cursos</v-subheader>
                                       <v-list-tile
                                          @click.prevent="selectedCurso(c)"
                                          v-for="c in cursos"
                                          :key="c.id"
                                       >
                                          <v-list-tile-action>
                                             <v-checkbox
                                                v-model="c.selected"
                                                @click.prevent="selectedCurso(c)"
                                             ></v-checkbox>
                                          </v-list-tile-action>

                                          <v-list-tile-content>
                                             <v-list-tile-title>{{ c.codigo }}{{' '}}{{ c.nombre }}</v-list-tile-title>
                                             <v-list-tile-sub-title>{{ c.descripcion }}</v-list-tile-sub-title>
                                          </v-list-tile-content>
                                       </v-list-tile>
                                    </v-list>
                                 </div>
                              </v-flex>
                           </v-layout>
                        </div>
                     </v-tab-item>
                     <v-tab-item :key="3">
                        <div>
                           <v-subheader class="mt-4">
                              <v-select
                                 :items="dias"
                                 item-text="text"
                                 item-value="value"
                                 return-object
                                 v-model="dia"
                                 label="Seleccione le Dia"
                                 d-block
                                 @change="obtenerHorarios"
                              ></v-select>
                           </v-subheader>
                           <v-data-table
                              v-model="selected"
                              :headers="headers"
                              :items="horarios"
                              :pagination.sync="pagination"
                              select-all
                              item-key="id"
                           >
                              <template v-slot:headers="props">
                                 <tr>
                                    <th>
                                       <v-checkbox
                                          :input-value="props.all"
                                          :indeterminate="props.indeterminate"
                                          primary
                                          hide-details
                                          @click.stop="toggleAll"
                                       ></v-checkbox>
                                    </th>
                                    <th
                                       v-for="header in props.headers"
                                       :key="header.text"
                                       :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                       @click="changeSort(header.value)"
                                    >
                                       <v-icon small>arrow_upward</v-icon>
                                       {{ header.text }}
                                    </th>
                                 </tr>
                              </template>
                              <template v-slot:items="props">
                                 <tr
                                    :active="props.selected"
                                    @click="props.selected = !props.selected"
                                 >
                                    <td>
                                       <v-checkbox :input-value="props.selected" hide-details></v-checkbox>
                                    </td>
                                    <td class="text-xs-center">{{ props.item.desde }}</td>
                                    <td class="text-xs-center">{{ props.item.hasta }}</td>
                                 </tr>
                              </template>
                           </v-data-table>
                        </div>
                     </v-tab-item>
                  </v-tabs-items>
               </v-flex>
            </v-layout>
         </v-card>
      </v-layout>
   </div>
</template>

<script>
export default {
   data() {
      return {
         tabs: 0,
         search: "",
         pagination: {
            sortBy: "desde"
         },
         selected: [],
         mensaje: [],
         cursoshorarios: [],
         alert: false,
         alerttype: "success",
         grado: { value: 1, text: "Primero" },
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" }
         ],
         dia: { value: 1, text: "Lunes" },
         dias: [
            { value: 1, text: "Lunes" },
            { value: 2, text: "Martes" },
            { value: 3, text: "Miercoles" },
            { value: 4, text: "Jueves" },
            { value: 5, text: "Viernes" }
         ],
         cursos: [],
         cursostock: [],
         curso: null,
         headers: [
            {
               text: "Desde:",
               align: "left",
               value: "desde"
            },
            { text: "Hasta", value: "hasta" }
         ],
         profesores: [],
         profesorstock: [],
         horarios: [],
         profesor: null,
         accions: [
            {
               id: 1,
               text: "Profesor",
               invisible: false
            },
            {
               id: 2,
               text: "Curso",
               invisible: true
            },
            {
               id: 3,
               text: "Horario",
               invisible: true
            }
         ]
      };
   },
   methods: {
      toggleAll() {
         if (this.selected.length) this.selected = [];
         else this.selected = this.horarios.slice();
      },
      changeSort(column) {
         if (this.pagination.sortBy === column) {
            this.pagination.descending = !this.pagination.descending;
         } else {
            this.pagination.sortBy = column;
            this.pagination.descending = false;
         }
      },
      buscarCurso(event) {
         var self = this;
         if (window.event.keyCode == 13) {
            var cur = self.cursostock.find(function(curso) {
               return curso.nombre.toUpperCase() === self.search.toUpperCase();
            });
            if (cur != null)
               cur = {
                  id: cur.id,
                  nombre: cur.nombre,
                  codigo: cur.codigo,
                  descripcion: cur.descripcion,
                  selected: false
               };
            self.selectedCurso(cur);
         }
      },
      buscarProfesor(event) {
         var self = this;
         if (window.event.keyCode == 13) {
            var pro = self.profesorstock.find(function(profesor) {
               return profesor.cedula.toString() === self.search;
            });
            if (pro != null)
               pro = {
                  id: pro.id,
                  nombre: pro.nombre,
                  cedula: pro.cedula,
                  primer_apellido: pro.primer_apellido,
                  segundo_apellido: pro.segundo_apellido,
                  telefono1: pro.telefono1,
                  puesto: pro.puesto,
                  selected: false
               };
            self.selectedProfesor(pro);
         }
      },
      selectedCurso(curso) {
         if (curso != null && !curso.selected) {
            if (this.curso != null) this.curso.selected = false;
            curso.selected = true;
            this.curso = curso;
            this.obtenerHorarios();
            var nuevos = [];
            nuevos.push(curso);
            this.cursos = nuevos;
            this.search = "";
            this.accions[2].invisible = false;
         } else {
            if (this.curso != null) this.curso.selected = false;
            if (curso != null) curso.selected = false;
            this.curso = null;
            this.cursos = this.cursostock;
            this.accions[2].invisible = true;
         }
      },
      selectedProfesor(profesor) {
         if (profesor != null && !profesor.selected) {
            if (this.profesor != null) this.profesor.selected = false;
            profesor.selected = true;
            this.profesor = profesor;
            var nuevos = [];
            nuevos.push(profesor);
            this.profesores = nuevos;
            this.search = "";
            this.accions[1].invisible = false;
         } else {
            if (this.profesor != null) this.profesor.selected = false;
            if (profesor != null) profesor.selected = false;
            this.profesor = null;
            this.profesores = this.profesorstock;
            this.accions[1].invisible = true;
            this.selectedCurso(null);
         }
      },
      obtenerHorarios() {
         var self = this;
         if (this.curso != null)
            axios
               .get(
                  "showcursohorarioprofesor/" +
                     this.profesor.id +
                     "/" +
                     this.curso.id +
                     "/" +
                     this.grado.value +
                     "/" +
                     this.dia.value
               )
               .then(function(res) {
                  var crs = res.data;
                  self.horarios = crs;
                  self.selected = [];
                  crs.forEach(c => {
                     if (c.selected) self.selected.push(c);
                  });
               });
      },
      enviar() {
         axios
            .post(
               "asigcursohorarioprofesor/" +
                  this.profesor.id +
                  "/" +
                  this.curso.id +
                  "/" +
                  this.grado.value +
                  "/" +
                  this.dia.value,
               {
                  horarios: this.selected
               }
            )
            .then(res => (this.mensaje = res.data));
      }
   },
   computed: {
      gradotxt: function() {
         return this.grado.value;
      },
      diatxt: function() {
         return this.dia.value;
      },
      ocualtarTab: function() {
         return this.tabs == 0;
      },
      ocualtarTab2: function() {
         return this.tabs == 1;
      },
      ocualtarTab3: function() {
         return this.tabs == 2;
      }
   },
   watch: {
      mensaje(val) {
         this.alert = true;
      }
   },
   mounted() {
      var self = this;
      axios.get("/profesors").then(function(res) {
         var crs = res.data;
         var profesores = [];
         for (let index = 0; index < crs.length; index++) {
            crs[index].selected = false;
            profesores[index] = crs[index];
         }
         self.profesores = self.profesorstock = profesores;
      });
      axios.get("/cursos").then(function(res) {
         var crs = res.data;
         var cursos = [];
         for (let index = 0; index < crs.length; index++) {
            crs[index].selected = false;
            cursos[index] = crs[index];
         }
         self.cursos = self.cursostock = cursos;
      });
   }
};
</script>

<style scoped>
.mar {
   margin-top: -40px;
}
.mar2 {
   margin-top: 70px;
   width: 600px;
}
.tm {
   height: 400px;
}
.alert {
   position: absolute;
   z-index: 2;
   right: 0;
}
</style>