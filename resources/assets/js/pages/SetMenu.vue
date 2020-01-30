<template>
    <v-container>
        <h1>Set Menu</h1>
        <v-row>
            <v-col cols="4">
                <v-card>
                    <v-card-subtitle>
                        Push Up
                    </v-card-subtitle>
                    <v-img
                            src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
                            width="100%"></v-img>
                    <v-card-title style="display:flex;align-items:center; justify-content:center;">
                        Full Pull Up
                    </v-card-title>
                    <v-row justify="center" align-content="center">
                        <v-col cols="5" style="display:flex;align-items:center; justify-content:center;">
                            <div style="height:60px; align-items:center; justify-content:center;">
                                <v-row style="height:30px;">
                                    <v-col style="padding-bottom:0;padding-top:0;margin-bottom:0;margin-top:auto">
                                        <div style="font-size:large">20</div>
                                    </v-col>
                                </v-row>
                                <v-row style="height:30px;">
                                    <v-col style="padding-bottom:0;padding-top:0;margin-top:0;margin-bottom:auto">
                                        <div style="text-align:center;">reps</div>
                                    </v-col>
                                </v-row>
                            </div>

                            <div style="height:60px; align-items:center; justify-content:center;">
                                <v-row style="height:30px;">
                                    <v-col style="padding-bottom:0;margin-bottom:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row style="height:30px;">
                                    <v-col style="padding-top:0;margin-top:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </div>
                        </v-col>
                        <v-col cols="1" style="padding:0;display:flex;align-items:center; justify-content:center;">
                            ×
                        </v-col>
                        <v-col cols="5" style="display:flex;align-items:center; justify-content:center;">
                            <v-card-text style="display:flex;justify-content:center;">
                                <div style="font-size:large">2</div>
                            </v-card-text>
                            <div class="adjust-button">
                                <v-row>
                                    <v-col style="padding-bottom:0;margin-bottom:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col style="padding-top:0;margin-top:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </div>
                            <v-card-text style="display:flex;justify-content:center;">
                                sets
                            </v-card-text>
                        </v-col>
                        <v-col cols="4">

                        </v-col>
                    </v-row>
                    <v-card-actions>
                        <v-btn>History</v-btn>
                        <v-btn>Set</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card>
                    <v-card-subtitle>
                        Push Up
                    </v-card-subtitle>
                    <v-img
                            src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
                            width="100%"></v-img>
                    <v-card-title style="display:flex;align-items:center; justify-content:center;">
                        Full Pull Up
                    </v-card-title>
                    <v-row justify="center" align-content="center">
                        <v-col cols="5" style="display:flex;align-items:center; justify-content:center;">
                            <v-card-text>
                                <div style="font-size:large">20</div>
                            </v-card-text>
                            <div>
                                <v-row>
                                    <v-col style="padding-bottom:0;margin-bottom:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col style="padding-top:0;margin-top:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </div>
                            <v-card-text style="display:flex;justify-content:center;">
                                reps
                            </v-card-text>
                        </v-col>
                        <v-col cols="1" style="padding:0;display:flex;align-items:center; justify-content:center;">
                            ×
                        </v-col>
                        <v-col cols="5" style="display:flex;align-items:center; justify-content:center;">
                            <v-card-text style="display:flex;justify-content:center;">
                                <div style="font-size:large">2</div>
                            </v-card-text>
                            <div class="adjust-button">
                                <v-row>
                                    <v-col style="padding-bottom:0;margin-bottom:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col style="padding-top:0;margin-top:0;">
                                        <v-btn icon x-small>
                                            <v-icon x-small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </div>
                            <v-card-text style="display:flex;justify-content:center;">
                                sets
                            </v-card-text>
                        </v-col>
                        <v-col cols="4">

                        </v-col>
                    </v-row>
                    <v-card-actions>
                        <v-btn>History</v-btn>
                        <v-btn>Set</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col
                    cols="4"
            >
                <v-row>
                    <v-col style="padding:1px;margin:1px;">
                        <v-btn icon x-small>
                            <v-icon x-small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col style="padding:1px;margin:1px;">
                        <v-btn icon x-small>
                            <v-icon x-small>mdi-arrow-down-bold</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                    cols="4"
            >
                <MenuCard></MenuCard>
            </v-col>
            <v-col
                    cols="4"
            >
                <MenuCard></MenuCard>
            </v-col>
            <v-col
                    cols="4"
            >
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