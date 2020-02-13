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
                <MenuCard></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard></MenuCard>
            </v-col>
        </v-row>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard></MenuCard>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <MenuCard></MenuCard>
            </v-col>
        </v-row>
        <div class="cart" v-show="isShowCart">
            ここにカート用のフッターが表示されるよ
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
        }
    },
    methods:{
        setMenu: function(){
            this.isShowCart = !this.isShowCart;
        }
    }
}
</script>