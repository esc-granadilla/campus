<template>
   <v-form ref="form">
      <v-dialog
         ref="dialog"
         v-model="modal1"
         :return-value.sync="horario.desde"
         persistent
         lazy
         full-width
         width="290px"
      >
         <template v-slot:activator="{ on }">
            <v-text-field
               v-model="horario.desde"
               label="*Desde:"
               prepend-icon="access_time"
               readonly
               :rules="[rules.required]"
               v-on="on"
            ></v-text-field>
         </template>
         <v-time-picker v-if="modal1" v-model="horario.desde" full-width>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="modal1 = false">Cancel</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog.save(horario.desde)">OK</v-btn>
         </v-time-picker>
      </v-dialog>
      <v-dialog
         ref="dialog1"
         v-model="modal2"
         :return-value.sync="horario.hasta"
         persistent
         lazy
         full-width
         width="290px"
      >
         <template v-slot:activator="{ on }">
            <v-text-field
               v-model="horario.hasta"
               label="*Hasta"
               prepend-icon="access_time"
               readonly
               :rules="[rules.required, rules.mayor]"
               v-on="on"
            ></v-text-field>
         </template>
         <v-time-picker v-if="modal2" v-model="horario.hasta" full-width>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="modal2 = false">Cancel</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog1.save(horario.hasta)">OK</v-btn>
         </v-time-picker>
      </v-dialog>
   </v-form>
</template>

<script>
export default {
   name: "horario_component",
   props: ["validar", "restaurar", "datos"],
   data() {
      return {
         rules: {
            required: v => !!v || "Requerido.",
            mayor: v => v > this.horario.desde || "Esta hora debe ser mayor."
         },
         horario: {
            id: null,
            desde: null,
            hasta: null,
            estado: ""
         },
         modal2: false,
         modal1: false
      };
   },
   watch: {
      validar(val) {
         if (val) {
            if (this.$refs.form.validate()) {
               this.$emit("speak", Object.assign({}, this.horario));
               return;
            }
         }
         this.$emit("speak", null);
      },
      datos(val) {
         if (val != null) {
            this.horario.id = val.id;
            this.horario.desde = val.desde;
            this.horario.hasta = val.hasta;
            this.horario.estado = val.estado;
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
