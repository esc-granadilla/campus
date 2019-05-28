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
                        label="Buscar Sección"
                        prepend-inner-icon="search"
                        solo-inverted
                        v-model="search"
                     ></v-text-field>
                  </v-flex>
                  <v-layout v-if="!ocualtarTab" xs12 justify-center align-center wrap>
                     <v-btn block flat xs12 round @click="enviar">Asignar Horario(s) al curso</v-btn>
                  </v-layout>
                  <template v-slot:extension>
                     <v-tabs
                        v-model="tabs"
                        centered
                        color="transparent"
                        slider-color="white"
                        change
                     >
                        <v-tab
                           v-for="a in accions"
                           :key="a.id"
                           :disabled="a.id==2 ? noSelected : false"
                        >{{ a.text }}</v-tab>
                     </v-tabs>
                  </template>
               </v-toolbar>

               <v-tabs-items v-model="tabs">
                  <v-tab-item :key="1">
                     <selectsectioncomponent
                        :search="search"
                        v-on:speak="SelectSectionMethod($event)"
                     ></selectsectioncomponent>
                  </v-tab-item>
                  <v-tab-item :key="2">
                     <!-- <div>
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
                     </div>-->
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
         noSelected: true,
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
         horarios: [],
         section: null,
         accions: [
            {
               id: 1,
               text: "Sección"
            },
            {
               id: 2,
               text: "Alumnos"
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
      SelectSectionMethod: function(msg) {
         this.noSelected = msg.noSelected;
         if (!this.noSelected) this.section = msg.section;
         else this.section = null;
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
      },
      mensaje(val) {
         this.alert = true;
      }
   },
   mounted() {
      // var self = this;
      // axios.get("/cursos").then(function(res) {
      //    var crs = res.data;
      //    var cursos = [];
      //    for (let index = 0; index < crs.length; index++) {
      //       crs[index].selected = false;
      //       cursos[index] = crs[index];
      //    }
      //    self.cursos = self.cursostock = cursos;
      // });
      // axios.get("/horarios").then(res => (this.horarios = res.data));
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