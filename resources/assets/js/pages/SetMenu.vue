<template>
    <v-container class="set-menu">
        <h1>Set Menu</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="menuCard in menuCardInfo"
                   :key="menuCard.id"
            >
                <MenuCard
                    v-on:set-menu="setMenu(menuCard.menuId, $event)"
                    :is-add="addFlags[menuCard.menuId]"
                    :menu="menuCard"
                ></MenuCard>
            </v-col>
        </v-row>
        <div class="margin_for_cart" v-show="isShowCart">
        </div>
        <div class="cart" v-show="isShowCart">
            <div class="mini_menu_card" v-for="miniCard in miniCardInfo">
                <v-card>
                    <v-card-title>{{miniCard.name}}</v-card-title>
                    <v-card-text>{{miniCard.step.name}}</v-card-text>
                    <v-card-text>{{miniCard.rep}}×{{miniCard.set}}</v-card-text>
                    <div class="remove_btn">
                        <v-btn small @click="removeMenu(miniCard.menuId)">Remove</v-btn>
                    </div>
                </v-card>
            </div>
            <div class="training_start_btn">
                <v-btn color="primary" @click="send">Start</v-btn>
            </div>
        </div>
    </v-container>
</template>

<script>
import MenuCard from '../components/MenuCard.vue'
import { OK } from '../util'

export default {
    components: {
        MenuCard
    },
    data(){
        return {
            isShowCart: false,
            miniCardInfo: {},
            menuCardInfo: [
                {
                    "id":1,
                    "name":"PushUp",
                    "step_l":
                        [
                            {
                                name: 'Half Push Up',
                                id: 1,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                            {
                                name: 'Full Push Up',
                                id: 2,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                            {
                                name: 'One Hand Push Up',
                                id: 3,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                        ],
                },
                {"id":2, "name":"Squat", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"id":3, "name":"PullUp", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"id":4, "name":"LegRaise", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"id":5, "name":"Bridge", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"id":6, "name":"OneHandPushUp", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
            ],
            addFlags: {
                1:false,
                2:false,
                3:false,
                4:false,
                5:false,
                6:false,
            }
        }
    },
    methods:{
        async fetchMenuInfo_l () {
            const response = await axios.get("/api/menu");
            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }
            this.menuCardInfo = response.data.data;
        },

        setMenu: function(menuId, selectedWorkoutSet){
            this.isShowCart = true;
            this.addFlags[menuId] = true;
            this.addMiniCard(menuId, selectedWorkoutSet);
        },
        removeMenu: function(menuId){
            this.addFlags[menuId] = false;
            delete this.miniCardInfo[menuId];
            if(Object.keys(this.miniCardInfo).length <=0){
                this.isShowCart = false;
            }
        },
        addMiniCard: function(menuId, selectedWorkoutSet){
            this.miniCardInfo[menuId]=selectedWorkoutSet;
            this.miniCardInfo[menuId]['menuId'] = menuId;
            this.miniCardInfo[menuId]['name'] = this.menuCardInfo[menuId-1].name;
        },
        init: function(){

        },
        async send(){
            const formData = new FormData();
            formData.append('selectedWorkoutSets', this.miniCardInfo);
            console.log('send request');
            const response = await axios.post('/api/plan', formData);
            console.log('get response');
            console.log(response);
            //TODO エラー処理

            this.$router.push('run');
        },
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchMenuInfo_l()
            },
            immediate: true
        }
    },
}
</script>