<template>
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
                                @click="isInfoBox=!isInfoBox"
                        >
                            Info
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
        <div class="menu-card__info_box" v-show="isInfoBox">
            <div class="level_box">
                <div class="level_box__title">
                    <v-icon>mdi-run</v-icon>Push Up
                </div>
                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>
                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>

                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>

                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>

                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>

                <div class="level_box__card">
                    <div class="level_box__card__step_name">1:FullPush</div>
                    <ul>
                        <li>
                            Lv1 : 10 × 2
                        </li>
                        <li>
                            Lv2 : 15 × 2
                        </li>
                        <li>
                            Lv3 : 20 × 3
                        </li>
                    </ul>
                </div>

            </div>
            <div class="history_box">
                <div class="history_box__title">
                    <v-icon>mdi-panda</v-icon>Best
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">Step1 FullPush</div>
                    <div class="history_box__card__count">15 × 2</div>
                    <div class="history_box__card__time">2019/02/10 9:24</div>
                </div>
                <div class="history_box__title">
                    <v-icon>mdi-history</v-icon>Recent
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">Step1 FullPush</div>
                    <div class="history_box__card__count">15 × 2</div>
                    <div class="history_box__card__time">2019/02/10 9:24</div>
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">Step1 FullPush</div>
                    <div class="history_box__card__count">15 × 2</div>
                    <div class="history_box__card__time">2019/02/10 9:24</div>
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">Step1 FullPush</div>
                    <div class="history_box__card__count">15 × 2</div>
                    <div class="history_box__card__time">2019/02/10 9:24</div>
                </div>
            </div>
        </div>
    </v-card>
</template>
<script>
export default{
    data(){
        return {
            isInfoBox: false,
        }
    },
}
</script>