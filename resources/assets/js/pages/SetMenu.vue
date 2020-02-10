<template>
    <v-container>
        <h1>Set Menu</h1>
        <v-row>
            <v-col lg="4" md="4" sm="6" cols="12" >
                <v-card class="menu-card">
                    <v-card-subtitle>
                        Push Up
                    </v-card-subtitle>
                    <v-img
                            src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
                            height="200px"></v-img>
                    <v-card-title>
                        Full Pull Up
                    </v-card-title>
                    <form>
                        <div class="menu-card__form_training_set">
                            <div class="menu-card__form_training_set__input">
                                <div class="count_box">
                                    <div class="count">
                                        20
                                    </div>
                                    <div class="count_label">
                                        reps
                                    </div>
                                </div>
                                <div class="button_up_down">
                                    <div class="button_up_down__up">
                                        <v-btn icon small>
                                            <v-icon small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </div>
                                    <div class="button_up_down__down">
                                        <v-btn icon small>
                                            <v-icon small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </div>
                                </div>
                                <div class="menu-card__form_training_set__input__spacer"></div>
                                <div class="count_box">
                                    <div class="count">
                                        2
                                    </div>
                                    <div class="count_label">
                                        set
                                    </div>
                                </div>
                                <div class="button_up_down">
                                    <div class="button_up_down__up">
                                        <v-btn icon small>
                                            <v-icon small>mdi-arrow-up-bold</v-icon>
                                        </v-btn>
                                    </div>
                                    <div class="button_up_down__down">
                                        <v-btn icon small>
                                            <v-icon small>mdi-arrow-down-bold</v-icon>
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-card__form_training_set__submit">
                                <v-card-actions>
                                    <v-btn
                                            size="small"
                                    >
                                        History
                                    </v-btn>
                                </v-card-actions>
                                <div class="spacer"></div>
                                <v-card-actions>
                                    <v-btn
                                        color="accent"
                                        size="small"
                                    >
                                        Set
                                    </v-btn>
                                </v-card-actions>
                            </div>
                        </div>
                    </form>
                    <div class="menu-card__info_box">
                        <div class="level_box">
                            Level1 : 10 × 2 set
                            Level2 : 15 × 2 set
                            Level3 : 20 × 3 set
                        </div>
                        <div class="history_box">
                            Best:
                            　Step1: FullPush
                            　　15 × 2 set
                            　 　→ 1st 20
                            　 　→ 2nd 15
                            　　@2019/02/10 9:24
                            Recent:
                            　Step1: FullPush
                            　　15 × 2 set
                            　 　→ 1st 20
                            　 　→ 2nd 15
                            　　@2019/02/10 9:24

                            　Step1: FullPush
                            　　15 × 2 set
                            　 　→ 1st 20
                            　 　→ 2nd 15
                            　　@2019/02/10 9:24

                            　Step1: FullPush
                            　　15 × 2 set
                            　 　→ 1st 20
                            　 　→ 2nd 15
                            　　@2019/02/10 9:24
                        </div>
                    </div>
                </v-card>
            </v-col>
            <v-col lg="4" md="4" sm="6" cols="12" >
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
            <v-col lg="4" md="4" sm="6" cols="12" >
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