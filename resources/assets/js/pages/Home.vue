<template>
   <div id="apphome">
      <headercomponent/>
      <div class="main">
         <section class="acerca-de">
            <div class="contenedor">
               <h2 class="sobre-nosotros">Sobre nosotros</h2>
               <h3 class="slogan">Centro Educativo Granadilla</h3>
               <p
                  class="parrafo px-5"
               >El Centro Educativo Granadilla Norte está ubicada en San José, Curridabat Granadilla. Este centro se fundó en 1968 por lo que lleva aproximadamente 50 años de brindar servicios educativos a la población estudiantil de los alrededores de Granadilla.</p>
               <p
                  class="parrafo px-5"
               >Su nombre se debe al nombre de la comunidad de Granadilla, este centro se administró en sus primeros años por medio de los vecinos quienes pagaban a tres profesores para impartir lecciones, se originó por la preocupación de los vecinos quienes querían recibir educación para sus hijos.</p>
               <v-layout row wrap>
                  <v-flex xs6 pa-5>
                     <h3 class="slogan">Misión</h3>
                     <p
                        class="parrafo"
                     >Proyectar la institución con una educación de calidad, que permita una visión inclusiva donde se promueva la participación de toda la comunidad educativa, superando las barreras para el acceso al estudiantado y atendiendo la diversidad por medio de actividades innovadoras.</p>
                  </v-flex>
                  <v-flex xs6 pa-5>
                     <h3 class="slogan">Visión</h3>
                     <p
                        class="parrafo"
                     >Brindar una educación integral que promueva el desarrollo de estudiantes creativos, críticos e independientes, capaces de formar su proyecto de vida comprometidos con el respeto y la vivencia de los derechos humanos en su comunidad.</p>
                  </v-flex>
               </v-layout>
            </div>
         </section>
         <section class="galeria">
            <div class="sesgoarriba"></div>
            <div class="imagenes none">
               <img src="../../img/1.jpg" alt>
            </div>
            <div class="imagenes">
               <img src="../../img/3.jpg" alt>
            </div>
            <div class="imagenes">
               <img src="../../img/2.jpg" alt>
               <div class="encima">
                  <h2>Herramientas Escolares</h2>
                  <div></div>
               </div>
            </div>
            <div class="imagenes">
               <img src="../../img/4.jpeg" alt>
            </div>
            <div class="imagenes none">
               <img src="../../img/5.jpeg" alt>
            </div>
            <div class="sesgoabajo"></div>
         </section>
         <section class="miembros">
            <div class="contenedor">
               <h2 class="sobre-nosotros">Nuestros Servicios</h2>
               <h3 class="slogan">Conoce algunas utilidades del campus</h3>
               <div class="cards">
                  <div class="card">
                     <img src="../../img/homevideos.jpg" alt>
                     <h4>Videos</h4>
                     <p>Incorporación de videos infomativos.</p>
                  </div>
                  <div class="card">
                     <img src="../../img/hometareas.jpg" alt>
                     <h4>Tareas</h4>
                     <p>Creación de tareas de selección.</p>
                  </div>
                  <div class="card">
                     <img src="../../img/homenoticias.png" alt>
                     <h4>Noticias</h4>
                     <p>Inserción de noticias estudiantiles.</p>
                  </div>
               </div>
            </div>
         </section>
         <section class="fondo">
            <div class="sesgoarriba"></div>
            <div class="contenedor">
               <h2 class="titulo-patrocinadores">Innovación educativa</h2>
               <h3 class="subtitulo-patrocinadores">Nuevo centro educativo</h3>
               <div class="clientes">
                  <div class="cliente">
                     <img src="../../img/granadilla3.jpeg" alt>
                  </div>
                  <div class="cliente">
                     <img src="../../img/granadilla2.jpeg" alt>
                  </div>
                  <div class="cliente">
                     <img src="../../img/granadilla1.jpeg" alt>
                  </div>
               </div>
               <h3 class="subtitulo-patrocinadores especial">Centro educativo verde y sustentable.</h3>
            </div>
            <div class="sesgoabajo-unico"></div>
         </section>
      </div>
      <footercomponent/>
   </div>
</template>


<script>
import headercomponent from "../components/Home/HeaderComponent.vue";
import footercomponent from "../components/Home/FooterComponent.vue";

export default {
   name: "apphome",
   components: {
      headercomponent,
      footercomponent
   },
   methods: {}
};
</script>

<style scoped lang="css">
* {
   margin: 0;
   padding: 0;
   box-sizing: border-box;
}

body {
   font-family: "open sans";
   font-size: 16px;
}

#apphome {
   line-height: normal;
   position: absolute;
   left: 0;
   top: 0;
   margin: 0;
   padding: 0;
   box-sizing: border-box;
}

.sesgoarriba {
   z-index: 10;
   position: absolute;
   top: 0;
   left: 0;
   border-width: 35vh 100vw 0 0;
   border-style: solid;
   border-color: #fff transparent transparent transparent;
}

.sesgoabajo {
   z-index: 10;
   position: absolute;
   bottom: 0;
   left: 0;
   border-width: 0 0 35vh 100vw;
   border-style: solid;
   border-color: transparent transparent #fff transparent;
}

.contenedor {
   width: 90%;
   max-width: 1000px;
   margin: auto;
   overflow: hidden;
   padding: 52px 0;
}

/* Main */

.sobre-nosotros {
   text-align: center;
   font-size: 56px;
   margin-bottom: 10px;
   font-weight: 600;
}

.slogan {
   font-size: 24px;
   font-weight: 300;
   text-align: center;
   margin-bottom: 24px;
}

.parrafo {
   margin-bottom: 13px;
   font-weight: 300;
   text-align: justify;
   line-height: 24px;
   color: rgb(24, 16, 16);
}

.acerca-de {
   background-color: #fff;
}

.acerca-de .boton {
   display: inline-block;
   padding: 6px;
   width: 128px;
   font-weight: 300;
   border: 1px solid rgba(24, 16, 16, 0.7);
   color: #181010;
   font-size: 16px;
   text-align: center;
   text-decoration: none;
   border-radius: 16px;
   margin-top: 24px;
}

.galeria {
   width: 100%;
   height: 500px;
   overflow: hidden;
   display: flex;
   position: relative;
   flex-wrap: wrap;
}

.imagenes {
   width: 20%;
   height: 500px;
   overflow: hidden;
   position: relative;
}

.imagenes img {
   width: 100%;
   height: 100%;
   object-fit: cover;
}

.miembros {
   background-color: #fff;
}

.encima {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: rgba(52, 73, 94, 0.815);
}

.encima h2 {
   position: relative;
   top: 45%;
   text-align: center;
   color: #fff;
}

.encima div {
   position: relative;
   display: block;
   top: 46%;
   width: 40px;
   height: 5px;
   background: #fff;
   margin: auto;
}

.card {
   margin: 20px 0;
   width: 30%;
   height: 250px;
   text-align: center;
   padding: 20px;
   box-shadow: 0px 0px 4px 0 rgba(52, 73, 94, 0.849);
}

.cards {
   width: 100%;
   margin: auto;
   display: flex;
   flex-wrap: wrap;
   justify-content: space-around;
}

.cards img {
   width: 140px;
   height: 140px;
   object-fit: cover;
   border-radius: 100%;
   margin: auto;
}

.fondo {
   height: 900px;
   position: relative;
   overflow: hidden;
   background-attachment: fixed;
   background-position: center;
   background-size: cover;
   padding-top: 130px;
   background-image: url("../../img/fondo.png");
}

.sesgoabajo-unico {
   z-index: 10;
   position: absolute;
   bottom: 0;
   left: 0;
   border-width: 0 0 35vh 100vw;
   border-style: solid;
   border-color: transparent transparent #2c3e50 transparent;
}

.titulo-patrocinadores,
.subtitulo-patrocinadores {
   color: #fff;
   text-align: center;
}

.titulo-patrocinadores {
   font-size: 56px;
   margin-top: 48px;
}

.subtitulo-patrocinadores {
   font-size: 24px;
   font-weight: 300;
   margin-bottom: 64px;
}

.clientes {
   display: flex;
   flex-wrap: wrap;
   margin-bottom: 64px;
   width: 100%;
   justify-content: space-between;
}

.cliente {
   width: 30%;
}

.cliente img {
   width: 100%;
}

/* Responsive */

@media screen and (max-width: 900px) {
   .card {
      width: 48%;
   }
}

@media screen and (max-width: 610px) {
   .none {
      display: none;
   }
   .imagenes {
      flex-grow: 1;
   }
   .card {
      width: 90%;
   }
   .fondo {
      height: auto;
   }
   .especial {
      display: none;
   }
   .cliente {
      width: 80%;
      height: auto;
      margin-bottom: 50px;
   }
   .clientes {
      justify-content: center;
   }
}

@media screen and (max-width: 380px) {
   .sobre-nosotros {
      font-size: 46px;
   }
   .slogan {
      font-size: 20px;
   }
   .titulo-patrocinadores {
      font-size: 46px;
   }
   .subtitulo-patrocinadores {
      font-size: 20px;
   }
   .clientes {
      justify-content: center;
   }
}
</style>

