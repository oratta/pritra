<template>
    <v-card class="menu-card">
        <v-card-subtitle>
            {{menu.name}}
        </v-card-subtitle>
        <div class="menu-card__img__box">
            <img class="menu-card__img"
                 :src="selectedWorkoutSet.step.imageUrl"
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
                        {{selectedWorkoutSet.repCount}}
                    </div>
                    <div class="count_label">
                        repCount
                    </div>
                </div>
                <div class="button_up_down">
                    <div class="button_up_down__up">
                        <v-btn icon small @click="selectedWorkoutSet.repCount +=1">
                            <v-icon small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </div>
                    <div class="button_up_down__down">
                        <v-btn icon small @click="selectedWorkoutSet.repCount -=1">
                            <v-icon small>mdi-arrow-down-bold</v-icon>
                        </v-btn>
                    </div>
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
                <div class="count_box">
                    <div class="count">
                        {{selectedWorkoutSet.setCount}}
                    </div>
                    <div class="count_label">
                        set
                    </div>
                </div>
                <div class="button_up_down">
                    <div class="button_up_down__up">
                        <v-btn icon small @click="selectedWorkoutSet.setCount +=1">
                            <v-icon small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </div>
                    <div class="button_up_down__down">
                        <v-btn icon small @click="selectedWorkoutSet.setCount -=1">
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
                    <div class="level_box__card__step_name">{{step.name}}</div>
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
                    <div class="history_box__card__step_name">{{historyInfo.best.step.name}}</div>
                    <div class="history_box__card__count">{{historyInfo.best.repCount}} × {{historyInfo.best.setCount}}</div>
                    <div class="history_box__card__time">{{historyInfo.best.date}}</div>
                </div>
                <div class="history_box__title">
                    <v-icon>mdi-history</v-icon>Recent
                </div>
                <div class="history_box__card"
                     v-if="historyInfo.recentList.length == 0"
                >
                    no log
                </div>
                <div class="history_box__card"
                     v-else
                     v-for="recent in historyInfo.recentList"
                >
                    <div class="history_box__card__step_name">{{recent.step.name}}</div>
                    <div class="history_box__card__count">{{recent.repCount}} × {{recent.setCount}}</div>
                    <div class="history_box__card__time">{{recent.date}}</div>
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
            selectedWorkoutSet: {
                step: {
                    name: '',
                    number: 0,
                    imageUrl: '',
                },
                repCount: 0,
                setCount: 0,
            },
            historyInfo: {
                'best': {
                    step: {
                        name: '',
                    },
                    repCount: 0,
                    setCount: 0,
                    date: '',
                },
                'recentList':[
                    {
                        step:{
                            name: '',
                        },
                        repCount: 0,
                        setCount: 0,
                        date: '',
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
            this.selectedWorkoutSet = this.menu.recommend;
            this.historyInfo = this.menu.historyInfo;
        },
    },
    watch: {
        menu: {
            handler: 'init',
            immediate: true
        }
    },
}
</script>