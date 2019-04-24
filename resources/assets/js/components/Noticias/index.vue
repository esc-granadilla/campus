<template>
    <v-layout row wrap> 
        <v-flex xs4 pa-2 v-for="(item,index) in noticias" :key="index">
            <v-card>
                <v-card-title primary-title>
                    {{item.title}}
                </v-card-title> 
                <v-card-text>
                    <p>{{item.description}}</p>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="primary">Eliminar</v-btn>
                    <v-btn flat color="secondary">Editar</v-btn>
                </v-card-actions>    
            </v-card>
        </v-flex>
    </v-layout>   
</template>
<script>
export default {
    data(){
        return{
            noticias : [
                {title: "Estudiantes de 5 grado", description: "lorem ipsum dolor"},
                {title: "Estudiantes de 5 grado", description: "lorem ipsum dolor"},
                {title: "Estudiantes de 5 grado", description: "lorem ipsum dolor"},
                {title: "Estudiantes de 5 grado", description: "lorem ipsum dolor"}
            ]
        }
    }
}
</script>
