<template>
    <v-card class="menu-card">
        <v-card-subtitle>
            {{menuName}}
        </v-card-subtitle>
        <div class="menu-card__img__box">
            <img class="menu-card__img"
                    src="https://hercules-beetle.com/wp-content/uploads/2017/03/full-pushup-01.png"
            ></img>
        </div>
        <div class="step_name center">
            {{stepName}}
        </div>
        <div class="menu-card__objective center">
            <div class="count_box">
                <div class="count blue--text">
                    20
                </div>
                <div class="count_label">
                    reps
                </div>
            </div>
            <div class="menu-card__form_training_set__input__spacer"></div>
            <div class="count_box">
                <div class="count blue--text">
                    2
                </div>
                <div class="count_label">
                    set
                </div>
            </div>
        </div>
        <div class="menu-card__form_training_set">
            <div class="menu-card__form_training_set__input">
                <div class="set_number_label">
                    1st
                </div>
                <div class="menu-card__form_training_set__input__spacer"></div>
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
                <div class="weight">
                    <v-select
                            v-model="sampleValue"
                            :items="sampleItems"
                            standard
                            label="training load..."
                    ></v-select>
                </div>
            </div>
            <div class="add_set_button center">
                <v-btn class="mx-2" fab dark color="indigo">
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
            </div>
            <div class="menu-card__form_training_set__submit">
                <v-card-actions>
                </v-card-actions>
                <div class="spacer"></div>
                <v-card-actions>
                    <v-btn
                           color="accent"
                           size="small"
                           @click="$emit('set-menu', selectedWorkoutSet)"
                    >
                        Finish
                    </v-btn>
                </v-card-actions>
            </div>
        </div>
    </v-card>
</template>
<script>
export default{
    data(){
        return {
            selectedWorkoutSet: {
                rep: 20,
            },
            sampleValue: 0,
            sampleItems: [
                'banana', 'apple', 'orange'
            ],
        }
    },
    props: {
        menuName: {
            type:String,
            required:true,
        },
        stepName: {
            type:String,
            required:true,
        }
    },
    methods: {
        init: function(){
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