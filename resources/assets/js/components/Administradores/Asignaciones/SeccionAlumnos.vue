<template>
   <v-layout justify-center wrap>
      <v-card class="mar2" absolute>
         <v-layout justify-center wrap>
            <v-flex md10 class="mar">
               <v-toolbar color="green" dark tabs>
                  <v-flex v-if="ocualtarTab">
                     <v-text-field
                        class="mx-3"
                        flat
                        label="Buscar Sección"
                        prepend-inner-icon="search"
                        solo-inverted
                        v-model="search"
                     ></v-text-field>
                  </v-flex>
                  <v-layout v-if="!ocualtarTab" xs12 justify-center align-center wrap>
                     <v-card-title class="title">Seleccione los Estudiantes de la sección</v-card-title>
                  </v-layout>
                  <template v-slot:extension>
                     <v-tabs
                        v-model="tabs"
                        centered
                        color="transparent"
                        slider-color="white"
                        change
                     >
                        <v-tab
                           v-for="a in accions"
                           :key="a.id"
                           :disabled="a.id==2 ? noSelected : false"
                        >{{ a.text }}</v-tab>
                     </v-tabs>
                  </template>
               </v-toolbar>

               <v-tabs-items v-model="tabs">
                  <v-tab-item :key="1">
                     <selectsectioncomponent
                        :search="search"
                        v-on:speak="SelectSectionMethod($event)"
                     ></selectsectioncomponent>
                  </v-tab-item>
                  <v-tab-item :key="2">
                     <selectstudentscomponent
                        :seleccionados="selected"
                        :sections="sections"
                        v-on:speak="SalvarMethod($event)"
                     ></selectstudentscomponent>
                  </v-tab-item>
               </v-tabs-items>
            </v-flex>
         </v-layout>
      </v-card>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         tabs: 0,
         search: "",
         noSelected: true,
         selected: [],
         mensaje: [],
         section: null,
         sections: [],
         students: [],
         accions: [
            {
               id: 1,
               text: "Sección"
            },
            {
               id: 2,
               text: "Alumnos"
            }
         ]
      };
   },
   methods: {
      SelectSectionMethod: function(msg) {
         this.noSelected = msg.noSelected;
         if (!this.noSelected) this.section = msg.section;
         else this.section = null;
      },
      SalvarMethod: function(msg) {
         axios
            .post("addstudentsforsection/" + this.section.id, {
               students: msg.Students
            })
            .then(res => (this.mensaje = res.data));
      }
   },
   computed: {
      ocualtarTab: function() {
         return this.tabs == 0;
      }
   },
   watch: {
      tabs(val) {
         if (val == 1) {
            this.selected = [];
            axios
               .get("/studentsforsection/" + this.section.id)
               .then(res => (this.selected = res.data));
            axios
               .get("/sections")
               .then(
                  res =>
                     (this.sections = res.data.filter(
                        s => s.id != this.section.id
                     ))
               );
         }
      },
      mensaje(val) {
         if (val.type === "success")
            this.$toast.success(val.message, {
               y: "top",
               timeout: 6000
            });
         else
            this.$toast.error(val.message, {
               y: "top",
               timeout: 6000
            });
      }
   },
   mounted() {}
};
</script>

<style scoped>
.mar {
   margin-top: -40px;
}
.mar2 {
   margin-top: 70px;
   width: 600px;
}
</style>