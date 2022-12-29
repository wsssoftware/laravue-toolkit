import GoogleAd from "./GoogleAd.vue";
import Core from './Core';
export default {

    install(Vue, options){
        Core.init(options, Vue);
        Vue.component('GoogleAd', GoogleAd);
    },
}
