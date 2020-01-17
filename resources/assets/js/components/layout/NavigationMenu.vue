<template>
    <v-container>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title grey--text text--darken-2">
                    Navigation Lists
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-group
                    v-for="nav_list in nav_lists"
                    :key="nav_list.name"
                    :prepend-icon="nav_list.icon"
                    no-action
                    :append-icon="nav_list.lists ? undefined : ''">
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ nav_list.name }}
                        </v-list-item-title>
                    </v-list-item-content>
                </template>
                <v-list-item v-for="list in nav_list.lists" :key="list.name" :to="list.link">
                    <v-list-item-content>
                        <v-list-item-title>{{ list.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>





            <v-list-item v-for="nav_list in nav_lists" :key="'A'+ nav_list.name">
                <v-list-item-icon>
                    <v-icon>{{ nav_list.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{ nav_list.name }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

    </v-container>
</template>

<script>
export default {
    data(){
        return{
            nav_lists:[
                {
                    name: 'Getting Started',
                    icon: 'mdi-speedometer',
                    lists:[
                        {
                            name:'Quick Start',link:'/quick-start'
                        },
                        {
                            name:'Pre-made layout',link:'/pre-made-layout'
                        }
                    ]
                },
                {
                    name: 'Customization',
                    icon: 'mdi-cogs'
                },
                {
                    name: 'Styles & animations',
                    icon: 'mdi-palette',
                    lists:[{name:'Colors'},{name:'Content'},{name:'Display'}]
                },
                {
                    name: 'UI Components',
                    icon: 'mdi-view-dashboard',
                    lists:[{name:'API explorer'},{name:'Alerts'}]
                },
                {
                    name: 'Directives',
                    icon: 'mdi-function'
                },
                {
                    name: 'Preminum themes',
                    icon: 'mdi-vuetify'
                },
            ]
        }
    }
}
</script>