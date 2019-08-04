<template>
   <v-layout row wrap>
      <v-layout row wrap>
         <v-flex :class="ttitulo" v-if="news!=null">
            <span class="display-1 font-weight-regular">{{news.titulo}}</span>
            <br />
            <span class="headline" v-if="descripcion">{{news.descripcion}}</span>
         </v-flex>
         <v-flex :class="timagen" v-if="imagen">
            <v-carousel hide-controls height="auto">
               <v-carousel-item v-for="(ima,i) in images" :key="i" :src="ima.link">
                  <v-flex class="text-xs-center" xs12 pt-3>
                     <span
                        class="display-1 text--white text-xs-center"
                        style="color:white;"
                     >{{ima.titulo}}</span>
                  </v-flex>
               </v-carousel-item>
            </v-carousel>
         </v-flex>
      </v-layout>
      <v-flex v-if="contenido" xs12>
         <v-textarea v-model="news.contenido" auto-grow box class="subheading"></v-textarea>
      </v-flex>
      <v-flex v-if="video" xs12>
         <v-flex xs12 v-for="(vi,i) in videos" :key="i" class="text-xs-center">
            <v-flex class="text-xs-center" xs12 pt-3>
               <span class="title">{{vi.titulo}}</span>
            </v-flex>
            <iframe
               width="560"
               height="315"
               :src="vi.link"
               frameborder="0"
               allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
               allowfullscreen
            ></iframe>
         </v-flex>
      </v-flex>
      <v-flex v-if="link" xs12 pl-5 pt-3>
         <v-flex xs12 v-for="(li,i) in links" :key="i">
            <a :href="li.link" target="_blank">{{li.titulo}}</a>
         </v-flex>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["news"],
   data() {
      return {
         imagen: false,
         video: false,
         descripcion: false,
         contenido: false,
         link: false,
         images: [],
         links: [],
         videos: []
      };
   },
   watch: {
      news(val) {
         this.imagen = false;
         this.video = false;
         this.descripcion = false;
         this.contenido = false;
         this.link = false;
         this.images = [];
         this.links = [];
         this.videos = [];
         if (val != null) {
            this.descripcion = val.descripcion != null;
            this.contenido = val.contenido != null;
            val.files.forEach(file => {
               if (file.tipo == "video") {
                  this.video = true;
                  this.videos.push(file);
               }
               if (file.tipo == "archivo") {
                  this.link = true;
                  this.links.push(file);
               }
               if (file.tipo == "imagen") {
                  this.imagen = true;
                  this.images.push(file);
               }
            });
         }
      }
   },
   computed: {
      ttitulo() {
         if (!this.descripcion || !this.imagen) return "xs12";
         return "xs6 order-xs2 pl-4";
      },
      timagen() {
         if (!this.descripcion) return "xs12";
         return "xs6";
      },
      tdescripcion() {
         if (!this.imagen) return "xs12";
         return "xs6";
      }
   }
};
</script>

<style scoped>
</style>
