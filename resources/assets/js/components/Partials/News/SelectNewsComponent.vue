<template>
   <v-flex>
      <dialogdelete
         :text="text"
         :title="title"
         :dialogDeletes="dialogDelete"
         v-on:speak="borrarMethod($event)"
      ></dialogdelete>
      <createnewsdialog
         :tipo="tipo"
         :accion="'edit'"
         :data="data"
         v-on:speak="actualizarMethod($event)"
      ></createnewsdialog>
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
                     <v-btn flat dark>ver mas</v-btn>
                     <v-icon small class="mr-2" @click="select(props.item)">edit</v-icon>
                     <v-icon small @click="noticia = props.item; dialogDelete= true;">delete</v-icon>
                  </v-card-actions>
               </v-card>
            </v-flex>
         </template>
      </v-data-iterator>
   </v-flex>
</template>

<script>
import dialogdelete from "../../Modals/DialogDelete.vue";
import createnewsdialog from "../../Modals/News/CreateNewsDialog.vue";

export default {
   components: {
      createnewsdialog,
      dialogdelete
   },
   props: ["news", "tipo"],
   data() {
      return {
         rowsPerPageItems: [3, 6, 9],
         dialogDelete: false,
         title: "Eliminar Noticia?",
         text: "Seguro que quieres eliminar esta Noticia.",
         pagination: {
            rowsPerPage: 3
         },
         mensaje: "",
         data: null,
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
      eliminar() {
         var self = this;
         if (this.noticia.id != null) {
            axios.delete("news/" + this.noticia.id).then(function(res) {
               if (res.data.type == "success") self.$emit("speak", true);
               self.mensaje = res.data;
            });
         }
      },
      select(news) {
         this.data = {
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
            this.data.files.push({
               id: f.if,
               titulo: f.titulo,
               tipo: f.tipo,
               link: f.link,
               news_id: f.news_id
            });
         });
      },
      borrarMethod: function(msg) {
         this.dialogDelete = msg.dialogdelete;
         if (msg.Delete) this.eliminar();
      },
      actualizarMethod: function(msj) {
         this.$emit("speak", true);
      }
   },
   watch: {
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
   }
};
</script>
<style scoped>
.jcr {
   justify-content: flex-end;
}
</style>
