<template>
   <v-container grid-list-md>
      <v-data-iterator
         :items="items"
         :rows-per-page-items="rowsPerPageItems"
         :pagination.sync="pagination"
         content-tag="v-layout"
         row
         wrap
      >
         <template v-slot:item="props">
            <v-flex xs12 sm6 md4 lg3>
               <v-card>
                  <v-card-title>
                     <h4>{{ props.item.name }}</h4>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-list dense>
                     <v-list-tile>
                        <v-list-tile-content>Grado:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{ props.item.calories }}</v-list-tile-content>
                     </v-list-tile>
                     <v-list-tile>
                        <v-list-tile-content>Dia:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{ props.item.fat }}</v-list-tile-content>
                     </v-list-tile>
                     <v-list-tile>
                        <v-list-tile-content>Horario:</v-list-tile-content>
                        <v-list-tile-content class="align-end">{{ props.item.carbs }}</v-list-tile-content>
                     </v-list-tile>
                     <v-list-tile>
                        <v-list-tile-content class="align-center">
                           <v-btn round dark color="primary" block>Seleccionar</v-btn>
                        </v-list-tile-content>
                     </v-list-tile>
                  </v-list>
               </v-card>
            </v-flex>
         </template>
      </v-data-iterator>
   </v-container>
</template>

<script>
export default {
   data: () => ({
      rowsPerPageItems: [4, 8, 12],
      pagination: {
         rowsPerPage: 4
      },
      items: [
         {
            name: "Ciencias",
            calories: 159,
            fat: 6.0,
            carbs: 24
         },
         {
            name: "Matematicas",
            calories: 237,
            fat: 9.0,
            carbs: 37
         },
         {
            name: "Español",
            calories: 262,
            fat: 16.0,
            carbs: 23
         },
         {
            name: "Ingles",
            calories: 305,
            fat: 3.7,
            carbs: 67
         },
         {
            name: "Estudios Sociales",
            calories: 356,
            fat: 16.0,
            carbs: 49
         },
         {
            name: "Jelly bean",
            calories: 375,
            fat: 0.0,
            carbs: 94
         },
         {
            name: "Lollipop",
            calories: 392,
            fat: 0.2,
            carbs: 98
         },
         {
            name: "Honeycomb",
            calories: 408,
            fat: 3.2,
            carbs: 87
         },
         {
            name: "Donut",
            calories: 452,
            fat: 25.0,
            carbs: 51
         },
         {
            name: "KitKat",
            calories: 518,
            fat: 26.0,
            carbs: 65
         }
      ]
   })
};
</script>