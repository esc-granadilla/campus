<template>
    <div class="padre">
        <div class="hijo-1">
            <div class="login-text">
                <h3>Iniciar Sesión
                    <p class="text-buety">Escuela de Granadilla Norte</p>
                </h3>
            </div>
            
            <div class="login-input">
                <div class="input-own">
                    <v-text-field v-model="form.username" label="Nombre de usuario"></v-text-field>
                </div>
            </div>
            <div class="login-input">
                <div class="input-own">
                    <v-text-field v-model="form.password" label="Contraseña"></v-text-field>
                </div>
            </div>
            <div class="buttons">
                <div class="content-button">
                    <v-btn color="teal" block outline dark round>
                        Ingresar
                    </v-btn>
                </div>
            </div>
            <div class="buttons">
                <div class="content-button">
                    <v-btn color="blue" block flat dark round>
                        Recuperar contraseña
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            form:{
                username: '',
                password: ''
            }
        }
    }
}
</script>

<style>
    .padre {
        align-items: center;
        display: flex;
        justify-content: center;
        margin: 0%;
        padding: 0%;
        height: 100%;
    }

    .hijo-1 {
        height: 500px;
        width: 600px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);

    }

    .hijo-1:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .login-text {
        color: black;
        display: flex;
        padding-top: 8%;
        justify-content: center;
    }

    .login-text h3 {
        font-weight: normal;
        letter-spacing: 1px;
        font-size: 20pt;
    }
    
    .login-input {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .input-own {
        width: 50%;
        margin: 10px;
    }
    .buttons {
        display: flex;
        justify-content: center;
    }
    .content-button {
        width: 50%;
    }
    .text-buety {
        display: block;
        font-size: 12pt;
    }
    
</style>
