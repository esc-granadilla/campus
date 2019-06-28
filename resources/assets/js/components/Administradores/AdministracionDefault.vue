<template>
   <v-layout row justify-center wrap pt-5 style="position: absolute;">
      <v-flex class="text-xs-center" xs2>
         <v-progress-circular
            :rotate="360"
            :size="100"
            :width="15"
            :value="100"
            color="teal"
         >{{ estadisticas.Profesores }}</v-progress-circular>
         <blockquote class="headline">Profesores</blockquote>
      </v-flex>
      <v-flex class="text-xs-center" xs2>
         <v-progress-circular
            :rotate="-90"
            :size="100"
            :width="15"
            :value="100"
            color="primary"
         >{{ estadisticas.Alumnos }}</v-progress-circular>
         <blockquote class="headline">Alumnos</blockquote>
      </v-flex>
      <v-flex class="text-xs-center" xs2>
         <v-progress-circular
            :rotate="90"
            :size="100"
            :width="15"
            :value="100"
            color="warning"
         >{{ estadisticas.Secciones }}</v-progress-circular>
         <blockquote class="headline">Secciones</blockquote>
      </v-flex>
      <v-flex class="text-xs-center" xs2>
         <v-progress-circular
            :rotate="90"
            :size="100"
            :width="15"
            :value="100"
            color="red"
         >{{ estadisticas.Cursos }}</v-progress-circular>
         <blockquote class="headline">Cursos</blockquote>
      </v-flex>
      <v-flex class="text-xs-center" xs4 px-5>
         <v-layout>
            <v-btn block outline color="green darken-2" style="height: 60px; margin: 0;">Cambiar</v-btn>
            <v-flex xs6>
               <v-select :items="[1,2,3]" label="Trimestres" outline></v-select>
            </v-flex>
         </v-layout>
         <v-btn block outline color="red darken-2">Restaurar Año Lectivo</v-btn>
      </v-flex>
      <v-flex xs6 pt-5 px-4>
         <v-card>
            <v-card-title>
               Estudiantes por Sección
               <v-spacer></v-spacer>
               <v-text-field
                  v-model="search"
                  append-icon="search"
                  label="Buscar por sección"
                  single-line
                  hide-details
               ></v-text-field>
            </v-card-title>
            <v-data-table
               :headers="headers"
               :items="estadisticas.ListaEstudiantes"
               :search="search"
               rowsPerPageText="Elementos por página:"
               rowsPerPageAll="Todos"
               pageText="{0}-{1} de {2}"
               noResultsText="Ningún resultado a mostrar"
               nextPage="Página siguiente"
               prevPage="Página anterior"
               noDataText="Ningún dato disponible"
            >
               <template v-slot:items="props">
                  <td>{{ props.item.section.seccion }}</td>
                  <td class="text-xs-center">{{ props.item.cedula }}</td>
                  <td
                     class="text-xs-center"
                  >{{ props.item.nombre }} {{ props.item.primer_apellido }} {{ props.item.segundo_apellido }}</td>
               </template>
               <template v-slot:no-results>
                  <v-alert
                     :value="true"
                     color="error"
                     icon="warning"
                  >Tu busqueda por "{{ search }}" no tiene resultados.</v-alert>
               </template>
            </v-data-table>
         </v-card>
      </v-flex>
      <v-flex xs6 pt-5 px-4>
         <v-card>
            <v-card-title>
               Lista de Noticias
               <v-spacer></v-spacer>
               <v-text-field
                  v-model="searchn"
                  append-icon="search"
                  label="Buscar por Titulo"
                  single-line
                  hide-details
               ></v-text-field>
            </v-card-title>
            <v-data-table
               :headers="headersn"
               :items="estadisticas.ListaNoticias"
               :search="searchn"
               rowsPerPageText="Elementos por página:"
               rowsPerPageAll="Todos"
               pageText="{0}-{1} de {2}"
               noResultsText="Ningún resultado a mostrar"
               nextPage="Página siguiente"
               prevPage="Página anterior"
               noDataText="Ningún dato disponible"
            >
               <template v-slot:items="props">
                  <td>{{ props.item.titulo }}</td>
                  <td class="text-xs-center">{{ props.item.descripcion }}</td>
                  <td class="text-xs-center">{{ props.item.fecha }}</td>
               </template>
               <template v-slot:no-results>
                  <v-alert
                     :value="true"
                     color="error"
                     icon="warning"
                  >Tu busqueda por "{{ searchn }}" no tiene resultados.</v-alert>
               </template>
            </v-data-table>
         </v-card>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         estadisticas: {
            Alumnos: 0,
            Profesores: 0,
            Secciones: 0,
            Cursos: 0,
            ListaEstudiantes: [],
            ListaNoticias: []
         },
         search: "",
         headers: [
            {
               text: "Sección",
               align: "left",
               sortable: false,
               value: "section.seccion"
            },
            { text: "Cedula", value: "cedula" },
            { text: "Nombre", value: "nombre" }
         ],
         searchn: "",
         headersn: [
            {
               text: "Titulo",
               align: "left",
               sortable: false,
               value: "titulo"
            },
            { text: "Descripcion", value: "descripcion" },
            { text: "Fecha", value: "fecha" }
         ]
      };
   },
   methods: {},
   mounted() {
      axios.get("/statistics").then(res => (this.estadisticas = res.data));
   }
};
</script>
