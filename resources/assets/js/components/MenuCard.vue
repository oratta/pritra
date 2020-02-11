<template>
    <v-card class="menu-card">
        <v-card-subtitle>
            {{menuName}}
        </v-card-subtitle>
        <v-img
                src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
                height="200px"></v-img>
        <v-card-title>
            {{recommendWorkoutSet.stepName}}
        </v-card-title>
        <form>
            <div class="menu-card__form_training_set">
                <div class="menu-card__form_training_set__input">
                    <div class="count_box">
                        <div class="count">
                            {{recommendWorkoutSet.rep}}
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
                    <v-icon>mdi-run</v-icon>{{menuName}}
                </div>
                <div class="level_box__card"
                    v-for="step in steps" :key=step.stepNumber
                >
                    <div class="level_box__card__step_name">S{{step.stepNumber}} {{step.name}}</div>
                    <ul>
                        <li v-for="level in step.levels" :key="level.levelNumber">
                            Lv{{level.id}} : {{level.rep}} × {{level.set}}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="history_box">
                <div class="history_box__title">
                    <v-icon>mdi-panda</v-icon>Best
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">S{{historyWorkout.best.stepNumber}} {{historyWorkout.best.stepName}}</div>
                    <div class="history_box__card__count">{{historyWorkout.best.rep}} × {{historyWorkout.best.set}}</div>
                    <div class="history_box__card__time">{{historyWorkout.best.date}}</div>
                </div>
                <div class="history_box__title">
                    <v-icon>mdi-history</v-icon>Recent
                </div>
                <div class="history_box__card"
                    v-for="i in [0,1,2]"
                >
                    <div class="history_box__card__step_name">S{{historyWorkout.recent[i].stepNumber}} {{historyWorkout.recent[i].stepName}}</div>
                    <div class="history_box__card__count">{{historyWorkout.recent[i].rep}} × {{historyWorkout.recent[i].set}}</div>
                    <div class="history_box__card__time">{{historyWorkout.recent[i].date}}</div>
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
            menuName: 'Push Up',
            recommendWorkoutSet: {
                stepName: 'S4 Full Push Up',
                rep: 20,
                set: 3,
            },
            steps:[
                {
                    name: 'Wall Push Up',
                    stepNumber:1,
                    levels:[
                        {
                            levelNumber:1,
                            rep: 5,
                            set: 1,
                        },
                        {
                            levelNumber:2,
                            rep: 10,
                            set: 1,
                        },
                        {
                            levelNumber:3,
                            rep: 10,
                            set: 2,
                        },

                    ]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:2,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:3,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:4,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:5,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:6,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:7,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:8,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:9,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
                {
                    name: 'Half Push Up',
                    stepNumber:10,
                    levels:[{levelNumber:1, rep: 5, set: 1,}, {levelNumber:2, rep: 10, set: 1,}, {levelNumber:3, rep: 10, set: 2,},]
                },
            ],
            historyWorkout: {
                'best': {
                    stepNumber: 1,
                    stepName: 'FullPush',
                    rep: 15,
                    set: 2,
                    date: '2019/02/01 9:24',
                },
                'recent':[
                    {
                        stepNumber: 1,
                        stepName: 'FullPush',
                        rep: 15,
                        set: 2,
                        date: '2019/02/01 9:24',
                    },
                    {
                        stepNumber: 2,
                        stepName: 'HalfPush',
                        rep: 15,
                        set: 3,
                        date: '2019/01/01 9:24',
                    },
                    {
                        stepNumber: 1,
                        stepName: 'FullPush',
                        rep: 20,
                        set: 2,
                        date: '2018/12/01 9:24',
                    },
                ]
            }
        }
    },
    props: {

    }
}
</script>