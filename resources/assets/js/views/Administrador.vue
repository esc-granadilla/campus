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
               <v-list class="pa-0">
                  <v-list-tile avatar>
                     <v-list-tile-avatar>
                        <v-icon x-large>vertical_split</v-icon>
                     </v-list-tile-avatar>

                     <v-list-tile-content>
                        <v-list-tile-title>{{this.name}}</v-list-tile-title>
                     </v-list-tile-content>

                     <v-list-tile-action>
                        <v-btn icon @click.stop="mini = !mini">
                           <v-icon>chevron_left</v-icon>
                        </v-btn>
                     </v-list-tile-action>
                  </v-list-tile>
               </v-list>
            </v-toolbar>

            <v-list class="pt-0" dense>
               <v-divider></v-divider>
               <v-list-tile v-for="item in items" :key="item.title" @click="route(item.ruta)">
                  <v-list-tile-action>
                     <v-icon>{{ item.icon }}</v-icon>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
               </v-list-tile>
               <v-list-group prepend-icon="account_circle">
                  <template v-slot:activator>
                     <v-list-tile>
                        <v-list-tile-title>Usuarios</v-list-tile-title>
                     </v-list-tile>
                  </template>
                  <v-list-group no-action sub-group>
                     <template v-slot:activator>
                        <v-list-tile>
                           <v-list-tile-title>Empleados</v-list-tile-title>
                        </v-list-tile>
                     </template>

                     <v-list-tile v-for="(crud, i) in empleados" :key="i" @click="route(crud[2])">
                        <v-list-tile-title v-text="crud[0]"></v-list-tile-title>
                        <v-list-tile-action>
                           <v-icon v-text="crud[1]"></v-icon>
                        </v-list-tile-action>
                     </v-list-tile>
                  </v-list-group>

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
               </v-list-group>
            </v-list>
         </v-navigation-drawer>
      </div>
      <div class="full" id="cuerpo">
         <div class="full" v-if="mostar === 'cuerpo'">
            <h1>hola este es el cuerpo</h1>
         </div>
         <credencial v-if="mostar === 'credencial'"></credencial>
         <pmostrarcomponent v-if="mostar === 'profesors/mostrar'"></pmostrarcomponent>
         <peditarcomponent v-if="mostar === 'profesors/editar'"></peditarcomponent>
         <pborrarcomponent v-if="mostar === 'profesors/eliminar'"></pborrarcomponent>
         <emostrarcomponent v-if="mostar === 'estudiantes/mostrar'"></emostrarcomponent>
         <eeditarcomponent v-if="mostar === 'estudiantes/editar'"></eeditarcomponent>
         <eborrarcomponent v-if="mostar === 'estudiantes/eliminar'"></eborrarcomponent>
         <cursocomponent v-if="mostar === 'curso'"></cursocomponent>
         <horariocomponent v-if="mostar === 'horario'"></horariocomponent>
      </div>
   </v-layout>
</template>

<script>
export default {
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
   props: ["name"]
};
</script>

<style scoped lang="css">
.full {
   width: 100%;
}
</style>
