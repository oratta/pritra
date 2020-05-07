<template>
    <v-container class="run">
        <h1>Run</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="menuCard in menuCardInfo"
                   :key="menuCard.menuId"
            >
                <MenuCardRun
                        :menu-name="menuCard.menuName"
                        :step-name="menuCard.stepName"
                ></MenuCardRun>
            </v-col>
        </v-row>
        </v-container>
</template>

<script>
import MenuCardRun from '../components/MenuCardRun.vue'
export default {
    components: {
        MenuCardRun,
    },
    data(){
        return {
            menuCard: {
                'menuName': 'Push Up',
                'stepName': 'Full Push Up'
            },
            menuCardInfo: [
                {
                    'menuName': 'Push Up',
                    'stepName': 'Full Push Up'
                },
                {
                    'menuName': 'Pull Up',
                    'stepName': 'Half Pull Up'
                },
            ],
        }
    },
    methods:{
    },
}
</script>