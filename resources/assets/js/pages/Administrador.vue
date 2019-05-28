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
               <v-list-group prepend-icon="notifications">
                  <template v-slot:activator>
                     <v-list-tile>
                        <v-list-tile-title>Noticias</v-list-tile-title>
                     </v-list-tile>
                  </template>
                  <v-layout pl-5>
                     <v-list-tile
                        v-for="(crud, i) in noticias"
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
         <router-view></router-view>
      </v-flex>
      <!-- <div class="full" id="cuerpo">
         <router-view>lorem ipsim dolor</router-view>
         <router-link to="/horario"></router-link>
         <div class="full" v-if="mostrar === 'cuerpo'">
            <p>lorem ipsim dolor</p>
         </div>
         <credencial v-if="mostrar === 'credencial'"></credencial>
         <profesorcomponent v-if="mostrar === 'profesor'"></profesorcomponent>
         <estudiantecomponent v-if="mostrar === 'estudiante'"></estudiantecomponent>
         <asignaturacomponent v-if="mostrar === 'asignatura'"></asignaturacomponent>
         <horariocomponent v-if="mostrar === 'horario'"></horariocomponent>
         <acursohorario v-if="mostrar === 'curso/horario'"></acursohorario>
         <acursoprofesor v-if="mostrar === 'curso/profesor'"></acursoprofesor>
         <acursoalumno v-if="mostrar === 'curso/alumno'"></acursoalumno>
      </div>-->
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
               icon: "donut_small",
               ruta: "asignatura"
            },
            {
               title: "Horarios",
               icon: "access_alarm",
               ruta: "horario"
            },
            {
               title: "Secciones",
               icon: "group_work",
               ruta: "seccion"
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
            }
         ],
         asignaciones: [
            ["Alumnos a Sección", "swap_horizontal_circle", "seccion_alumnos"],
            ["Cursos Horarios", "swap_horizontal_circle", "curso/horario"],
            ["Profesor Curso", "swap_horizontal_circle", "curso/profesor"],
            ["Alumno Curso", "swap_horizontal_circle", "curso/alumno"]
         ],
         noticias: [
            ["Mostrar", "insert_drive_file", "noticias/mostrar"],
            ["Crear", "add", "noticias/create"],
            ["Actualizar", "update", "noticias/editar"],
            ["Eliminar", "delete", "noticias/eliminar"]
         ],
         mini: true,
         right: null
      };
   }
};
</script>

<style scoped lang="css">
</style>
