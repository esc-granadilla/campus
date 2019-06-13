<template>
   <v-container grid-list-md>
      <v-flex>
         <shownewsdialog :news="newstemp" v-on:speak="cerrarMethod($event)"></shownewsdialog>
         <v-data-iterator
            :items="news"
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
                           <v-img :src="getimagen(props.item)" height="125px" contain></v-img>
                        </v-flex>
                        <v-flex xs7>
                           <v-card-title primary-title>
                              <div>
                                 <div
                                    class="headline"
                                 >{{props.item.titulo.length > 16?props.item.titulo.substr(0,14)+"...":props.item.titulo}}</div>
                                 <div>{{props.item.descripcion!=null?(props.item.descripcion.length > 25?props.item.descripcion.substr(0,24)+"...":props.item.descripcion):"Noticia"}}</div>
                                 <div>{{props.item.fecha}}</div>
                              </div>
                           </v-card-title>
                        </v-flex>
                     </v-layout>
                     <v-divider light></v-divider>
                     <v-card-actions class="pa-3 jcr">
                        <v-btn flat dark @click="mostrar(props.item)">ver mas</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </template>
         </v-data-iterator>
      </v-flex>
   </v-container>
</template>

<script>
import shownewsdialog from "../../Modals/News/ShowNewsDialog.vue";

export default {
   components: {
      shownewsdialog
   },
   data() {
      return {
         rowsPerPageItems: [3, 6, 9],
         title: "Eliminar Noticia?",
         text: "Seguro que quieres eliminar esta Noticia.",
         pagination: {
            rowsPerPage: 3
         },
         newstemp: null,
         news: [],
         noticia: { id: null }
      };
   },
   methods: {
      getimagen(news) {
         let images = news.files.filter(fi => fi.tipo === "imagen");
         if (images.length > 0) {
            return images[0].link;
         }
         return "/images/2.jpg";
      },
      mostrar(news) {
         this.newstemp = {
            id: news.id,
            titulo: news.titulo,
            descripcion: news.descripcion,
            contenido: news.contenido,
            tipo: news.tipo,
            fecha: news.fecha,
            estado: news.estado,
            course_id: news.course_id,
            files: []
         };
         news.files.forEach(f => {
            this.newstemp.files.push({
               id: f.if,
               titulo: f.titulo,
               tipo: f.tipo,
               link: f.link,
               news_id: f.news_id
            });
         });
      },
      cerrarMethod: function(msj) {
         this.newstemp = null;
      }
   },
   mounted() {
      axios.get("news/0").then(res => (this.news = res.data));
   }
};
</script>
<style scoped>
.jcr {
   justify-content: flex-end;
}
</style>
