<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer" clipped>
            <NavigationMenu/>
        </v-navigation-drawer>
        <v-app-bar color="primary" dark app clippedLeft>
            <v-app-bar-nav-icon @click="drawer=!drawer"></v-app-bar-nav-icon>
            <v-toolbar-title to="/">LifeBoard</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn text to="/enterprise">For Enterprise</v-btn>
                <v-menu offset-y>
                    <template v-slot:activator="{on}">
                        <v-btn v-on="on" text>Support<v-icon>mdi-menu-down</v-icon></v-btn>
                    </template>
                    <v-list>
                        <v-subheader>Get help</v-subheader>
                        <v-list-item v-for="support in supports" :key="support.name"  :to="support.link">
                            <v-list-item-icon>
                                <v-icon>{{ support.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>{{ support.name }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-app-bar>
        <v-content>
            <router-view />
        </v-content>
        <v-footer color="primary" dark app>
            Vuetify
        </v-footer>
    </v-app>
</template>

<script>
    import NavigationMenu from './components/layout/NavigationMenu.vue'

    export default {
        components: {
            NavigationMenu
        },
        data(){
            return{
                drawer: null,
                supports:[
                    {
                        name: 'Consulting and suppourt',
                        icon: 'mdi-vuetify',
                        link:'/consulting-and-support'
                    },
                    {
                        name: 'Discord community',
                        icon: 'mdi-discord',
                        link:'/discord-community'},
                    {
                        name: 'Report a bug',
                        icon: 'mdi-bug',
                        link:'/report-a-bug'
                    },
                    {
                        name: 'Github issue board',
                        icon: 'mdi-github-face',
                        link:'/guthub-issue-board'
                    },
                    {
                        name: 'Stack overview',
                        icon: 'mdi-stack-overflow',
                        link:'/stack-overview'
                    },
                ],
            }
        }
    };
</script>
