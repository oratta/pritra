<template>
    <v-container class="set-menu">
        <h1>Set Menu</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12"
                   v-for="menuCard in menuCardInfo"
                   :key="menuCard.menuId"
            >
                <MenuCard
                    v-on:set-menu="setMenu(menuCard.menuId)"
                    :is-add="addFlags[menuCard.menuId]"
                    :menu-name="menuCard.menuName"
                    :steps="menuCard.steps"
                ></MenuCard>
            </v-col>
        </v-row>
        <div class="margin_for_cart" v-show="isShowCart">
        </div>
        <div class="cart" v-show="isShowCart">
            <div class="mini_menu_card" v-for="miniCard in miniCardInfo">
                <v-card>
                    <v-card-title>{{miniCard}}PushUp</v-card-title>
                    <v-card-text>Full Push Up</v-card-text>
                    <v-card-text>20×2</v-card-text>
                    <div class="remove_btn">
                        <v-btn small @click="removeMenu(miniCard)">Remove</v-btn>
                    </div>
                </v-card>
            </div>
            <div class="training_start_btn">
                <v-btn color="primary">Start</v-btn>
            </div>
        </div>
    </v-container>
</template>

<script>
import MenuCard from '../components/MenuCard.vue'
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
                    "menuId":1,
                    "menuName":"PushUp",
                    "steps":
                        [
                            {
                                name: 'Half Push Up',
                                number: 1,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                            {
                                name: 'Full Push Up',
                                number: 2,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                            {
                                name: 'One Hand Push Up',
                                number: 3,
                                levels: [{levelNumber: 1, rep: 5, set: 1,}, {
                                    levelNumber: 2,
                                    rep: 10,
                                    set: 1,
                                }, {levelNumber: 3, rep: 10, set: 2,}]
                            },
                        ],
                },
                {"menuId":2, "menuName":"Squat", "steps": [{name:'FirstStep',number: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', number: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',number: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"menuId":3, "menuName":"PullUp", "steps": [{name:'FirstStep',number: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', number: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',number: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"menuId":4, "menuName":"LegRaise", "steps": [{name:'FirstStep',number: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', number: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',number: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"menuId":5, "menuName":"Bridge", "steps": [{name:'FirstStep',number: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', number: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',number: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
                {"menuId":6, "menuName":"OneHandPushUp", "steps": [{name:'FirstStep',number: 1,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2,rep: 10,set: 1,},{levelNumber: 3, rep: 10, set: 2,}]},{name: 'SecondStep', number: 2,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},{name: 'ThirdStep',number: 3,levels: [{levelNumber: 1, rep: 5, set: 1,}, {levelNumber: 2, rep: 10,set: 1,}, {levelNumber: 3, rep: 10, set: 2,}]},],},
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
        setMenu: function(menuId){
            this.isShowCart = true;
            this.addFlags[menuId] = true;
            this.addMiniCard(menuId);
        },
        removeMenu: function(menuId){
            this.addFlags[menuId] = false;
            delete this.miniCardInfo[menuId];
            if(Object.keys(this.miniCardInfo).length <=0){
                this.isShowCart = false;
            }
        },
        addMiniCard: function(menuId){
            this.miniCardInfo[menuId]=menuId;
        },
        init: function(){

        }
    },
}
</script>