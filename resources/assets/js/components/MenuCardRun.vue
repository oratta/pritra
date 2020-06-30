<template>
    <v-card class="menu-card">
        <v-card-subtitle>
            {{planInfo.menu.name}}
        </v-card-subtitle>
        <div class="menu-card__img__box">
            <img class="menu-card__img"
                    :src="planInfo.step.imageUrl"
            ></img>
        </div>
        <div class="step_name center">
            {{planInfo.step.name}}
        </div>
        <div class="menu-card__objective center">
            <div class="count_box">
                <div class="count blue--text">
                    {{planInfo.reps}}
                </div>
                <div class="count_label">
                    reps
                </div>
            </div>
            <div class="menu-card__form_training_set__input__spacer"></div>
            <div class="count_box">
                <div class="count blue--text">
                    {{planInfo.set}}
                </div>
                <div class="count_label">
                    set
                </div>
            </div>
        </div>
        <div class="menu-card__form_training_set">
            <div
                    class="menu-card__form_training_set__input"
                    v-for="workout in workoutList"
            >
                <div class="set_number_label">
                    {{workout.label}}
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
                <div class="count_box">
                    <div class="count">
                        {{workout.rep}}
                    </div>
                    <div class="count_label">
                        reps
                    </div>
                </div>
                <div class="button_up_down">
                    <div class="button_up_down__up">
                        <v-btn
                                icon
                                small
                                @click="workout.rep +=1"
                                :disabled="workout.isFinish"
                        >
                            <v-icon small>mdi-arrow-up-bold</v-icon>
                        </v-btn>
                    </div>
                    <div class="button_up_down__down">
                        <v-btn
                                icon
                                small
                                @click="workout.rep -=1"
                                :disabled="workout.isFinish"
                        >
                            <v-icon small>mdi-arrow-down-bold</v-icon>
                        </v-btn>
                    </div>
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
                <div class="weight">
                    <v-select
                            v-model="workout.difficulty"
                            :items="difficultyList"
                            standard
                            :disabled="workout.isFinish"
                            label="training load..."
                    ></v-select>
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
                <div class="fin_button">
                    <v-btn
                            :disabled="workout.isFinish"
                            color="accent"
                            size="small"
                            @click="workout.isFinish=true"
                    >
                        Fin
                    </v-btn>
                </div>
            </div>
            <div class="add_set_button center">
                <v-btn
                        class="mx-2"
                        fab dark color="indigo"
                        @click="addWorkout"
                >
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
            </div>
        </div>
    </v-card>
</template>
<script>
export default{
    computed: {
        SET_NAME_LABEL: function(){
            return {
                1: '1st',
                2: '2nd',
                3: '3rd',
            }
        }
    },
    data(){
        return {
            workoutList:[],
        }
    },
    props: {
        planInfo: {
            type:Object,
            required:true,
        },
        difficultyList: {
            type:Array,
            required:true,
        }
    },
    methods: {
        init: function(){
            this.workoutList.push({
                rep:this.planInfo.reps,
                label:"1st",
                isFinish:false,
                difficulty: 0,
            });
        },
        addWorkout: function(){
            let label = this.getSetNameLabel(this.workoutList.length + 1)
            this.workoutList.push({
                rep: this.planInfo.reps,
                label: label,
                isFinish:false,
                difficulty: 0,
            });
        },
        getSetNameLabel: function(number){
            if(number<4){
                return this.SET_NAME_LABEL[number];
            }
            else{
                return number + "th";
            }
        },
    },
    created () {
        // view が作られた時にデータを取得し、
        // そのデータは既に監視されています
        this.init()
    },
    watch: {
        // ルートが変更されたらこのメソッドを再び呼び出します
        '$route': 'init'
    },
}
</script>