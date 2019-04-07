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
                           @keydown="buscarEstudiante()"
                        ></v-text-field>
                     </v-flex>
                     <v-flex v-if="ocualtarTab1">
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
                     <v-flex v-if="ocualtarTab2">
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
                     <v-layout v-if="ocualtarTab3" xs12 justify-center align-center wrap>
                        <v-btn block flat xs12 round @click="enviar">Asignar Estudiante al curso</v-btn>
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
                                       <v-subheader>Estudiantes</v-subheader>
                                       <v-list-tile
                                          @click.prevent="selectedEstudiante(e)"
                                          v-for="e in estudiantes"
                                          :key="e.id"
                                       >
                                          <v-list-tile-action>
                                             <v-checkbox
                                                v-model="e.selected"
                                                @click.prevent="selectedEstudiante(e)"
                                             ></v-checkbox>
                                          </v-list-tile-action>

                                          <v-list-tile-content>
                                             <v-list-tile-title>{{'Ced: '}}{{ e.cedula }}{{' - '}}{{ e.nombre }}{{' '}}{{ e.primer_apellido }}{{' '}}{{ e.segundo_apellido }}</v-list-tile-title>
                                             <v-list-tile-sub-title>{{'Grado: '}}{{ e.grado }}{{' - Adecuación: '}}{{ e.adecuacion }}</v-list-tile-sub-title>
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
                     <v-tab-item :key="4">
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
         horariostock: [],
         alert: false,
         alerttype: "success",
         dia: [],
         dias: [],
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
         estudiantes: [],
         estudiantestock: [],
         horarios: [],
         profesor: null,
         estudiante: null,
         accions: [
            {
               id: 1,
               text: "Estudiante",
               invisible: false
            },
            {
               id: 2,
               text: "Curso",
               invisible: true
            },
            {
               id: 3,
               text: "Profesor",
               invisible: true
            },
            {
               id: 4,
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
      buscarEstudiante(event) {
         var self = this;
         if (window.event.keyCode == 13) {
            var est = self.estudiantestock.find(function(estudiante) {
               return estudiante.cedula.toString() === self.search;
            });
            if (est != null)
               est = {
                  id: est.id,
                  nombre: est.nombre,
                  cedula: est.cedula,
                  primer_apellido: est.primer_apellido,
                  segundo_apellido: est.segundo_apellido,
                  grado: est.grado,
                  adecuacion: est.adecuacion,
                  selected: false
               };
            self.selectedEstudiante(est);
         }
      },
      selectedCurso(curso) {
         if (curso != null && !curso.selected) {
            if (this.curso != null) this.curso.selected = false;
            curso.selected = true;
            this.curso = curso;
            var nuevos = [];
            nuevos.push(curso);
            this.cursos = nuevos;
            var self = this;
            axios
               .get(
                  "showprofesorscurso/" +
                     this.estudiante.id +
                     "/" +
                     curso.id +
                     "/" +
                     this.estudiante.grado
               )
               .then(function(res) {
                  self.profesores = res.data;
                  self.profesorstock = res.data;
               });
            this.search = "";
            this.accions[2].invisible = false;
         } else {
            if (this.curso != null) this.curso.selected = false;
            if (curso != null) curso.selected = false;
            this.curso = null;
            this.cursos = this.cursostock;
            this.selectedProfesor(null);
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
            var self = this;
            axios
               .get(
                  "showhorarioscurso/" +
                     this.estudiante.id +
                     "/" +
                     +profesor.id +
                     "/" +
                     this.curso.id +
                     "/" +
                     this.estudiante.grado
               )
               .then(function(res) {
                  var datos = res.data;
                  self.dias = [];
                  self.horariostock = [];
                  datos.forEach(d => {
                     self.dias.push({ value: d.Dia.id, text: d.Dia.dia });
                     self.horariostock.push({
                        id: d.Dia.id,
                        Horarios: d.Horarios
                     });
                  });
                  if (self.dias.length > 0) {
                     self.dia = {
                        value: datos[0].Dia.id,
                        text: datos[0].Dia.dia
                     };
                     self.horarios = datos[0].Horarios;
                     self.selected = [];
                     self.horarios.forEach(c => {
                        if (c.selected) self.selected.push(c);
                     });
                  }
               });
            this.search = "";
            this.accions[3].invisible = false;
         } else {
            if (this.profesor != null) this.profesor.selected = false;
            if (profesor != null) profesor.selected = false;
            this.profesor = null;
            this.profesores = this.profesorstock;
            this.accions[3].invisible = true;
         }
      },
      selectedEstudiante(estudiante) {
         if (estudiante != null && !estudiante.selected) {
            if (this.estudiante != null) this.estudiante.selected = false;
            estudiante.selected = true;
            this.estudiante = estudiante;
            var nuevos = [];
            nuevos.push(estudiante);
            this.estudiantes = nuevos;
            var self = this;
            axios
               .get("showcursosprofesors/" + estudiante.grado)
               .then(function(res) {
                  self.cursos = res.data;
                  self.cursostock = res.data;
               });
            this.search = "";
            this.accions[1].invisible = false;
         } else {
            if (this.estudiante != null) this.estudiante.selected = false;
            if (estudiante != null) estudiante.selected = false;
            this.estudiante = null;
            this.estudiantes = this.estudiantestock;
            this.accions[1].invisible = true;
            this.selectedCurso(null);
         }
      },
      obtenerHorarios() {
         var self = this;
         this.horarios = this.horariostock.find(function(hora) {
            return hora.id === self.dia.value;
         }).Horarios;
         self.selected = [];
         self.horarios.forEach(c => {
            if (c.selected) self.selected.push(c);
         });
      },
      enviar() {
         axios
            .post(
               "asigcursohorarioestudiante/" +
                  this.estudiante.id +
                  "/" +
                  this.profesor.id +
                  "/" +
                  this.curso.id +
                  "/" +
                  this.estudiante.grado +
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
      ocualtarTab1: function() {
         return this.tabs == 1;
      },
      ocualtarTab2: function() {
         return this.tabs == 2;
      },
      ocualtarTab3: function() {
         return this.tabs == 3;
      }
   },
   watch: {
      mensaje(val) {
         this.alert = true;
      }
   },
   mounted() {
      var self = this;
      axios.get("/estudiantes").then(function(res) {
         var crs = res.data;
         var estudiantes = [];
         for (let index = 0; index < crs.length; index++) {
            crs[index].selected = false;
            estudiantes[index] = crs[index];
         }
         self.estudiantes = self.estudiantestock = estudiantes;
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