document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.mandatlyConfig === 'undefined') {
        console.error('Mandatly configuration is missing.');
        return;
    }

    const { showBanner, demoMode, websiteGUID, demoBannerScript } = window.mandatlyConfig;

    if (!showBanner) {
        console.log('Cookie banner is disabled.');
        return;
    }

    let scriptSrc = '';

    // if (demoMode) {
    //     scriptSrc = demoBannerScript;
    //     console.log('Loading demo banner:', scriptSrc);
    // } else {
    //     if (websiteGUID) {
    //         scriptSrc = `https://cdnscript.mandatlyonline.net/cai/bn/${websiteGUID}.js`;
    //         console.log('Loading actual cookie banner:', scriptSrc);
    //     } else {
    //         console.error('Website GUID is missing. Cookie banner script will not load.');
    //         return;
    //     }
    // }

    let script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = scriptSrc;
    script.onload = function () {
        console.log('Cookie banner script loaded successfully.');
    };
    script.onerror = function () {
        console.error('Failed to load the cookie banner script:', scriptSrc);
    };
    document.head.appendChild(script);
});






















































// document.addEventListener('DOMContentLoaded', function () {
//     // Check if the cookie banner should be displayed
//     if (typeof window.websiteGUID === 'undefined' || !window.websiteGUID) {
//         console.warn('Website GUID is not provided. Cookie banner functionality may not work as expected.');
//         return;
//     }

//     // Inject the cookie banner script dynamically
//     var script = document.createElement('script');
//     script.type = 'text/javascript';

//     // Use the website GUID to dynamically construct the script URL if needed
//     var defaultScriptUrl = 'https://cdnscript.mandatlyonline.net/cad/bn/' + window.websiteGUID + '.js';
//     script.src = defaultScriptUrl;

//     // Handle script loading
//     script.onload = function () {
//         console.log('Cookie banner script loaded successfully.');
//     };

//     script.onerror = function () {
//         console.error('Failed to load the cookie banner script. Please check the Website GUID or script URL.');
//     };

//     // Append the script to the head of the document
//     document.head.appendChild(script);

//     // Additional behavior for Demo Mode
//     if (typeof window.demoMode !== 'undefined' && window.demoMode) {
//         console.log('Demo Mode is enabled. The cookie banner is running in test mode.');
//     }
// });
























