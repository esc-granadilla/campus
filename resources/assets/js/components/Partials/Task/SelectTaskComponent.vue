<template>
   <v-layout row>
      <v-flex xs12>
         <div v-bar class="tm">
            <v-list subheader two-line>
               <v-subheader>Tareas</v-subheader>
               <v-list-tile @click.prevent="selectedTask(t)" v-for="t in tasks" :key="t.id">
                  <v-list-tile-action>
                     <v-checkbox v-model="t.selected" @click.prevent="selectedTask(t)"></v-checkbox>
                  </v-list-tile-action>

                  <v-list-tile-content>
                     <v-list-tile-title>{{ t.titulo }}</v-list-tile-title>
                     <v-list-tile-sub-title>{{ t.descripcion }}</v-list-tile-sub-title>
                     <v-list-tile-sub-title>Valor: {{ t.valor }}</v-list-tile-sub-title>
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
         tasks: [],
         taskstock: [],
         task: null
      };
   },
   props: ["search"],
   methods: {
      selectedTask(task) {
         let noSelected = true;
         if (task != null && !task.selected) {
            if (this.task != null) this.task.selected = false;
            task.selected = true;
            this.task = task;
            noSelected = false;
         } else {
            if (this.task != null) this.task.selected = false;
            if (task != null) task.selected = false;
            this.task = null;
            this.tasks = this.taskstock;
         }
         this.$emit("speak", {
            noSelected: noSelected,
            task: this.task
         });
      }
   },
   watch: {
      search(val) {
         let tasktemp = this.tasks.find(function(task) {
            return task.titulo.toUpperCase() === val.toUpperCase();
         });
         if (tasktemp != null) tasktemp.selected = false;
         this.selectedTask(tasktemp);
      }
   },
   mounted() {
      var self = this;
      axios.get("tasks/0").then(function(res) {
         var tasktemp = res.data;
         var tasks = [];
         for (let index = 0; index < tasktemp.length; index++) {
            tasktemp[index].selected = false;
            tasks[index] = tasktemp[index];
         }
         self.tasks = self.taskstock = tasks;
      });
   }
};
</script>

<style scoped>
.tm {
   height: 400px;
}
</style>