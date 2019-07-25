<template>
   <div class="header">
      <div class="textos">
         <h1 class="titulo">Escuela Granadilla Norte</h1>
         <h3 class="subtitulo">Campus Virtual</h3>
         <v-btn class="boton" @click="route('/login')">Ingresar</v-btn>
      </div>
      <div class="sesgoabajo"></div>
   </div>
</template>

<script>
export default {
   name: "headercomponent",
   data() {
      return {};
   },
   methods: {
      route(ruta) {
         location.href = ruta;
      }
   }
};
</script>

<style scoped lang="css">
.header {
   width: 100%;
   height: 650px;
   background-attachment: fixed;
   background-size: cover;
   position: relative;
   overflow: hidden;
   text-align: center;
   background-image: url("../../../img/Skewed.jpg");
   background-position-y: 56px;
}

.header .textos {
   margin-top: 250px;
}

.header .titulo {
   font-size: 85px;
}

.header .subtitulo {
   font-size: 42px;
   font-weight: 300;
   margin-bottom: 32px;
}

.header .boton {
   display: inline-block;
   padding: 6px;
   padding-left: 40px;
   padding-right: 40px;
   border: 2px solid rgb(0, 70, 3);
   color: rgb(0, 51, 20);
   font-size: 19px;
   text-align: center;
   text-decoration: none;
   border-radius: 16px;
   z-index: 11;
   position: relative;
}

.header a:hover {
   border: 2px solid rgb(23, 153, 29);
   background-color: rgba(22, 153, 29, 0.5);
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

.container {
   -webkit-box-flex: 1;
   -ms-flex: 1 1 100%;
   flex: 1 1 100%;
   margin: auto;
   padding: 0px;
   width: 100%;
}

@media screen and (max-width: 960px) {
   .header .textos {
      margin-top: 180px;
   }

   .header .titulo {
      font-size: 75px;
   }
   .header .subtitulo {
      font-size: 25px;
      margin-bottom: 32px;
   }
}

@media screen and (max-width: 610px) {
   .header .textos {
      margin-top: 130px;
   }

   .header .titulo {
      font-size: 65px;
   }
   .header .subtitulo {
      font-size: 25px;
      margin-bottom: 32px;
   }
}

@media screen and (max-width: 492px) {
   .header .textos {
      margin-top: 100px;
   }

   .header .titulo {
      font-size: 55px;
   }

   .header .subtitulo {
      font-size: 20px;
      margin-bottom: 32px;
   }
}
</style>