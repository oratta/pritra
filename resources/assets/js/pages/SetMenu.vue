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
                    v-bind:is-add="addFlags[menuCard.menuId]"
                ></MenuCard>
            </v-col>
        </v-row>
        <div class="cart" v-show="isShowCart">
            ここにカート用のフッターが表示されるよ
            <div class="mini_menu_card" v-for="miniCard in miniCardInfo">
                <v-card>
                    <v-card-title>{{miniCard}}PushUp</v-card-title>
                    <v-card-text>Full Push Up</v-card-text>
                    <v-card-text>20×2</v-card-text>
                    <div class="remove_btn">
                        <v-btn small>Remove</v-btn>
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
            miniCardInfo: [],
            menuCardInfo: [
                {"menuId":1},
                {"menuId":2},
                {"menuId":3},
                {"menuId":4},
                {"menuId":5},
                {"menuId":6},
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
        addMiniCard: function(menuId){
            this.miniCardInfo.push(menuId);
        }
    }
}
</script>