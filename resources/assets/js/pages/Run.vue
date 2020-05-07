<template>
    <v-container class="run">
        <h1>Run</h1>
        <MenuCardRun
                :menu-name="menuCard.menuName"
                :step-name="menuCard.stepName"
        ></MenuCardRun>
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
        }
    },
    methods:{
    },
}
</script>