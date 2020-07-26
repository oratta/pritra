<template>
    <v-container>
        <v-row>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="success"
                        icon="mdi-cash-usd-outline"
                        title="Revenue Forcasting"
                        value="¥ 343,245"
                        sub-icon="mdi-calendar"
                        sub-text="July 2020"
                />
            </v-col>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="success"
                        icon="mdi-star-four-points-outline"
                        title="Revenue share Forcasting"
                        value="¥ 1,122"
                        sub-icon="mdi-calendar"
                        sub-text="July 2020"
                />
            </v-col>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="info"
                        icon="mdi-cash-usd-outline"
                        title="Revenue (actual)"
                        value="¥ 23,490"
                        sub-icon="mdi-calendar"
                        sub-text="2020-07-26"
                />
            </v-col>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="info"
                        icon="mdi-cash-usd-outline"
                        title="Revenue (actual)"
                        value="¥ 233,490"
                        sub-icon="mdi-calendar"
                        sub-text="July 2020"
                />
            </v-col>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="info"
                        icon="mdi-account-outline"
                        title="Monthly Active User"
                        value="2,403"
                        sub-icon="mdi-calendar"
                        sub-text="July 2020"
                />
            </v-col>
            <v-col
                    cols="12"
                    sm="6"
                    lg="3"
            >
                <dashboard-material-stats-card
                        color="info"
                        icon="mdi-cursor-pointer"
                        title="Contribution Point"
                        value="34,223"
                        sub-icon="mdi-calendar"
                        sub-text="July 2020"
                />
            </v-col>
            <v-col
                    cols="12"
                    lg="4"
            >
                <dashboard-material-chart-card
                        :data="monthlySalesChart.data"
                        :options="monthlySalesChart.options"
                        color="success"
                        hover-reveal
                        type="Line"
                >
                    <h4 class="card-title font-weight-light mt-2 ml-2">
                        Monthly Sales
                    </h4>

                    <p class="d-inline-flex font-weight-light ml-2 mt-1">
                        <v-icon
                                color="green"
                                small
                        >
                            mdi-arrow-up
                        </v-icon>
                        <span class="green--text">55%</span>&nbsp;
                        increase in this month's sales
                    </p>

                    <template v-slot:actions>
                        <v-icon
                                class="mr-1"
                                small
                        >
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption grey--text font-weight-light">updated 4 minutes ago</span>
                    </template>
                </dashboard-material-chart-card>
            </v-col>
            <v-col
                    cols="12"
                    lg="4"
            >
                <dashboard-material-chart-card
                        :data="monthlyRSChart.data"
                        :options="monthlyRSChart.options"
                        color="success"
                        hover-reveal
                        type="Line"
                >
                    <h4 class="card-title font-weight-light mt-2 ml-2">
                        Monthly Revenue Share
                    </h4>
                    <template v-slot:actions>
                        <v-icon
                                class="mr-1"
                                small
                        >
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption grey--text font-weight-light">updated 4 minutes ago</span>
                    </template>
                </dashboard-material-chart-card>
            </v-col>
            <v-col
                    cols="12"
                    md="6"
            >
                <dashboard-material-card
                        color="warning"
                        class="px-5 py-3"
                >
                    <template v-slot:heading>
                        <div class="display-2 font-weight-light">
                            Contributor Ranking
                        </div>
                        <div class="subtitle-1 font-weight-light">
                            New employees on 15th September, 2016
                        </div>
                    </template>
                    <v-card-text>
                        <v-data-table
                                :headers="rankingTable.headers"
                                :items="rankingTable.items"
                        />
                    </v-card-text>
                </dashboard-material-card>
            </v-col>
            <v-col
                    cols="12"
                    lg="4"
            >
                <v-card>
                    <v-card-title>bounty menu</v-card-title>
                    <v-card-text>
                        Issue List<br>
                        and<br>
                        Bounty UI
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                    cols="12"
                    lg="4"
            >
                <v-card>
                    <v-card-title>Activity Log</v-card-title>
                    <v-card-text>
                        <ul>
                            <li>サービスの活動履歴</li>
                            <ul>
                                <li>ver1.2がリリースされました</li>
                                <li>◯◯さんが☓☓機能を完成させました</li>
                            </ul>
                        </ul>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                    cols="12"
                    lg="4"
            >
                <v-card>
                    <v-card-title>Open Chat</v-card-title>
                    <v-card-text>
                        <ul>
                            <li>もしもし</li>
                            <li>かめひょ</li>
                            <li>かめさんひょ</li>
                        </ul>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
        name: 'Dashboard',
        data(){
            return {
                monthlySalesChart: {
                    data: {
                        labels: ['1', '2', '3', '4', '5', '6', '7'],
                        series: [
                            [12032, 17346, 7345, 17345, 23345, 18454, 38345],
                        ],
                    },
                    options: {
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0,
                        }),
                        low: 0,
                        high: 50000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0,
                        },
                    },
                },
                monthlyRSChart: {
                    data: {
                        labels: ['1', '2', '3', '4', '5', '6', '7'],
                        series: [
                            [120, 176, 45, 145, 235, 154, 345],
                        ],
                    },
                    options: {
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0,
                        }),
                        low: 0,
                        high: 500, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0,
                        },
                    },
                },
                rankingTable: {
                    headers: [
                        {
                            sortable: false,
                            text: 'Name',
                            value: 'name',
                        },
                        {
                            sortable: false,
                            text: 'CP',
                            value: 'cp',
                            align: 'right',
                        },
                        {
                            sortable: false,
                            text: 'R/S',
                            value: 'rs',
                            align: 'right',
                        }
                    ],
                    items: [
                        {
                            name: 'Dakota Rice',
                            cp: '2,343',
                            rs: '23,034',
                        },
                        {
                            id: 2,
                            name: 'Minerva Hooper',
                            cp: '2,033',
                            rs: '21,098',
                        },
                        {
                            id: 3,
                            name: 'Sage Rodriguez',
                            cp: '1,892',
                            rs: '19,033',
                        },
                        {
                            id: 4,
                            name: 'Philip Chanley',
                            cp: '1,535',
                            rs: '13,230',
                        },
                        {
                            id: 5,
                            name: 'Doris Greene',
                            cp: '1,209',
                            rs: '10,984',
                        },
                    ],
                }
            }
        }
    }
</script>