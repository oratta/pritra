<template>
    <v-container>
        <h1>Set Menu</h1>
        <v-row>
            <v-col>
                <MenuCard></MenuCard>
            </v-col>
            <v-col></v-col>
            <v-col></v-col>
        </v-row>
        <v-row>
            <v-col></v-col>
            <v-col></v-col>
            <v-col></v-col>
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