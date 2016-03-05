/**
 * bundle configuration
 */
module.exports = {

    config: {
        nameAllCombinedCss: "all.min.css",
        nameAllCombinedHeadJs: "all.head.min.js",
        nameAllCombinedJs: "all.min.js"
    },

    externalFonts: [
        "components-font-awesome/fonts/**/*.{otf,eot,svg,ttf,woff,woff2}",
        "bootstrap/fonts/**/*.{otf,eot,svg,ttf,woff,woff2}"],

    cssExternal: [
        "angular-block-ui/dist/angular-block-ui.min.css",
        "ng-notify/dist/ng-notify.min.css"
    ],

    jsExternal: [
        //JQUERY
        "jquery/dist/jquery.js",

        //BOOTSTRAP
        "bootstrap/dist/js/bootstrap.js",

        //ANGULAR
        "angular/angular.js",
        "angular-route/angular-route.js",
        "angular-resource/angular-resource.js",
        "angular-block-ui/dist/angular-block-ui.min.js",
        "ng-notify/dist/ng-notify.min.js",
        "angular-translate/angular-translate.js",
        "angular-translate-loader-url/angular-translate-loader-url.js"
    ]
}