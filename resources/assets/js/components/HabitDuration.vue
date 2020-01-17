<template>
    <v-container>
        <v-row
                v-for="habitDuration in habitDurations"
                :key="habitDuration.name"
        >
            <v-col cols="12">
                <v-card>
                    <form>
                        <v-row>
                            <v-col cols="9" align="center" justify="center">
                                <v-card-subtitle>habit name</v-card-subtitle>
                                <v-card-text>
                                    <div
                                            class="display-1 font-weight-thick"
                                            v-if="habitDuration.name"
                                    >
                                        {{ habitDuration.name}}
                                    </div>
                                    <v-text-field
                                            label="Input Habit Name"
                                            v-else
                                            v-model="habitDuration.inputName"
                                    >
                                    </v-text-field>
                                </v-card-text>
                                <v-chip
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                        v-show="habitDuration.isBest"
                                >
                                    Best Record
                                </v-chip>
                                <v-card-text
                                        class="display-1"
                                        v-show="habitDuration.diffTime"
                                >
                                    {{ hours(habitDuration) }} :
                                    {{ minutes(habitDuration) | zeroPad }} :
                                    {{ seconds(habitDuration) | zeroPad }} :
                                    {{ milliSeconds(habitDuration) | zeroPad(3) }}
                                </v-card-text>
                            </v-col>
                            <v-col cols="3" justify="center" align-self="center">
                                <v-btn
                                        class="mx-1"
                                        fab
                                        dark
                                        large
                                        color="red"
                                        @click="stopTimer(habitDuration)"
                                        v-show="habitDuration.isRunning"
                                >
                                    <v-icon dark large>mdi-stop-circle-outline</v-icon>
                                </v-btn>
                                <v-btn
                                        class="mx-1"
                                        fab
                                        dark
                                        large
                                        color="cyan"
                                        @click="startTimer(habitDuration)"
                                        v-show="!habitDuration.isRunning"
                                >
                                    <v-icon dark large>mdi-play-circle-outline</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </form>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card flat>
                    <v-row justify="center">
                        <v-col cols="12" justify="center" align-self="center">
                            <v-btn
                                    absolute
                                    dark
                                    fab
                                    bottom
                                    right
                                    color="pink"
                                    @click="addHabit"
                            >
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default{
    data(){
        return {
            animateFrame: 0,
            nowTime: 0,
            diffTime: 0,
            startTime: 0,
            isRunning: false,
            habitDurations: [
                {
                    name: "ファスティング",
                    diffTime: 122324,
                    animateFrame: 0,
                    nowTime: 0,
                    startTime: 0,
                    isRunning: false,
                    isBest: false,
                },
                {
                    name: "禁煙",
                    diffTime: 0,
                    animateFrame: 0,
                    nowTime: 0,
                    startTime: 0,
                    isRunning: false,
                    isBest: false,
                },
                {
                    name: null,
                    diffTime: 0,
                    animateFrame: 0,
                    nowTime: 0,
                    startTime: 0,
                    isRunning: false,
                    isBest: false,
                }
            ]
        }
    },
    methods: {
        // 現在時刻から引数に渡した数値を startTime に代入
        getSubtractStartTime: function (time) {
            var time = typeof time !== 'undefined' ? time : 0;
            return Math.floor(performance.now() - time);
        },
        // タイマーをスタートさせる
        startTimer: function (habitDuration) {
            if(!habitDuration.name){
                habitDuration.name = habitDuration.inputName;
            }

            habitDuration.startTime = this.getSubtractStartTime(habitDuration.diffTime);
            // ループ処理
            (function loop(){
                habitDuration.nowTime = Math.floor(performance.now());
                habitDuration.diffTime = habitDuration.nowTime - habitDuration.startTime;
                habitDuration.animateFrame = requestAnimationFrame(loop);
            }());
            habitDuration.isRunning = true;
            console.log(habitDuration);
        },
        // タイマーを停止させる
        stopTimer: function (habitDuration) {
            habitDuration.isRunning = false;
            cancelAnimationFrame(habitDuration.animateFrame);
        },
        // 初期化
        clearAll: function (habitDuration) {
            habitDuration.startTime = 0;
            habitDuration.nowTime = 0;
            habitDuration.diffTime = 0;
            this.stopTimer(habitDuration);
            habitDuration.animateFrame = 0;
        },
        // 時間を計算
        hours: function (habitDuration) {
            return Math.floor(habitDuration.diffTime / 1000 / 60 / 60);
        },
        // 分数を計算 (60分になったら0分に戻る)
        minutes: function (habitDuration) {
            return Math.floor(habitDuration.diffTime / 1000 / 60) % 60;
        },
        // 秒数を計算 (60秒になったら0秒に戻る)
        seconds: function (habitDuration) {
            return Math.floor(habitDuration.diffTime / 1000) % 60;
        },
        // ミリ数を計算 (1000ミリ秒になったら0ミリ秒に戻る)
        milliSeconds: function (habitDuration) {
            return Math.floor(habitDuration.diffTime % 1000);
        },
        addHabit: function() {
            this.habitDurations.push(
                {
                    name: null,
                    diffTime: 0,
                    animateFrame: 0,
                    nowTime: 0,
                    startTime: 0,
                    isRunning: false,
                    isBest: false,
                }
            )
            console.log(this.habitDurations)
        }
    },
    filters: {
        // ゼロ埋めフィルタ 引数に桁数を入力する
        // ※ String.prototype.padStart() は IEじゃ使えない
        zeroPad: function(value, num){
            var num = typeof num !== 'undefined' ? num : 2;
            return value.toString().padStart(num,"0");
        }
    }
}
</script>