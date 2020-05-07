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
        <div class="menu-card__form_training_set__input">
            <div class="step_name">
                {{stepName}}
            </div>
        </div>
        <div class="menu-card__form_training_set">
            <div class="menu-card__form_training_set__input">
                <div class="set_label">
                    1st
                </div>
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
                    choise..
                </div>
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