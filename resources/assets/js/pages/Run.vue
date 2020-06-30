<template>
    <v-container class="run">
        <h1>Run</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="(planInfo, id) in planInfoList"
                   :key="id"
            >
                <MenuCardRun
                        :plan-info="planInfo"
                        :difficulty-list="difficultyList"
                        v-on:finish-workout="finishWorkout(id, $event)"
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
            planInfoList: [],
            executeList: {}
        }
    },
    methods:{
        async init() {
            await this.fetch();
            for (let id in this.planInfoList){
                this.executeList[id] = {};
            }
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
        finishWorkout: function(id, workout){
            this.executeList[id]['repCount'] = workout.repCount;
            this.executeList[id]['difficultyType'] = workout.difficultyType;
        },
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
    },
    watch: {
        $route: {
            async handler () {
                await this.init()
            },
            immediate: true
        }
    },
}
</script>