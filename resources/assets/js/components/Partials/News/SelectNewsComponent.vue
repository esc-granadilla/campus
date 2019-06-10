<template>
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
         <v-flex xs12 sm6 lg4>
            <v-card color="cyan darken-2" class="white--text">
               <v-layout>
                  <v-flex xs5 ml-1>
                     <v-img src="/images/2.jpg" height="125px" contain></v-img>
                  </v-flex>
                  <v-flex xs7>
                     <v-card-title primary-title>
                        <div>
                           <div class="headline">Supermodel</div>
                           <div>Foster the People</div>
                           <div>(2014)</div>
                        </div>
                     </v-card-title>
                  </v-flex>
               </v-layout>
               <v-divider light></v-divider>
               <v-card-actions class="pa-3 jcr">
                  <v-btn flat dark>Listen now</v-btn>
                  <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
                  <v-icon small @click="deleteItem(props.item)">delete</v-icon>
               </v-card-actions>
            </v-card>
         </v-flex>
      </template>
   </v-data-iterator>
</template>

<script>
export default {
   data() {
      return {
         rowsPerPageItems: [3, 6, 9],
         pagination: {
            rowsPerPage: 3
         },
         cursos: [{ nombre: "sd", id: 0 }]
      };
   }
};
</script>
<style scoped>
.jcr {
   justify-content: flex-end;
}
</style>
