import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import i18n from './i18n'
import '../../sass/overrides.sass'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/es5/util/colors'

Vue.use(Vuetify)

export default new Vuetify({
    lang: {
        t: (key, ...params) => i18n.t(key, params),
    },
    theme: {
        themes:{
            light: {
                primary: colors.orange.base,
                secondary: colors.orange.darken1,
                accent: colors.orange.accent1,
                error: colors.red.base,
                warning: colors.red.base,
                info: colors.lightBlue.base,
                success: colors.green.base,
            },
            dark: {
                primary: colors.orange.base,
                secondary: colors.orange.darken1,
                accent: colors.orange.accent1,
                error: colors.red.base,
                warning: colors.red.base,
                info: colors.lightBlue.base,
                success: colors.green.base,
            }
        }
    }
})
