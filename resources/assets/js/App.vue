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
                <v-btn text to="/login">login/register</v-btn>
            </v-toolbar-items>
        </v-app-bar>
        <v-content>
            <router-view />
        </v-content>
    </v-app>
</template>

<script>
    import {mapState} from 'vuex';
    import { INTERNAL_SERVER_ERROR, UNAUTHORIZED, NOT_FOUND } from "./util";


    export default {
        data(){
            return{
            }
        },
        computed: {
            isLogin: function() {
                return this.$store.getters['auth/check'];
            },
            userName: function(){
                return this.$store.getters['auth/username'];
            },
            errorCode: function(){
                return this.$store.state.error.code
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
        },
        watch: {
            errorCode: {
                async handler (val) {
                    if (val === INTERNAL_SERVER_ERROR) {
                        this.$router.push('/500')
                    } else if (val === UNAUTHORIZED) {
                        // トークンをリフレッシュ
                        await axios.get('/api/refresh-token')
                        // ストアのuserをクリア
                        this.$store.commit('auth/setUser', null)
                        // ログイン画面へ
                        this.$router.push('/login')
                    } else if (val === NOT_FOUND){
                        this.$router.push('/not-found')
                    }
                },
                immediate: true
            },
            $route () {
                this.$store.commit('error/setCode', null)
                this.$store.commit('error/setMessage', null)
            }
        }
    };
</script>
