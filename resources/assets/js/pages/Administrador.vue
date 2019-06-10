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
               <v-list-group prepend-icon="offline_pin">
                  <template v-slot:activator>
                     <v-list-tile>
                        <v-list-tile-title>Asignaciones</v-list-tile-title>
                     </v-list-tile>
                  </template>
                  <v-layout pl-5>
                     <v-list-tile
                        v-for="(crud, i) in asignaciones"
                        :key="i"
                        @click="$router.push(crud[2])"
                     >
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-layout>
               </v-list-group>
            </v-list>
         </v-navigation-drawer>
      </template>
      <v-flex>
         <transition name="component-fade" mode="out-in">
            <router-view></router-view>
         </transition>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["name"],
   data() {
      return {
         drawer: true,
         items: [
            {
               title: "Credenciales",
               icon: "account_balance_wallet",
               ruta: "credencial"
            },
            {
               title: "Asignaturas",
               icon: "class",
               ruta: "asignatura"
            },
            {
               title: "Horarios",
               icon: "access_alarm",
               ruta: "horario"
            },
            {
               title: "Secciones",
               icon: "supervised_user_circle",
               ruta: "seccion"
            },
            {
               title: "Cursos",
               icon: "donut_small",
               ruta: "curso"
            },
            {
               title: "Profesores",
               icon: "school",
               ruta: "profesor"
            },
            {
               title: "Estudiantes",
               icon: "account_circle",
               ruta: "estudiante"
            },
            {
               title: "Noticias",
               icon: "notifications",
               ruta: "anoticias"
            }
         ],
         asignaciones: [
            ["Alumnos a Sección", "swap_horizontal_circle", "seccion_alumnos"],
            ["Lecciones a Curso", "swap_horizontal_circle", "curso_leccion"]
         ],
         mini: true,
         right: null
      };
   }
};
</script>

<style scoped lang="css">
.component-fade-enter-active,
.component-fade-leave-active {
   transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active below version 2.1.8 */ {
   opacity: 0;
}
.component-fade-leave-active {
   animation: bounce-in 0.5s reverse;
}
.component-fade-enter {
   animation: bounce-in 0.5s;
}
@keyframes bounce-in {
   0% {
      transform: scale(0);
   }
   50% {
      transform: scale(1.2);
   }
   100% {
      transform: scale(1);
   }
}
</style>
