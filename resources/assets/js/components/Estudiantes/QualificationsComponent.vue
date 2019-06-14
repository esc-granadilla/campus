<template>
   <v-flex md8 xs12 offset-md2>
      <v-layout wrap row>
         <v-flex xs12 pt-2 px-3>
            <v-toolbar dark color="green" class="py-1">
               <v-spacer></v-spacer>
               <v-toolbar-title>Listado de Calificaciones</v-toolbar-title>
               <v-spacer></v-spacer>
            </v-toolbar>
            <v-card>
               <v-card-title>
                  <v-spacer></v-spacer>Notas
                  <v-spacer></v-spacer>
                  <v-text-field
                     v-model="search"
                     append-icon="search"
                     label="Buscar por Titulo"
                     single-line
                     hide-details
                  ></v-text-field>
               </v-card-title>
               <v-data-table
                  :headers="headers"
                  :items="notas"
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
                     <td
                        class="text-xs-left"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >{{ props.item.titulo }}</td>
                     <td
                        class="text-xs-center"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >Realizada: {{ props.item.fecha }} - Trimestre {{ props.item.trimestre }}</td>
                     <td
                        class="text-xs-center"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >Valor: {{ props.item.valor_porcentual }} - Obtenido: {{ props.item.porcentaje_obtenido }}</td>
                     <td
                        class="text-xs-center"
                        :style="{backgroundColor: (props.index % 2 == 0) ?'#c8e6c9' : 'white'}"
                     >{{ props.item.nota }}</td>
                  </template>
                  <v-alert
                     v-slot:no-results
                     :value="true"
                     color="error"
                     icon="warning"
                  >Tu busqueda por "{{ search }}" no encontro resultados.</v-alert>
               </v-data-table>
            </v-card>
         </v-flex>
      </v-layout>
   </v-flex>
</template>

<script>
export default {
   data() {
      return {
         search: "",
         notas: [],
         nota: {
            id: null
         },
         headers: [
            {
               text: "Titulo:",
               align: "left",
               sortable: false,
               value: "titulo"
            },
            { text: "Fecha:", align: "center", value: "fecha" },
            {
               text: "Porcentajes:",
               align: "center",
               value: "valor_porcentual"
            },
            { text: "Nota:", align: "center", value: "nota" }
         ]
      };
   },
   methods: {
      buscar(id) {
         this.nota = this.notas.find(function(c) {
            return c.id == id;
         });
      }
   },
   mounted() {
      var self = this;
      axios.get("/myqualifications").then(function(res) {
         let qualifications = res.data;
         qualifications.forEach(qualification => {
            let x =
               (100 / qualification.valor_porcentual) *
               qualification.porcentaje_obtenido;
            qualification.nota = x.toFixed(2);
         });
         self.notas = qualifications;
         self.nota = null;
      });
   }
};
</script>
