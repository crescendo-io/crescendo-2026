import '@babel/polyfill';
import '@babel/plugin-syntax-dynamic-import';
import * as conditioner from 'conditioner-core/conditioner-core.min';

import './polyfill/arrayFrom';
import './polyfill/arrayFind';
import './polyfill/dataset';

import Rgpd from './modules/rgpd';

Rgpd(cat => {
    console.log(`cookies ${cat} enabled`);
    if (cat === 'statistiques') {
        /* (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', ParamsData.gtag_key, 'auto');
        ga('send', 'pageview'); */
    }
});

document.documentElement.className = 'js';

conditioner.addPlugin({
    // the plugin "monitor" hook
    // use in html : <div data-module="modules/component.js" data-context="@visible true"></div>
    monitor: {
    // the name of our monitor, not prefixed with "@"
        name: 'visible',

        // the monitor factory method, this will create our monitor
        create: (context, element) => ({
            // current match state
            matches: false,

            // called by conditioner to start listening for changes
            addListener(change) {
                new IntersectionObserver((entries) => {
                    // update the matches state
                    this.matches = entries.pop().isIntersecting === context;

                    // inform conditioner of the new state
                    change();
                }).observe(element);
            },
        }),
    },

    // converts module aliases to paths
    moduleSetName: (name) => `./modules/${name}.js`,

    // get the module constructor
    moduleGetConstructor: (module) => module.default,

    // override the import (this makes webpack bundle all the dynamically included files as well)
    // https://webpack.js.org/api/module-methods/#import-
    // - set to "eager" to create a single chunk for all modules
    // - set to "lazy" to create a separate chunk for each module
    moduleImport: (name) => import(/* webpackMode: "lazy" */ `${name}`),
});

conditioner.hydrate(document.documentElement);
