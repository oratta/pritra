<template>
    <v-app>
        <v-app-bar color="primary" dark app clippedLeft>
            <v-toolbar-title to="/">Pritra</v-toolbar-title>
            <v-btn text to="/training/plan">Training</v-btn>
            <v-btn text to="/training/log">Log</v-btn>
            <v-spacer></v-spacer>
            <v-toolbar-items v-if="isLogin">
                <v-btn text to="/profile">{{userName}}</v-btn>
                <v-btn text @click="logout">logout</v-btn>
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
    import {mapState} from 'vuex';

    export default {
        data(){
            return{
            }
        },
        computed: {
            isLogin() {
                return this.$store.getters['auth/check'];
            },
            userName(){
                return this.$store.getters['auth/username'];
            },
            ...mapState({
               apiStatus: state => state.auth.apiStatus,
            }),
        },
        methods: {
            async logout(){
                await this.$store.dispatch('auth/logout');

                if (this.apiStatus) {
                    this.$router.push('/login');
                }
            }
        }
    };
</script>
