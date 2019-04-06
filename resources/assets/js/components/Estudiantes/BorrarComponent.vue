<template>
   <div>
      <div class="alert">
         <v-alert v-model="alert" dismissible :type="alerttype">{{ mensaje.message }}</v-alert>
      </div>
      <v-flex md8 xs12 offset-md2>
         <v-flex xs12 pt-2 px-3>
            <v-layout wrap row class="elevation-12">
               <v-toolbar color="green" dark xs12 class="mar">
                  <v-text-field
                     class="mx-3"
                     flat
                     label="Buscar por Cedula"
                     prepend-inner-icon="search"
                     solo-inverted
                     v-model="search"
                     @keydown="buscar()"
                  ></v-text-field>
               </v-toolbar>
               <v-layout wrap mx-5 xs6>
                  <v-flex xs6 pt-2 px-3>
                     <v-text-field
                        v-model="estudiante.nombre"
                        counter
                        label="Nombre"
                        name="nombre"
                        required
                     ></v-text-field>
                  </v-flex>
                  <v-flex xs6 pt-2 px-3>
                     <v-text-field
                        xs12
                        v-model="estudiante.primer_apellido"
                        label="Primer Apellido"
                        name="primer_apellido"
                        readonly
                     ></v-text-field>
                  </v-flex>
                  <v-flex xs6 pt-2 px-3>
                     <v-text-field
                        v-model="estudiante.segundo_apellido"
                        label="Segundo Apellido"
                        name="segundo_apellido"
                        readonly
                     ></v-text-field>
                  </v-flex>
                  <v-flex xs6 pt-2 px-3>
                     <v-text-field
                        v-model="estudiante.fecha_nacimiento"
                        label="Fecha Nacimiento"
                        name="fecha_nacimiento"
                        xs12
                        readonly
                     ></v-text-field>
                  </v-flex>
               </v-layout>
               <v-layout wrap mx-5 xs6>
                  <v-flex xs6 d-flex px-3>
                     <v-text-field
                        v-model="estudiante.grado"
                        label="Grado"
                        name="grado"
                        readonly
                        xs12
                     ></v-text-field>
                  </v-flex>
                  <v-flex xs6 d-flex px-3>
                     <v-text-field
                        v-model="estudiante.adecuacion"
                        xs12
                        label="Adecuacion"
                        name="adecuacion"
                        readonly
                     ></v-text-field>
                  </v-flex>
                  <v-flex xs12 d-flex px-3 mt-5>
                     <v-btn round dark flat color="red" block @click="eliminar">Eliminar</v-btn>
                  </v-flex>
               </v-layout>
            </v-layout>
         </v-flex>
      </v-flex>
   </div>
</template>

<script>
export default {
   name: "borrarcomponent",
   data() {
      return {
         search: "",
         estudiante: {
            id: null,
            cedula: "",
            nombre: "",
            primer_apellido: "",
            segundo_apellido: "",
            fecha_nacimiento: null,
            grado: "",
            adecuacion: ""
         },
         alert: false,
         alerttype: "success",
         mensaje: []
      };
   },
   methods: {
      buscar(event) {
         if (window.event.keyCode == 13) {
            axios
               .get("estudiantes/" + this.search)
               .then(res => (this.estudiante = res.data));
         }
      },
      eliminar() {
         if (this.estudiante.id != null) {
            axios
               .delete("estudiantes/" + this.estudiante.id)
               .then(res => (this.mensaje = res.data));
         }
      }
   },
   watch: {
      mensaje(val) {
         this.alert = true;
      }
   }
};
</script>

<style scoped>
.mar {
   margin-bottom: 5em;
}
.alert {
   position: absolute;
   z-index: 2;
   right: 0;
}
</style>