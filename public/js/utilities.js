function showToast(message = '') {
    const toast = document.getElementById('liveToast');
    
    const toast_bootstrap = bootstrap.Toast.getOrCreateInstance(toast);

    toast.querySelector('.toast-body').innerText = message;

    toast_bootstrap.show();
}

function setTdEvent(){
    const tds = document.querySelectorAll('td');

    tds.forEach(function(td) {
        td.addEventListener('dblclick', function() {
            copyToClipboard(td.innerText);
        });
    });
}

function copyToClipboard(text = ''){
    navigator.clipboard.writeText(text).then(function() {
        showToast('Texto copiado al portapapeles');
    }, function() {
        showToast('Error al copiar el texto al portapapeles');
    });
}