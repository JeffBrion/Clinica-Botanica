window.addEventListener('load', function(){
    /* let style = `
    `;
    document.head.innerHTML += style;
    let script = document.createElement('script');
    script.src = '/js/exports/paged.polyfill.js';
    document.body.appendChild(script); */

    setTimeout(() => {
        window.print();
        window.history.back();
    }, 1000);
});