document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btn_send_evaluation').addEventListener('click', sendForm);
});

function loadAnswers(){
    let form = document.getElementById('form_send_evaluation');

    let radioGroups = {};

    // Agrupar los radios por su atributo name
    form.querySelectorAll('input[type="radio"]').forEach(radio => {
        if (!radioGroups[radio.name]) {
            radioGroups[radio.name] = [];
        }
        radioGroups[radio.name].push(radio);
    });

    let answers = {};
    // Obtener el valor seleccionado de cada grupo
    for (let groupName in radioGroups) {
        let selectedValue;
        radioGroups[groupName].forEach(radio => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });
        answers[groupName] = selectedValue || null;
    }
    return answers;
}

function sendForm(){
    if(!confirm('¿Está seguro de enviar la evaluación?')){
        return;
    }

    if(!document.getElementById('form_send_evaluation').reportValidity())
    {
        return;
    }


    let form = document.createElement('form');
    form.method = 'POST';
    form.action = document.getElementById('form_send_evaluation').action;
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'answers';
    input.value = JSON.stringify(loadAnswers());
    form.appendChild(input);
    let input_csrf = document.createElement('input');
    input_csrf.type = 'hidden';
    input_csrf.name = '_token';
    input_csrf.value = csrf;
    form.appendChild(input_csrf);
    document.body.appendChild(form);
    form.submit();
}