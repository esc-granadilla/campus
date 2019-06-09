<template>
   <v-layout row wrap class="tm">
      <v-flex xs12 px-4>
         <v-text-field
            single-line
            hide-details
            label="Nombre del rubro"
            v-model="taskhistory.nombre"
         ></v-text-field>
      </v-flex>

      <v-flex xs6 pl-4>
         <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :nudge-right="40"
            :return-value.sync="taskhistory.inicio"
            lazy
            transition="scale-transition"
            offset-y
            full-width
            min-width="290px"
         >
            <template v-slot:activator="{ on }">
               <v-text-field
                  v-model="taskhistory.inicio"
                  label="Fecha de Inicio"
                  prepend-icon="event"
                  readonly
                  v-on="on"
               ></v-text-field>
            </template>
            <v-date-picker v-model="taskhistory.inicio" no-title scrollable>
               <v-spacer></v-spacer>
               <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
               <v-btn flat color="primary" @click="$refs.menu.save(taskhistory.inicio)">OK</v-btn>
            </v-date-picker>
         </v-menu>
      </v-flex>
      <v-flex xs6 pr-4>
         <v-menu
            ref="menu2"
            v-model="menu2"
            :close-on-content-click="false"
            :nudge-right="40"
            :return-value.sync="taskhistory.final"
            lazy
            transition="scale-transition"
            offset-y
            full-width
            min-width="290px"
         >
            <template v-slot:activator="{ on }">
               <v-text-field
                  v-model="taskhistory.final"
                  label="Fecha de Fin"
                  prepend-icon="event"
                  readonly
                  v-on="on"
               ></v-text-field>
            </template>
            <v-date-picker v-model="taskhistory.final" no-title scrollable>
               <v-spacer></v-spacer>
               <v-btn flat color="primary" @click="menu2 = false">Cancel</v-btn>
               <v-btn flat color="primary" @click="$refs.menu2.save(taskhistory.final)">OK</v-btn>
            </v-date-picker>
         </v-menu>
      </v-flex>

      <v-flex xs12 px-4>
         <v-select
            :items="trimestres"
            item-text="text"
            item-value="value"
            :menu-props="{returnValue:'value'}"
            v-model="taskhistory.trimestre"
            label="*Trimestre"
            d-block
         ></v-select>
      </v-flex>
      <v-flex xs12 px-4 class="text-xs-right">
         <v-btn color="red darken-1" flat @click="eliminar" v-if="data != null">Eliminar</v-btn>
         <v-btn color="blue darken-1" flat @click="validar" v-if="data == null">Salvar</v-btn>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   props: ["data"],
   data() {
      return {
         taskhistory: {
            nombre: "",
            course_id: 0,
            task_id: 0,
            student_id: 0,
            inicio: "",
            final: "",
            trimestre: 0
         },
         menu: false,
         menu2: false,
         trimestres: [
            { text: "Primer Trimestre", value: 1 },
            { text: "Segundo Trimestre", value: 2 },
            { text: "Tercer Trimestre", value: 3 }
         ]
      };
   },
   methods: {
      validar() {
         if (
            this.taskhistory.nombre != "" &&
            this.taskhistory.trimestre != 0 &&
            this.taskhistory.inicio != "" &&
            this.taskhistory.final != ""
         ) {
            this.$emit("speak", { Data: this.taskhistory, Accion: "save" });
         } else {
            this.$toast.error("Ingrese todos los datos", {
               y: "top",
               timeout: 6000
            });
         }
      },
      eliminar() {
         this.$emit("speak", { Data: this.taskhistory, Accion: "delete" });
      }
   },
   watch: {
      data(val) {
         if (val != null) {
            this.taskhistory = val;
         } else {
            taskhistory = {
               nombre: "",
               course_id: 0,
               task_id: 0,
               student_id: 0,
               inicio: "",
               final: "",
               trimestre: 0
            };
         }
      }
   }
};
</script>

<style scoped>
.tm {
   height: 400px;
}
</style>

