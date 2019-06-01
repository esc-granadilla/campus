<template>
   <v-flex>
      <combostudents
         :students="students"
         :dialogOpens="dialogOpen"
         v-on:speak="selectMethod($event)"
      ></combostudents>
   </v-flex>
</template>

<script>
import combostudents from "../../Asignaciones/Modals/ComboStudents.vue";
export default {
   components: {
      combostudents
   },
   data() {
      return {
         students: [],
         dialogOpen: false,
         notas: [],
         student: null
      };
   },
   methods: {
      selectMethod: function(msj) {
         if (msj.Selected) {
            this.student = msj.Student;
         } else this.$router.push("screenteacher");
      }
   },
   mounted() {
      let self = this;
      axios.get("/studentsforcourse").then(function(res) {
         self.students = res.data;
         self.dialogOpen = true;
      });
   }
};
</script>
