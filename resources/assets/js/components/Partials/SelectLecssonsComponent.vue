<template>
   <v-flex>
      <combostudents
         :students="studentstock"
         :dialogOpens="dialogOpen"
         v-on:speak="nuevoMethod($event)"
      ></combostudents>
      <v-data-table
         v-model="selected"
         :headers="headers"
         :items="students"
         :pagination.sync="pagination"
         rowsPerPageText="Elementos por página:"
         rowsPerPageAll="Todos"
         pageText="{0}-{1} de {2}"
         noResultsText="Ningún resultado a mostrar"
         nextPage="Página siguiente"
         prevPage="Página anterior"
         noDataText="Ningún dato disponible"
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
            <tr :active="props.selected" @click="props.selected = !props.selected">
               <td>
                  <v-checkbox :input-value="props.selected" hide-details></v-checkbox>
               </td>
               <td class="text-xs-center">{{ props.item.dia.dia }}</td>
               <td class="text-xs-center">{{ props.item.horario.desde }}</td>
               <td
                  class="text-xs-center"
               >{{ props.item.primer_apellido }} {{ props.item.horario.hasta }}</td>
            </tr>
         </template>
      </v-data-table>
      <v-layout row>
         <v-btn color="warning" flat="flat" @click="dialogOpent=true">Pasar a</v-btn>
         <v-spacer></v-spacer>
         <v-btn color="info" flat="flat" @click="dialogOpen=true">Agregar Nuevo</v-btn>
         <v-btn color="success" flat="flat" @click="salvar()">Salvar</v-btn>
      </v-layout>
   </v-flex>
</template>

<script>
import combostudents from "../Asignaciones/Modals/ComboStudents.vue";
import combosections from "../Asignaciones/Modals/ComboSections.vue";

export default {
   name: "selectlessons",
   components: {
      combostudents,
      combosections
   },
   data() {
      return {
         dialogOpen: false,
         pagination: {
            sortBy: "dia",
            rowsPerPage: 4
         },
         selected: [],
         mensaje: [],
         headers: [
            {
               text: "Dia:",
               align: "left",
               value: "dia"
            },
            { text: "Desde", value: "desde" },
            { text: "Hasta", value: "hasta" }
         ],
         lessons: [],
         lessonstock: []
      };
   },
   props: ["seleccionados", "sections"],
   methods: {
      toggleAll() {
         if (this.selected.length) this.selected = [];
         else this.selected = this.students.slice();
      },
      changeSort(column) {
         if (this.pagination.sortBy === column) {
            this.pagination.descending = !this.pagination.descending;
         } else {
            this.pagination.sortBy = column;
            this.pagination.descending = false;
         }
      },
      salvar() {
         this.$emit("speak", { Students: this.selected });
      },
      nuevoMethod: function(msg) {
         this.dialogOpen = msg.dialogselect;
         if (msg.Selected) {
            if (!this.selected.some(e => e.id === msg.Student.id)) {
               if (this.students.some(e => e.id === msg.Student.id)) {
                  this.selected.push(msg.Student);
               } else {
                  this.students.push(msg.Student);
                  this.selected.push(msg.Student);
               }
            }
         }
      }
   },
   watch: {
      seleccionados(val) {
         let self = this;
         this.lessons = [];
         val.forEach(lesson => {
            self.lessons.push(lesson);
         });
         this.toggleAll();
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
      //axios.get("/students").then(res => (this.studentstock = res.data));
   }
};
</script>

<style scope>
</style>
