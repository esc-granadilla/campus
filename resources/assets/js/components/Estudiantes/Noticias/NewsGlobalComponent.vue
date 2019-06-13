<template>
   <v-container>
      <v-layout row wrap v-show="todas">
         <v-flex xs12 v-for="(item, index) in news" :key="index">
            <v-card>
               <v-layout pt-5>
                  <v-flex xs5 ml-1>
                     <v-img :src="getimagen(item)" height="125px" contain></v-img>
                  </v-flex>
                  <v-flex xs7>
                     <v-card-title primary-title>
                        <div>
                           <div
                              class="headline"
                           >{{item.titulo.length > 16?item.titulo.substr(0,14)+"...":item.titulo}}</div>
                           <div>{{item.descripcion!=null?(item.descripcion.length > 25?item.descripcion.substr(0,24)+"...":item.descripcion):"Noticia"}}</div>
                           <div>{{item.fecha}}</div>
                        </div>
                     </v-card-title>
                  </v-flex>
               </v-layout>

               <v-card-actions class="pa-3 jcr">
                  <v-btn flat dark color="green" @click="mostrar(item)">Ver</v-btn>
               </v-card-actions>
            </v-card>
            <br>
         </v-flex>
      </v-layout>
      <v-layout row wrap v-show="!todas">
         <shownewscomponent :news="newstemp"></shownewscomponent>
         <v-flex xs12 class="pa-3 text-xs-right">
            <v-btn color="red darken-1" flat @click="todas = true; newstemp = null;">Cerrar</v-btn>
         </v-flex>
      </v-layout>
   </v-container>
</template>

<script>
export default {
   data() {
      return {
         news: [],
         todas: true,
         newstemp: null
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
         this.todas = false;
      }
   },
   mounted() {
      axios.get("news").then(res => (this.news = res.data));
   }
};
</script>

<style scoped>
.jcr {
   justify-content: flex-end;
}
</style>
