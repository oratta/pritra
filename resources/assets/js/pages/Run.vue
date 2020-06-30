<template>
    <v-container class="run">
        <h1>Run</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="(planInfo, menuId) in planInfoList"
                   :key="menuId"
            >
                <MenuCardRun
                        :plan-info="planInfo"
                        :difficulty-list="difficultyList"
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
import {OK} from "../util";
export default {
    components: {
        MenuCardRun,
    },
    data(){
        return {
            planInfoList: []
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
        },
        async fetch() {
            this.isLoading = true;
            const response = await axios.get("/api/plan");
            this.isLoading = false;
            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.planInfoList = response.data.planList;
            this.difficultyList = response.data.difficultyList;
        },
    },
    watch: {
        $route: {
            async handler () {
                await this.fetch()
            },
            immediate: true
        }
    },
}
</script>