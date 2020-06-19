<template>
    <v-card class="menu-card">
        <v-card-subtitle>
            {{menu.name}}
        </v-card-subtitle>
        <div class="menu-card__img__box">
            <img class="menu-card__img"
                    src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
            ></img>
            <img v-if="isAdd"
                   class="menu-card__img"
                   src="https://cdn.pixabay.com/photo/2014/10/07/10/43/ok-477504_960_720.png"
            ></img>
        </div>
        <div class="menu-card__form_training_set__input">
            <div class="step_name">
                <v-select
                        v-model="selectedWorkoutSet.step"
                        no-data-text="Select Step..."
                        :items="menu.step_l"
                        item-text="name"
                        item-value="number"
                        return-object
                ></v-select>
            </div>
        </div>
        <div class="menu-card__form_training_set">
            <div class="menu-card__form_training_set__input">
                <div class="count_box">
                    <div class="count">
                        {{selectedWorkoutSet.rep}}
                    </div>
                    <div class="count_label">
                        reps
                    </div>
                </div>
                <div class="button_up_down">
                    <div class="button_up_down__up">
                        <v-btn icon small @click="selectedWorkoutSet.rep +=1">
                            <v-icon small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </div>
                    <div class="button_up_down__down">
                        <v-btn icon small @click="selectedWorkoutSet.rep -=1">
                            <v-icon small>mdi-arrow-down-bold</v-icon>
                        </v-btn>
                    </div>
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
                <div class="count_box">
                    <div class="count">
                        {{selectedWorkoutSet.set}}
                    </div>
                    <div class="count_label">
                        set
                    </div>
                </div>
                <div class="button_up_down">
                    <div class="button_up_down__up">
                        <v-btn icon small @click="selectedWorkoutSet.set +=1">
                            <v-icon small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </div>
                    <div class="button_up_down__down">
                        <v-btn icon small @click="selectedWorkoutSet.set -=1">
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
                    <v-btn v-if="!isAdd"
                            color="accent"
                            size="small"
                            @click="$emit('set-menu', selectedWorkoutSet)"
                    >
                        Set
                    </v-btn>
                    <v-btn v-else
                            disabled
                    >
                        Added
                    </v-btn>
                </v-card-actions>
            </div>
        </div>
        <div class="menu-card__info_box" v-show="isInfoBox">
            <div class="level_box">
                <div class="level_box__title">
                    <v-icon>mdi-run</v-icon>{{menu.name}}
                </div>
                <div class="level_box__card"
                    v-for="step in menu.step_l" :key=step.number
                >
                    <div class="level_box__card__step_name">S{{step.number}} {{step.name}}</div>
                    <ul>
                        <li v-for="level in step.levelInfo" :key="level.level">
                            Lv{{level.level}} : {{level.repCount}} × {{level.setCount}}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="history_box">
                <div class="history_box__title">
                    <v-icon>mdi-panda</v-icon>Best
                </div>
                <div class="history_box__card">
                    <div class="history_box__card__step_name">{{historyWorkout.best.name}}</div>
                    <div class="history_box__card__count">{{historyWorkout.best.rep}} × {{historyWorkout.best.set}}</div>
                    <div class="history_box__card__time">{{historyWorkout.best.date}}</div>
                </div>
                <div class="history_box__title">
                    <v-icon>mdi-history</v-icon>Recent
                </div>
                <div class="history_box__card"
                    v-for="i in [0,1,2]"
                >
                    <div class="history_box__card__step_name">S{{historyWorkout.recent[i].number}} {{historyWorkout.recent[i].name}}</div>
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
            testList:["test1", "test2", "test3"],
            isInfoBox: false,
            selectedWorkoutSet: {},
            recommendWorkoutSet: {
                step: {
                    name: 'Full Push Up',
                    number: 2,
                },
                rep: 20,
                set: 3,
            },
            historyWorkout: {
                'best': {
                    number: 1,
                    name: 'FullPush',
                    rep: 15,
                    set: 2,
                    date: '2019/02/01 9:24',
                },
                'recent':[
                    {
                        number: 1,
                        name: 'FullPush',
                        rep: 15,
                        set: 2,
                        date: '2019/02/01 9:24',
                    },
                    {
                        number: 2,
                        name: 'HalfPush',
                        rep: 15,
                        set: 3,
                        date: '2019/01/01 9:24',
                    },
                    {
                        number: 1,
                        name: 'FullPush',
                        rep: 20,
                        set: 2,
                        date: '2018/12/01 9:24',
                    },
                ]
            }
        }
    },
    props: {
        isAdd: {
            type:Boolean,
            requiered:true,
        },
        menu: {
            type:Object,
            required:true,
        },
    },
    methods: {
        init: function(){
            //データロードを待たずにレンダリングするので、menuのresponseが来る前に参照しちゃう
            this.selectedWorkoutSet = this.menu.recommend;
        },
    },
    watch: {
        // ルートが変更されたらこのメソッドを再び呼び出します
        menu: 'init'
    },
}
</script>