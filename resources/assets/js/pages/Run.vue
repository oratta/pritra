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
        <div class="menu-card__form_training_set__submit">
            <v-card-actions>
            </v-card-actions>
            <div class="spacer"></div>
            <v-card-actions>
                <v-btn
                        color="accent"
                        size="small"
                        @click="finish"
                >
                    finish workout
                </v-btn>
            </v-card-actions>
        </div>
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
        async finish(){
            // const formData = new FormData();
            // formData.append('selectedWorkoutSets', this.miniCardInfo);
            // console.log('send request');
            // const response = await axios.post('/api/plan', formData);
            // console.log('get response');
            // console.log(response);
            // //TODO エラー処理

            this.$router.push('finish');
        }
    },
}
</script>