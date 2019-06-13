<template>
   <v-layout row>
      <v-flex xs12>
         <div v-bar class="tm">
            <v-list subheader two-line>
               <v-subheader>Cursos</v-subheader>
               <v-list-tile @click.prevent="selectedSeccion(c)" v-for="c in courses" :key="c.id">
                  <v-list-tile-action>
                     <v-checkbox v-model="c.selected" @click.prevent="selectedSeccion(c)"></v-checkbox>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ c.nombre }}</v-list-tile-title>
                     <v-list-tile-sub-title>{{ c.profesor.nombre }} {{ c.profesor.primer_apellido }} {{ c.profesor.segundo_apellido }}</v-list-tile-sub-title>
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
         courses: [],
         coursesstock: [],
         course: null
      };
   },
   props: ["search"],
   methods: {
      selectedSeccion(course) {
         let noSelected = true;
         if (course != null && !course.selected) {
            if (this.course != null) this.course.selected = false;
            course.selected = true;
            this.course = course;
            noSelected = false;
         } else {
            if (this.course != null) this.course.selected = false;
            if (course != null) course.selected = false;
            this.course = null;
            this.courses = this.coursestock;
         }
         this.$emit("speak", {
            noSelected: noSelected,
            course: this.course
         });
      }
   },
   watch: {
      search(val) {
         let cousr = this.courses.find(function(course) {
            return course.nombre.toUpperCase() === val.toUpperCase();
         });
         if (cousr != null) cousr.selected = false;
         this.selectedSeccion(cousr);
      }
   },
   mounted() {
      var self = this;
      axios.get("/courses").then(function(res) {
         var cousr = res.data;
         var courses = [];
         for (let index = 0; index < cousr.length; index++) {
            cousr[index].selected = false;
            courses[index] = cousr[index];
         }
         self.courses = self.coursestock = courses;
      });
   }
};
</script>

<style scoped>
.tm {
   height: 400px;
}
</style>