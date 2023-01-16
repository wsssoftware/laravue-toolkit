export default {
    init(options, Vue){
        window.gptAds = [];
        window.googletag = {};
        googletag.cmd = googletag.cmd || [];
        this.insertScript();
        Vue.config.globalProperties.$googlead = options;
        Vue.provide('$googlead', options);
    },
    insertScript() {
        let googleScript = document.createElement('script');
        googleScript.async = true;
        googleScript.type = 'text/javascript';
        googleScript.src = 'https://securepubads.g.doubleclick.net/tag/js/gpt.js';
        let head = document.getElementsByTagName('head')[0];
        head.appendChild(googleScript)
    },
}
