<template>
   <v-flex>
      <v-layout v-show="indeterminate">
         <v-spacer></v-spacer>
         <v-progress-circular :size="70" :width="7" color="primary" indeterminate></v-progress-circular>
         <v-spacer></v-spacer>
      </v-layout>
      <v-layout v-show="!indeterminate" wrap row>
         <v-flex id="table" xs12></v-flex>
         <v-layout xs12>
            <v-spacer></v-spacer>
            <v-btn dark color="primary" outline @click="exportAll">Exportar Informe</v-btn>
            <v-spacer></v-spacer>
         </v-layout>
      </v-layout>
   </v-flex>
</template>

<script>
export default {
   data() {
      return {
         indeterminate: true,
         qualification: null
      };
   },
   props: ["data"],
   methods: {
      exportAll() {
         location.href = "/mystudentsexport/" + this.data;
      },
      getthead() {
         return `<table>
                     <thead>
                        <tr>
                           <th>Rubros</th>
                           <th>Descripción</th>
                           <th>Valor</th>
                           <th>Obtenido</th>
                           <th>Total</th>
                        </tr>
                     </thead>`;
      },
      gettbody() {
         let examenes = this.qualification.examenes;
         let tareas = this.qualification.tareas;
         let trabajos = this.qualification.trabajos;
         let otros = this.qualification.otros;
         let total = 0.0;
         let table = `<tbody>`;
         let enota = 0.0;
         let enotatable = "";
         examenes.forEach(exa => {
            enotatable += `<tr><td>${exa.titulo}</td><td>${
               exa.descripcion == null ? "" : exa.descripcion
            }</td><td>${exa.valor_porcentual}%</td><td>${
               exa.porcentaje_obtenido
            }%</td><td></td></tr>`;
            enota += parseFloat(exa.porcentaje_obtenido);
         });
         if (examenes.length > 0)
            table +=
               `<tr><td>Exámenes</td><td></td><td></td><td></td><td>${enota}%</td></tr>` +
               enotatable;
         total += enota;
         let etarea = 0.0;
         let etareatable = "";
         tareas.forEach(ta => {
            etareatable += `<tr><td>${ta.titulo}</td><td>${
               ta.descripcion == null ? "" : ta.descripcion
            }</td><td>${ta.valor_porcentual}%</td><td>${
               ta.porcentaje_obtenido
            }%</td><td></td></tr>`;
            etarea += parseFloat(ta.porcentaje_obtenido);
         });
         if (tareas.length > 0)
            table +=
               `<tr><td>Tareas</td><td></td><td></td><td></td><td>${etarea}%</td></tr>` +
               etareatable;
         total += etarea;
         let etrabajo = 0.0;
         let etrabajotable = "";
         trabajos.forEach(tra => {
            etrabajotable += `<tr><td>${tra.titulo}</td><td>${
               tra.descripcion == null ? "" : tra.descripcion
            }</td><td>${tra.valor_porcentual}%</td><td>${
               tra.porcentaje_obtenido
            }%</td><td></td></tr>`;
            etrabajo += parseFloat(tra.porcentaje_obtenido);
         });
         if (trabajos.length > 0)
            table +=
               `<tr><td>Trabajos</td><td></td><td></td><td></td><td>${etrabajo}%</td></tr>` +
               etrabajotable;
         total += etrabajo;
         let eotros = 0.0;
         let eotrostable = "";
         otros.forEach(otro => {
            eotrostable += `<tr><td>${otro.titulo}</td><td>${
               otro.descripcion == null ? "" : otro.descripcion
            }</td><td>${otro.valor_porcentual}%</td><td>${
               otro.porcentaje_obtenido
            }%</td><td></td></tr>`;
            eotros += parseFloat(otro.porcentaje_obtenido);
         });
         if (otros.length > 0)
            table +=
               `<tr><td>Otros</td><td></td><td></td><td></td><td>${eotros}%</td></tr>` +
               eotrostable;
         total += eotros;
         table += `<tr><td></td><td></td><td></td><td>Nota</td><td>${total}%</td></tr></tbody><table/>`;
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
      axios
         .get("/myqualificationsfortrimester/" + this.data)
         .then(function(res) {
            self.qualification = res.data;
            self.indeterminate = false;
            self.drawtable();
         });
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
      content: "Rubro";
   }
   table tbody tr td:nth-child(2):before {
      content: "Descripción";
   }
   table tbody tr td:nth-child(3):before {
      content: "Valor";
   }
   table tbody tr td:nth-child(4):before {
      content: "Obtenido";
   }
   table tbody tr td:nth-child(5):before {
      content: "Total";
   }
}

blockquote {
   color: rgb(1, 11, 24);
   text-align: center;
}
</style>
