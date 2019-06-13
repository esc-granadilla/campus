<template>
   <v-flex>
      <combostudents
         :students="studentstock"
         :dialogOpens="dialogOpen"
         v-on:speak="selectMethod($event)"
      ></combostudents>
      <v-layout v-show="indeterminate">
         <v-spacer></v-spacer>
         <v-progress-circular :size="70" :width="7" color="primary" indeterminate></v-progress-circular>
         <v-spacer></v-spacer>
      </v-layout>
      <v-layout v-show="!indeterminate" wrap row>
         <v-flex id="table" xs12></v-flex>
         <v-layout xs12>
            <v-spacer></v-spacer>
            <v-btn dark color="primary" outline @click="dialogOpen=true">Exportar Estudiante</v-btn>
            <v-btn dark color="primary" outline @click="exportAll">Exportar Informe</v-btn>
            <v-spacer></v-spacer>
         </v-layout>
      </v-layout>
   </v-flex>
</template>

<script>
import combostudents from "../Modals/ComboStudents.vue";
export default {
   components: {
      combostudents
   },
   data() {
      return {
         indeterminate: true,
         dialogOpen: false,
         studentstock: [],
         qualifications: []
      };
   },
   props: ["data"],
   methods: {
      exportAll() {
         location.href = "/qualificationsexport/" + this.data;
      },
      exportOne(id) {
         location.href = "/studentsexport/" + this.data + "/" + id;
      },
      selectMethod: function(msg) {
         this.dialogOpen = msg.dialogselect;
         if (msg.Selected) {
            this.exportOne(msg.Student.id);
         }
      },
      getthead() {
         let table = `<table><thead><tr>`;
         let quali = this.qualifications[0];
         let examenes = quali.examenes;
         let tareas = quali.tareas;
         let trabajos = quali.trabajos;
         let otros = quali.otros;
         table += `<th>Cedula</th><th>Nombre</th>`;
         examenes.forEach(exa => {
            table += `<th>${exa.titulo}</th>`;
         });
         tareas.forEach(ta => {
            table += `<th>${ta.titulo}</th>`;
         });
         trabajos.forEach(tra => {
            table += `<th>${tra.titulo}</th>`;
         });
         otros.forEach(otro => {
            table += `<th>${otro.titulo}</th>`;
         });
         table += `<th>Nota</th></tr></thead>`;
         return table;
      },
      gettbody() {
         let table = `<tbody>`;
         this.qualifications.forEach(quali => {
            let examenes = quali.examenes;
            let tareas = quali.tareas;
            let trabajos = quali.trabajos;
            let otros = quali.otros;
            let estudiante = quali.estudiante;
            let total = 0.0;
            table += `<tr><td>${estudiante.cedula}</td><td>${
               estudiante.nombre
            } ${estudiante.primer_apellido} ${
               estudiante.segundo_apellido
            }</td>`;
            examenes.forEach(exa => {
               table += `<td>${exa.porcentaje_obtenido}%</td>`;
               total += parseFloat(exa.porcentaje_obtenido);
            });
            tareas.forEach(ta => {
               table += `<td>${ta.porcentaje_obtenido}%</td>`;
               total += parseFloat(ta.porcentaje_obtenido);
            });
            trabajos.forEach(tra => {
               table += `<td>${tra.porcentaje_obtenido}%</td>`;
               total += parseFloat(tra.porcentaje_obtenido);
            });
            otros.forEach(otro => {
               table += `<td>${otro.porcentaje_obtenido}%</td>`;
               total += parseFloat(otro.porcentaje_obtenido);
            });
            table += `<td>${total}%</td></tr>`;
         });
         table += `</tbody><table/>`;
         return table;
      },
      drawtable() {
         let hoy = new Date();
         let table = this.getthead();
         table += this.gettbody();
         table += `
         <blockquote> Emitido el ${hoy.getDate()}-${hoy.getMonth() +
            1}-${hoy.getFullYear()} </blockquote>`;
         document.getElementById("table").innerHTML = table;
      }
   },
   mounted() {
      self = this;
      axios.get("/qualificationsfortrimester/" + this.data).then(function(res) {
         self.qualifications = res.data;
         self.indeterminate = false;
         self.drawtable();
      });
      axios
         .get("/studentsforcourse")
         .then(res => (this.studentstock = res.data));
   }
};
</script>

<style>
#table {
   width: 100%;
}
table {
   border-spacing: 1;
   border-collapse: collapse;
   background: white;
   border-radius: 6px;
   overflow: hidden;
   max-width: 800px;
   width: 100%;
   margin: 0 auto;
   position: relative;
}
table * {
   position: relative;
}
table td,
table th {
   padding-left: 8px;
}
table thead tr {
   height: 60px;
   background: #7ccbf8d5;
   font-size: 16px;
}
table tbody tr {
   height: 48px;
   border-bottom: 1px solid #e3f1d5;
}
table tbody tr:last-child {
   border: 0;
}
table td,
table th {
   text-align: left;
}
table td.l,
table th.l {
   text-align: right;
}
table td.c,
table th.c {
   text-align: center;
}
table td.r,
table th.r {
   text-align: center;
}

@media screen and (max-width: 35.5em) {
   table {
      display: block;
   }
   table > *,
   table tr,
   table td,
   table th {
      display: block;
   }
   table thead {
      display: none;
   }
   table tbody tr {
      height: auto;
      padding: 8px 0;
   }
   table tbody tr td {
      padding-left: 45%;
      margin-bottom: 12px;
   }
   table tbody tr td:last-child {
      margin-bottom: 0;
   }
   table tbody tr td:before {
      position: absolute;
      font-weight: 700;
      width: 40%;
      left: 10px;
      top: 0;
   }
   table tbody tr td:nth-child(1):before {
      content: "Cedula";
   }
   table tbody tr td:nth-child(2):before {
      content: "Nombre";
   }
   table tbody tr td:nth-child(3):before {
      content: "Rubros";
   }
}

blockquote {
   color: rgb(1, 11, 24);
   text-align: center;
}
</style>
