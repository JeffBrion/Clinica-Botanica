document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('role').addEventListener('input', function(event) {
       setInputs(event.target.value);
    });
    setInputs(document.getElementById('role').value);
});

function setInputs(role){
    if (role == 'Administrador') {
        let modules_container = document.getElementById('modules');
        modules_container.classList.remove('d-block');
        modules_container.classList.add('d-none');

        Array.from(document.getElementsByClassName('checkbox-modules')).forEach(element => {
            element.disabled = true;
        });
    }

    if(role == 'Usuario') {
        let modules_container = document.getElementById('modules');
        modules_container.classList.remove('d-none');
        modules_container.classList.add('d-block');

        Array.from(document.getElementsByClassName('checkbox-modules')).forEach(element => {
            element.disabled = false;
        });
    }
}