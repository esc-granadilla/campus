<template>
   <v-container grid-list-md class="cont">
      <v-form id="nativeForm" method="post" action="/screenstudent" v-show="false">
         <v-text-field id="ids" required hidden name="id"></v-text-field>
      </v-form>
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
      <v-flex class="footer" height="auto">
         <v-card-text style="height: 100px;">
            <v-btn
               absolute
               dark
               fab
               top
               right
               color="indigo darken-4"
               @click="$router.push('/enoticias')"
            >
               1
               <v-icon>add</v-icon>
            </v-btn>
         </v-card-text>
      </v-flex>
   </v-container>
</template>

<script>
export default {
   props: ["estudiante_id"],
   data: () => ({
      rowsPerPageItems: [4, 8],
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
         document.getElementById("ids").value = "" + id;
         nativeForm.submit();
      }
   },
   mounted() {
      var self = this;
      axios.get("/getcoursesstudent/" + this.estudiante_id).then(function(res) {
         self.cursos = res.data;
      });
   }
};
</script>

<style scoped>
.cont {
   height: -webkit-fill-available;
}
.footer {
   bottom: 4px;
   right: 68px;
   position: absolute;
}
</style>
