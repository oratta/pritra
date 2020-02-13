<template>
    <v-container class="set-menu">
        <h1>Set Menu</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                    v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                        v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                        v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
        </v-row>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                        v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                        v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard
                        v-on:set-menu="setMenu"
                ></MenuCard>
            </v-col>
        </v-row>
        <div class="cart" v-show="isShowCart">
            ここにカート用のフッターが表示されるよ
            <div class="mini_menu_card" v-for="miniCard in miniCardInfo">
                <v-card>
                    <v-card-title>PushUp</v-card-title>
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
            miniCardInfo: [1,2],
        }
    },
    methods:{
        setMenu: function(){
            this.isShowCart = !this.isShowCart;
            this.addMiniCard();
        },
        addMiniCard: function(){
            this.miniCardInfo.push(3);
        }
    }
}
</script>