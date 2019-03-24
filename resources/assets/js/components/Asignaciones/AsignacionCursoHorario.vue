<template>
   <v-layout justify-center wrap>
      <v-card class="mar2" absolute>
         <v-layout justify-center wrap>
            <v-flex md10 class="mar">
               <v-toolbar color="green" dark tabs>
                  <v-text-field
                     class="mx-3"
                     flat
                     label="Buscar Codigo"
                     prepend-inner-icon="search"
                     solo-inverted
                  ></v-text-field>

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
                           :items="desserts"
                           :pagination.sync="pagination"
                           select-all
                           item-key="id"
                           class="elevation-1"
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
                                 <td class="text-xs-right expand">{{ props.item.desde }}</td>
                                 <td class="text-xs-right">{{ props.item.hasta }}</td>
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
         tabs: null,
         notifications: false,
         sound: true,
         widgets: false,
         pagination: {
            sortBy: "desde"
         },
         selected: [],
         headers: [
            {
               text: "Desde:",
               align: "left",
               value: "desde"
            },
            { text: "Hasta", value: "hasta" }
         ],
         desserts: [
            {
               id: 5,
               desde: "Frozen Yogurt",
               hasta: 159
            },
            {
               id: 6,
               desde: "Frozen Yogurt",
               hasta: 159
            },
            {
               id: 7,
               desde: "Frozen Yogurt",
               hasta: 159
            }
         ],
         cursos: [],
         cursostock: [],
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
      selectedCurso(curso) {
         if (!curso.selected) {
            curso.selected = true;
            this.curso = curso;
            var nuevos = [];
            nuevos.push(curso);
            this.cursos = nuevos;
         } else {
            curso.selected = false;
            this.curso = null;
            this.cursos = this.cursostock;
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
   position: absolute;
}
.tm {
   height: 400px;
}
</style>