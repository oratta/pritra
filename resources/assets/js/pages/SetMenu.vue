<template>
    <v-container class="set-menu">
        <h1>Set Menu</h1>
        <div v-if="isLoading">now loading...</div>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="menuCard in menuCardInfo"
                   :key="menuCard.id"
            >
                <MenuCard
                    v-on:set-menu="setMenu(menuCard.id, $event)"
                    :is-add="addFlags[menuCard.id]"
                    :menu="menuCard"
                ></MenuCard>
            </v-col>
        </v-row>
        <div class="margin_for_cart" v-show="isShowCart">
        </div>
        <div class="cart" v-show="isShowCart">
            <div class="mini_menu_card" v-for="(miniCard, menuId) in miniCardInfo">
                <v-card>
                    <v-card-title>{{miniCard.menuName}}</v-card-title>
                    <v-card-text>{{miniCard.step.name}}</v-card-text>
                    <v-card-text>{{miniCard.reps}}×{{miniCard.set}}</v-card-text>
                    <div class="remove_btn">
                        <v-btn small @click="removeMenu(menuId)">Remove</v-btn>
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
import {BAD_REQUEST, OK} from '../util'

export default {
    components: {
        MenuCard
    },
    computed: {
        SYSTEM_CODE_GO_TO_RUN_PAGE: () => "systemCode:1"
    },
    data(){
        return {
            isLoading: false,
            isShowCart: false,
            miniCardInfo: {},
            menuCardInfo: [
                // {"id":2, "name":"Squat", "step_l": [{name:'FirstStep',id: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', id: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',id: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
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
            this.isLoading = true;
            const response = await axios.get("/api/menu");
            this.isLoading = false;
            if(response.status == BAD_REQUEST && response.data.message == this.SYSTEM_CODE_GO_TO_RUN_PAGE){
                this.$router.push('run');
                return true;
            }

            if (response.status !== OK) {
                this.$store.commit('error/setCode', response.status);
                return false;
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
            this.miniCardInfo[menuId].menuName = this.menuCardInfo[menuId].name
        },
        init: function(){

        },
        async send(){
            console.log('send request');
            const response = await axios.post('/api/plan', {'planInfo': this.miniCardInfo});
            if(response.status == 201){
                this.$router.push('run');
            }
            else {
                console.log('get response error');
                console.log(response);
            }
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