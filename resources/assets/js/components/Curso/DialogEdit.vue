
<template>
   <v-layout row justify-center>
      <v-dialog v-model="dialogedit" max-width="300px">
         <v-card>
            <v-card-title>
               <span class="headline">Editar Curso</span>
            </v-card-title>
            <v-card-text>
               <v-container grid-list-md>
                  <v-layout wrap>
                     <v-text-field
                        xs12
                        v-model="curso.codigo"
                        :rules="[rules.required, rules.mini]"
                        counter
                        label="*Codigo"
                        name="codigo"
                        required
                     ></v-text-field>

                     <v-text-field
                        xs12
                        v-model="curso.nombre"
                        :rules="[rules.required, rules.mini]"
                        counter
                        label="*Nombre"
                        name="nombre"
                        required
                     ></v-text-field>
                     <v-text-field
                        xs12
                        v-model="curso.descripcion"
                        :rules="[rules.mini]"
                        counter
                        label="Descripción"
                        name="descripcion"
                     ></v-text-field>
                  </v-layout>
               </v-container>
               <small>*Campos requeridos</small>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn
                  color="blue darken-1"
                  flat
                  @click="dialogedit = false, curso = cursostock,$emit('speak', {dialogedit:false,Edit:false,curso:curso})"
               >Cerrar</v-btn>
               <v-btn
                  color="blue darken-1"
                  flat
                  @click="dialogedit = false, $emit('speak', {dialogedit:false,Edit:true,curso:curso})"
               >Salvar</v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </v-layout>
</template>

<script>
export default {
   data() {
      return {
         dialogedit: false,
         rules: {
            required: value => !!value || "Requerido.",
            min: v => v.length >= 9 || "Min 9 Caracteres",
            min8: v => v.length >= 8 || "Min 8 Caracteres",
            max: v => v.length >= 50 || "Maximo 50 Caracteres",
            mini: v => v.length >= 3 || "Min 3 Caracteres"
         },
         curso: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         },
         cursostock: {
            id: null,
            codigo: "",
            nombre: "",
            descripcion: "",
            estado: ""
         }
      };
   },
   props: ["dialogEdits", "editCurso"],
   watch: {
      dialogEdits(val) {
         this.dialogedit = val;
      },
      editCurso(val) {
         this.curso.id = val.id;
         this.curso.codigo = val.codigo;
         this.curso.nombre = val.nombre;
         this.curso.descripcion = val.descripcion;
         this.curso.estado = val.estado;
      }
   }
};
</script>

<style scoped>
</style>
