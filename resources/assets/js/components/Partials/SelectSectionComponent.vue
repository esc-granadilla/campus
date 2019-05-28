<template>
   <v-layout row>
      <v-flex xs12>
         <div v-bar class="tm">
            <v-list subheader two-line>
               <v-subheader>Secciones</v-subheader>
               <v-list-tile @click.prevent="selectedSeccion(c)" v-for="c in sections" :key="c.id">
                  <v-list-tile-action>
                     <v-checkbox v-model="c.selected" @click.prevent="selectedSeccion(c)"></v-checkbox>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ c.seccion }}</v-list-tile-title>
                     <v-list-tile-sub-title>{{ c.grado }}</v-list-tile-sub-title>
                  </v-list-tile-content>
               </v-list-tile>
            </v-list>
         </div>
      </v-flex>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         sections: [],
         sectionstock: [],
         section: null,
         grados: [
            { value: 1, text: "Primero" },
            { value: 2, text: "Segundo" },
            { value: 3, text: "Tercero" },
            { value: 4, text: "Cuarto" },
            { value: 5, text: "Quinto" },
            { value: 6, text: "Sexto" }
         ]
      };
   },
   props: ["search"],
   methods: {
      selectedSeccion(section) {
         let noSelected = true;
         if (section != null && !section.selected) {
            if (this.section != null) this.section.selected = false;
            section.selected = true;
            this.section = section;
            noSelected = false;
         } else {
            if (this.section != null) this.section.selected = false;
            if (section != null) section.selected = false;
            this.section = null;
            this.sections = this.sectionstock;
         }
         this.$emit("speak", {
            noSelected: noSelected,
            section: this.section
         });
      }
   },
   watch: {
      search(val) {
         let sect = this.sections.find(function(seccion) {
            return seccion.seccion.toUpperCase() === val.toUpperCase();
         });
         if (sect != null) sect.selected = false;
         this.selectedSeccion(sect);
      }
   },
   mounted() {
      var self = this;
      axios.get("/sections").then(function(res) {
         var sect = res.data;
         var sections = [];
         for (let index = 0; index < sect.length; index++) {
            sect[index].selected = false;
            sect[index].grado = self.grados.find(function(g) {
               return g.value == sect[index].grade_id;
            }).text;
            sections[index] = sect[index];
         }
         self.sections = self.sectionstock = sections;
      });
   }
};
</script>

<style scoped>
.tm {
   height: 400px;
}
</style>