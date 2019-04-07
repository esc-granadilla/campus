<template>
   <v-layout row fill-height>
      <div>
         <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            hide-overlay
            stateless
            fill-height
         >
            <v-toolbar flat class="transparent">
               <v-toolbar-side-icon
                  @click.stop="mini = !mini"
               ></v-toolbar-side-icon>
                <v-toolbar-title style="text-transform:capitalize;">{{this.name}}</v-toolbar-title>
            </v-toolbar>

            <v-list class="pt-0" dense>
               <v-divider></v-divider>
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
                        @click="route(crud[2])"
                     >
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-layout>
               </v-list-group>
               <v-list-group prepend-icon="notifications">
                  <template v-slot:activator>
                     <v-list-tile>
                        <v-list-tile-title>Noticias</v-list-tile-title>
                     </v-list-tile>
                  </template>
                  <v-layout pl-5>
                     <v-list-tile v-for="(crud, i) in noticias" :key="i" @click="route(crud[2])">
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-layout>
               </v-list-group>
               <v-list-group prepend-icon="account_circle">
                  <template v-slot:activator>
                     <v-list-tile>
                        <v-list-tile-title>Usuarios</v-list-tile-title>
                     </v-list-tile>
                  </template>
                  <v-list-group sub-group no-action>
                     <template v-slot:activator>
                        <v-list-tile>
                           <v-list-tile-title>Estudiantes</v-list-tile-title>
                        </v-list-tile>
                     </template>
                     <v-list-tile v-for="(crud, i) in estudiantes" :key="i" @click="route(crud[2])">
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-list-group>
                  <v-list-group no-action sub-group>
                     <template v-slot:activator>
                        <v-list-tile>
                           <v-list-tile-title>Profesores</v-list-tile-title>
                        </v-list-tile>
                     </template>
                     <v-list-tile v-for="(crud, i) in empleados" :key="i" @click="route(crud[2])">
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-list-group>
               </v-list-group>
            </v-list>
         </v-navigation-drawer>
      </div>
      <v-content app id="cuerpo">
         <v-container fluid class="full">
            <p>lorem ipsim dolor</p>
         </v-container>
         <credencial v-if="mostar === 'credencial'"></credencial>
         <pmostrarcomponent v-if="mostar === 'profesors/mostrar'"></pmostrarcomponent>
         <peditarcomponent v-if="mostar === 'profesors/editar'"></peditarcomponent>
         <pborrarcomponent v-if="mostar === 'profesors/eliminar'"></pborrarcomponent>
         <emostrarcomponent v-if="mostar === 'estudiantes/mostrar'"></emostrarcomponent>
         <eeditarcomponent v-if="mostar === 'estudiantes/editar'"></eeditarcomponent>
         <eborrarcomponent v-if="mostar === 'estudiantes/eliminar'"></eborrarcomponent>
         <cursocomponent v-if="mostar === 'curso'"></cursocomponent>
         <horariocomponent v-if="mostar === 'horario'"></horariocomponent>
         <acursohorario v-if="mostar === 'curso/horario'"></acursohorario>
         <acursoprofesor v-if="mostar === 'curso/profesor'"></acursoprofesor>
         <acursoalumno v-if="mostar === 'curso/alumno'"></acursoalumno>
      </v-content>
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
               title: "Noticias",
               icon: "notifications",
               ruta: "noticias"
            },
            {
               title: "Credenciales",
               icon: "account_balance_wallet",
               ruta: "credencial"
            },
            {
               title: "Cursos",
               icon: "donut_small",
               ruta: "curso"
            },
            {
               title: "Horarios",
               icon: "alarm",
               ruta: "horario"
            }
         ],
         noticias: [ 
            ["Mostrar","insert_drive_file","noticias/mostrar"],
            ["Crear","add","noticias/create"],
            ["Actualizar","update","noticias/editar"],
            ["Eliminar","delete","noticias/eliminar"]
         ],
         empleados: [
            ["Crear", "add", "profesors/create"],
            ["Mostrar", "insert_drive_file", "profesors/mostrar"],
            ["Actualizar", "update", "profesors/editar"],
            ["Eliminar", "delete", "profesors/eliminar"]
         ],
         estudiantes: [
            ["Mostrar", "insert_drive_file", "estudiantes/mostrar"],
            ["Actualizar", "update", "estudiantes/editar"],
            ["Eliminar", "delete", "estudiantes/eliminar"]
         ],
         asignaciones: [
            ["Cursos Horarios", "swap_horizontal_circle", "curso/horario"],
            ["Profesor Curso", "swap_horizontal_circle", "curso/profesor"],
            ["Alumno Curso", "swap_horizontal_circle", "curso/alumno"]
         ],
         mostar: "cuerpo",
         mini: true,
         right: null
      };
   },
   methods: {
      route(ruta) {
         if (ruta !== "profesors/create") {
            this.mostar = ruta;
         } else location.href = ruta;
      }
   },
};
</script>
