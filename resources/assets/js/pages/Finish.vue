<template>
    <v-container class="finish">
        <h2>Finish Training!!</h2>
        <v-row>
            <v-col
                    cols="12"
                    md="4"
                    lg="4"
                    xl="4"
                    sm="6"
                    v-for="i in [1,2,3]"
                    :key = "i"
            >
                <v-card
                        max-width="420"
                        class="mx-auto"
                >
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="headline">Push Up</v-list-item-title>
                            <v-list-item-subtitle>Full Push up</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-img
                            :src="url"
                            height="194"
                            class="mx-8"
                            @mouseover="toggleFinish"
                            @mouseleave="toggleStart"
                    ></v-img>

                    <v-list-item class="mx-8">
                        <v-list-item-title>
                            Plan<br>
                            20 × 2set
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            <v-icon large>mdi-arrow-right-bold-outline</v-icon>
                        </v-list-item-subtitle>
                        <v-list-item-title class="text-right">
                            Performance<br>
                            22 × 2set
                        </v-list-item-title>
                    </v-list-item>

                    <v-simple-table height="200px" class="mx-8">
                        <template v-slot:default>
                            <tbody>
                            <tr>
                                <td>1st</td>
                                <td>23</td>
                                <td>Easy</td>
                            </tr>
                            <tr>
                                <td>2nd</td>
                                <td>25</td>
                                <td>Hard</td>
                            </tr>
                            <tr>
                                <td>3rd</td>
                                <td>23</td>
                                <td>Easy</td>
                            </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                </v-card>

            </v-col>
        </v-row>
        <v-btn text to="/training/plan">Training</v-btn>
    </v-container>
</template>
<script>
export default{
    data(){
        return{
            url: "https://hercules-beetle.com/wp-content/uploads/2017/03/short-bridge-01.png",
            startUrl: "https://hercules-beetle.com/wp-content/uploads/2017/03/short-bridge-01.png",
            finishUrl: "https://hercules-beetle.com/wp-content/uploads/2017/03/short-bridge-02.png"
        }
    },
    methods: {
        toggleFinish: function(){
            this.url = this.finishUrl;
        },
        toggleStart: function(){
            this.url = this.startUrl;
        }
    }

}
</script>