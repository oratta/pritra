<template>
    <v-app>
        <v-app-bar color="primary" dark app clippedLeft>
            <v-toolbar-title to="/">Pritra</v-toolbar-title>
            <v-btn text to="/training/plan">Training</v-btn>
            <v-btn text to="/training/log">Log</v-btn>
            <v-spacer></v-spacer>
            <v-toolbar-items v-if="isLogin">
                <div class="user_name">user name</div>
                <v-btn text to="/logout">logout</v-btn>
            </v-toolbar-items>
            <v-toolbar-items v-else>
                <v-btn text to="/login">login</v-btn>
                <v-btn text to="/register">register</v-btn>
            </v-toolbar-items>
        </v-app-bar>
        <v-content>
            <router-view />
        </v-content>
    </v-app>
</template>

<script>
    export default {
        data(){
            return{
                isLogin: false,
            }
        }
    };
</script>
