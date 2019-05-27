<template>
   <v-container grid-list-md>
      <v-data-iterator
         :items="cursos"
         :rows-per-page-items="rowsPerPageItems"
         :pagination.sync="pagination"
         rowsPerPageText="Elementos por página:"
         rowsPerPageAll="Todos"
         pageText="{0}-{1} de {2}"
         noResultsText="Ningún resultado a mostrar"
         nextPage="Página siguiente"
         prevPage="Página anterior"
         noDataText="Ningún dato disponible"
         content-tag="v-layout"
         row
         wrap
      >
         <template v-slot:item="props">
            <v-flex xs12 sm6 md4 lg3>
               <v-card>
                  <v-card-title>
                     <h4>{{ props.item.curso.nombre }}</h4>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-list dense>
                     <v-list-tile>
                        <v-list-tile-content>Sección:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{ props.item.seccion.seccion }}</v-list-tile-content>
                     </v-list-tile>
                     <v-list-tile>
                        <v-list-tile-content class="align-center">
                           <v-btn
                              round
                              dark
                              color="primary"
                              block
                              @click="seleccionarCurso(props.item.id)"
                           >Seleccionar</v-btn>
                        </v-list-tile-content>
                     </v-list-tile>
                  </v-list>
               </v-card>
            </v-flex>
         </template>
      </v-data-iterator>
   </v-container>
</template>

<script>
export default {
   props: ["profesor_id"],
   data: () => ({
      rowsPerPageItems: [4, 8, 12],
      pagination: {
         rowsPerPage: 4
      },
      cursos: [],
      selectedCurso: {
         id: 0,
         course_id: 0,
         section_id: 0
      }
   }),
   methods: {
      seleccionarCurso(id) {
         location.href = "/panelprofesor/" + id;
         //alert(c_id + " " + g_id + " " + h_id + " " + d_id);
      },
      buscarCurso(event) {
         /* var self = this;
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
         } */
      }
   },
   computed: {},
   watch: {},
   mounted() {
      var self = this;
      axios.get("/getCursosProfesor/" + this.profesor_id).then(function(res) {
         self.cursos = res.data;
      });
   }
};
</script>