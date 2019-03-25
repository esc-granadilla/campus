<template>
   <v-layout justify-center wrap>
      <v-card class="mar2" absolute>
         <v-layout justify-center wrap>
            <v-flex md10 class="mar">
               <v-toolbar color="green" dark tabs>
                  <v-flex v-if="ocualtarTab">
                     <v-text-field
                        class="mx-3"
                        flat
                        label="Buscar Nombre"
                        prepend-inner-icon="search"
                        solo-inverted
                        v-model="search"
                        @keydown="buscar()"
                     ></v-text-field>
                  </v-flex>
                  <v-layout v-if="!ocualtarTab" xs12 justify-center align-center wrap>
                     <v-btn block flat xs12 round @click="enviar">Asignar Horario(s) al curso</v-btn>
                  </v-layout>
                  <template v-slot:extension>
                     <v-tabs v-model="tabs" centered color="transparent" slider-color="white">
                        <v-tab v-for="a in accions" :key="a.id">{{ a.text }}</v-tab>
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
                  <v-tab-item :key="2">
                     <div>
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
         headers: [
            {
               text: "Desde:",
               align: "left",
               value: "desde"
            },
            { text: "Hasta", value: "hasta" }
         ],
         cursos: [],
         cursostock: [],
         horarios: [],
         curso: null,
         accions: [
            {
               id: 1,
               text: "Curso"
            },
            {
               id: 2,
               text: "Horario"
            }
         ]
      };
   },
   methods: {
      toggleAll() {
         if (this.selected.length) this.selected = [];
         else this.selected = this.desserts.slice();
      },
      changeSort(column) {
         if (this.pagination.sortBy === column) {
            this.pagination.descending = !this.pagination.descending;
         } else {
            this.pagination.sortBy = column;
            this.pagination.descending = false;
         }
      },
      buscar(event) {
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
      selectedCurso(curso) {
         if (curso != null && !curso.selected) {
            if (this.curso != null) this.curso.selected = false;
            curso.selected = true;
            this.curso = curso;
            axios
               .get("cursohorario/" + curso.id)
               .then(res => (this.cursoshorarios = res.data));
            var nuevos = [];
            nuevos.push(curso);
            this.cursos = nuevos;
         } else {
            if (this.curso != null) this.curso.selected = false;
            if (curso != null) curso.selected = false;
            this.curso = null;
            this.cursos = this.cursostock;
         }
      },
      enviar() {
         axios
            .post("asigcursohorario/" + this.curso.id, {
               horarios: this.selected
            })
            .then(res => (this.mensaje = res.data));
      }
   },
   computed: {
      ocualtarTab: function() {
         return this.tabs == 0;
      }
   },
   watch: {
      tabs(val) {
         if (val == 1) {
            this.selected = [];
            this.cursoshorarios.forEach(ch => {
               this.horarios.forEach(h => {
                  if (h.id == ch.id) this.selected.push(h);
               });
            });
         }
      }
   },
   mounted() {
      var self = this;
      axios.get("/cursos").then(function(res) {
         var crs = res.data;
         var cursos = [];
         for (let index = 0; index < crs.length; index++) {
            crs[index].selected = false;
            cursos[index] = crs[index];
         }
         self.cursos = self.cursostock = cursos;
      });
      axios.get("/horarios").then(res => (this.horarios = res.data));
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
   /*position: absolute;*/
}
.tm {
   height: 400px;
}
</style>