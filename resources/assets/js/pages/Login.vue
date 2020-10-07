<template>
    <v-container>
        <v-tabs>
            <v-tab
                    class="tab__item"
                    :class="{'tab__item--active': tab === 1 }"
                    @click="tab = 1"
            >Login</v-tab>
            <v-tab
                    class="tab__item"
                    :class="{'tab__item--active': tab ===2 }"
                    @click="tab = 2"
            >Register</v-tab>
        </v-tabs>
        <div class="panel" v-show="tab === 1">
            <v-form
                    ref="form"
                    v-model="validLogin"
                    lazy-validation
                    @submit.prevent="login"
            >
                <div v-if="loginErrors" class="errors">
                    <ul v-if="loginErrors.email">
                        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="loginErrors.password">
                        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <v-text-field
                        v-model="loginForm.email"
                        :rules="emailRules"
                        label="E-mail"
                        required
                ></v-text-field>

                <v-text-field
                        v-model="loginForm.password"
                        :append-icon="isShowPasswordLogin ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="passwordRules"
                        label="Password"
                        :type="isShowPasswordLogin ? 'text' : 'password'"
                        @click:append="isShowPasswordLogin = !isShowPasswordLogin"
                        required
                ></v-text-field>

                <v-btn
                        color="primary"
                        :disabled="!validLogin"
                        class="mr-4"
                        type="submit"
                >
                    submit
                </v-btn>
                <v-btn
                        color="info"
                        class="mr-4"
                        @click="reset"
                        dark
                >
                    Reset Form
                </v-btn>
            </v-form>
        </div>
        <div class="panel" v-show="tab === 2">
            <v-form
                    ref="form"
                    v-model="validRegister"
                    lazy-validation
                    @submit.prevent="register"
            >
                <div v-if="registerErrors" class="errors">
                    <ul v-if="registerErrors.name">
                        <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.email">
                        <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.password">
                        <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <v-text-field
                        v-model="registerForm.name"
                        :counter="10"
                        :rules="nameRules"
                        label="Name"
                        required
                ></v-text-field>

                <v-text-field
                        v-model="registerForm.email"
                        :rules="emailRules"
                        label="E-mail"
                        required
                ></v-text-field>

                <v-text-field
                        v-model="registerForm.password"
                        :append-icon="isShowPasswordRegister ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="passwordRules"
                        label="Password"
                        :type="isShowPasswordRegister ? 'text' : 'password'"
                        @click:append="isShowPasswordRegister = !isShowPasswordRegister"
                        required
                ></v-text-field>

                <v-btn
                        color="accent"
                        :disabled="!validRegister"
                        class="mr-4"
                        @click="validate"
                        type="submit"
                >
                    submit
                </v-btn>
                <v-btn
                        class="mr-4"
                        @click="reset"
                >
                    Reset Form
                </v-btn>
            </v-form>
        </div>
    </v-container>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        data () {
            return {
                tab: 1,
                validRegister: true,
                validLogin: true,
                isShowPasswordRegister: false,
                isShowPasswordLogin: false,
                loginForm: {
                    email: '',
                    password: ''
                },
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                },
                nameRules: [
                    v => !!v || 'Name is required',
                    v => (v && v.length <= 10) || 'Name must be less than 10 characters',
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v.length >= 8 && v.length <= 30) || 'Min 8 and max 30 characters'
                ],
            }
        },
        methods: {
            async login () {
                // authストアのloginアクションを呼び出す
                await this.$store.dispatch('auth/login', this.loginForm)

                if (this.apiStatus){
                    // トップページに移動する
                    this.$router.push('/')
                }
            },
            async register () {
                // authストアのresigterアクションを呼び出す
                await this.$store.dispatch('auth/register', this.registerForm)

                if (this.apiStatus) {
                    // トップページに移動する
                    this.$router.push('/')
                }
            },
            clearError () {
                this.$store.commit('auth/setLoginErrorMessages', null)
                this.$store.commit('auth/setRegisterErrorMessages', null)
            },
            validate () {
                this.$refs.form.validate()
            },
            reset () {
                this.$refs.form.resetValidation()
                this.$refs.form.reset()
            },
        },
        created(){
            this.clearError()
        },
        computed: {
            ...mapState({
                apiStatus: state => state.auth.apiStatus,
                loginErrors: state => state.auth.loginErrorMessages,
                registerErrors: state => state.auth.registerErrorMessages
            })
        }
    }
</script>