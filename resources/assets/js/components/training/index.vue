<template>
    <table>
        <tr>
            <th>日付</th>
            <th>メニュー</th>
            <th>ステップ</th>
            <th>回数</th>
            <th>強度</th>
        </tr>
        <tr v-for="workOut in workOuts">
            <td>{{ workOut.date }}</td>
            <td>{{ workOut.getMenu() }}</td>
            <td>{{ workOut.stepMenu() }}</td>
            <td>{{ workOut.count  }}</td>
            <td>{{ workOut.getDifficulty()  }}</td>
        </tr>
    </table>
</template>

<script>
    export default {
        create() {
            this.fetchWorkOut()
        },
        date() {
            return {
                workOut: []
            }
        },
        methods: {
            fetchWorkOut(){
                this.$http.get('/api/work_outs')
                    .then(res => {
                        this.workOut = res.data
                    })
            }
        }
    }
</script>