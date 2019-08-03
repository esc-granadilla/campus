<template>
   <v-form ref="form">
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="nota.titulo"
               :rules="[rules.required, rules.between]"
               counter
               label="*Titulo"
               name="titulo"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="nota.valor_porcentual"
               :rules="[rules.required]"
               label="*Valor Porcentual"
               name="valor_porcentual"
               suffix="%"
               :mask="mask"
               :return-masked-value="true"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="nota.porcentaje_obtenido"
               :rules="[rules.required]"
               label="*Porcentaje Obtenido"
               name="porcentaje_obtenido"
               suffix="%"
               :mask="mask"
               :return-masked-value="true"
               required
            ></v-text-field>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-text-field
               xs12
               v-model="nota.descripcion"
               counter
               label="Descripción"
               name="descripcion"
            ></v-text-field>
         </v-flex>
      </v-layout>
      <v-layout wrap mx-5 xs6>
         <v-flex xs6 pt-2 px-3>
            <v-menu
               ref="menu"
               v-model="menu"
               :close-on-content-click="false"
               :nudge-right="40"
               :return-value.sync="nota.fecha"
               lazy
               transition="scale-transition"
               offset-y
               full-width
               min-width="290px"
            >
               <template v-slot:activator="{ on }">
                  <v-text-field
                     v-model="nota.fecha"
                     label="*Fecha"
                     prepend-icon="event"
                     readonly
                     v-on="on"
                  ></v-text-field>
               </template>
               <v-date-picker v-model="nota.fecha" no-title scrollable>
                  <v-spacer></v-spacer>
                  <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                  <v-btn flat color="primary" @click="$refs.menu.save(nota.fecha)">OK</v-btn>
               </v-date-picker>
            </v-menu>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="tipos"
               :rules="[rules.required]"
               item-text="text"
               item-value="value"
               :menu-props="{returnValue:'value'}"
               v-model="nota.tipo"
               label="*Tipo"
               d-block
            ></v-select>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="condiciones"
               :rules="[rules.required]"
               item-text="text"
               item-value="value"
               :menu-props="{returnValue:'value'}"
               v-model="nota.condicion"
               label="*Condición"
               d-block
            ></v-select>
         </v-flex>
         <v-flex xs6 pt-2 px-3>
            <v-select
               :items="trimestres"
               :rules="[rules.required]"
               item-text="text"
               item-value="value"
               :menu-props="{returnValue:'value'}"
               v-model="nota.trimestre"
               label="*Trimestre"
               d-block
            ></v-select>
         </v-flex>
      </v-layout>
   </v-form>
</template>

<script>
export default {
   name: "nota_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         menu: false,
         rules: {
            required: value => !!value || "Requerido.",
            between: v =>
               (!!v && (v.length >= 3 && v.length < 51)) ||
               "Entre 3 y 50 Caracteres"
         },
         mask: "##.##",
         trimestres: [
            { text: "Primer Trimestre", value: 1 },
            { text: "Segundo Trimestre", value: 2 },
            { text: "Tercer Trimestre", value: 3 }
         ],
         condiciones: [
            { text: "Aprobada", value: "Aprobada" },
            { text: "Reprobada", value: "Reprobada" },
            { text: "Realisada", value: "Realisada" },
            { text: "No realisada", value: "No realisada" }
         ],
         tipos: [
            { text: "Examen", value: "Examen" },
            { text: "Tarea", value: "Tarea" },
            {
               text: "Trabajo o investigación",
               value: "Trabajo o investigación"
            },
            { text: "Otra", value: "Otra" }
         ],
         nota: {
            id: null,
            titulo: "",
            valor_porcentual: "",
            porcentaje_obtenido: "",
            tipo: "",
            condicion: "",
            descripcion: "",
            trimestre: "",
            fecha: new Date().toISOString().substr(0, 10),
            student_id: null,
            course_id: null,
            estado: 1
         }
      };
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.nota));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.nota.id = val.id;
            this.nota.titulo = val.titulo;
            this.nota.valor_porcentual = val.valor_porcentual;
            this.nota.porcentaje_obtenido = val.porcentaje_obtenido;
            this.nota.tipo = val.tipo;
            this.nota.condicion = val.condicion;
            this.nota.descripcion = val.descripcion;
            this.nota.trimestre = val.trimestre;
            this.nota.fecha = val.fecha;
            this.nota.student_id = val.student_id;
            this.nota.course_id = val.course_id;
            this.nota.estado = val.estado;
         }
      },
      restaurar(val) {
         if (val) this.$refs.form.reset();
      }
   }
};
</script>

<style scoped>
</style>