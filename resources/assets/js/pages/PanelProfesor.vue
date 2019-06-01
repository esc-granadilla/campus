<template>
   <v-layout row fill-height>
      <template>
         <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            hide-overlay
            stateless
            fill-height
         >
            <v-toolbar flat class="transparent">
               <v-toolbar-side-icon @click.stop="mini = !mini"></v-toolbar-side-icon>
               <v-toolbar-title style="text-transform:capitalize;">{{this.name}}</v-toolbar-title>
            </v-toolbar>

            <v-list class="pt-0" dense>
               <v-divider></v-divider>
               <v-list-tile
                  v-for="item in items"
                  :key="item.title"
                  @click="$router.push(item.ruta)"
               >
                  <v-list-tile-action>
                     <v-icon>{{ item.icon }}</v-icon>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
               </v-list-tile>
            </v-list>
         </v-navigation-drawer>
      </template>
      <v-flex>
         <router-view></router-view>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["name"],
   data: () => ({
      drawer: true,
      items: [
         {
            title: "Noticias",
            icon: "notifications",
            ruta: "pnoticias"
         },
         {
            title: "Notas",
            icon: "spellcheck",
            ruta: "pnotas"
         },
         {
            title: "Promedios",
            icon: "trending_up",
            ruta: "ppromedios"
         },
         {
            title: "Tareas o Pruebas",
            icon: "local_parking",
            ruta: "ptareas"
         }
      ],
      mini: true,
      right: null,
      curso: [],
      estudiantes: []
   }),
   methods: {
      seleccionarCurso(id) {
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
   mounted() {}
};
</script>