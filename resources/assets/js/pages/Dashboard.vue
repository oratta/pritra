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
                <v-card>
                    <v-card-title>
                        R/S期待値変化グラフ
                    </v-card-title>
                    <v-card-text>
                        <ul>
                            <li>売上変化</li>
                            <li>自分の期待値変化</li>
                        </ul>
                    </v-card-text>
                </v-card>
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