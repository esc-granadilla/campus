<template>
   <div>hola</div>
</template>

<script>
export default {
   props: ["data"],
   data: () => ({
      curso: [],
      estudiantes: []
   }),
   methods: {
      seleccionarCurso(id) {
         //alert(c_id + " " + g_id + " " + h_id + " " + d_id);
      },
      buscarCurso(event) {
         /* var self = this;
         if (window.event.keyCode == 13) {
            var cur = self.cursostock.find(function(curso) {
               return curso.nombre.toUpperCase() === self.search.toUpperCase();
            });
            if (cur != null)
               cur = {
                  id: cur.id,
                  nombre: cur.nombre,
                  codigo: cur.codigo,
                  descripcion: cur.descripcion,
                  selected: false
               };
            self.selectedCurso(cur);
         } */
      }
   },
   computed: {},
   watch: {},
   mounted() {
      this.curso = JSON.parse(this.data).curso;
      this.estudiantes = JSON.parse(this.data).estudiantes;
   }
};
</script>