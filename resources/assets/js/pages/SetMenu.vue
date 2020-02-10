<template>
    <v-container>
        <h1>Set Menu</h1>
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
    </v-container>
</template>

<script>
import MenuCard from '../components/MenuCard.vue'
export default {
    components: {
        MenuCard
    }
}
</script>