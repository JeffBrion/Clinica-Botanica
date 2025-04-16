document.addEventListener('DOMContentLoaded', function() {
    let selects = document.querySelectorAll('.input_search');
    selects.forEach(select => {
        select.addEventListener('input', function(){
            searchData(this);
        });
    });
});

function searchData(element){
    let prefix = element.dataset.prefix;
    let value = element.value;
    let select = element.dataset.select;

    let url = api_url + prefix + '/search/' + value;


    fetch(url)
        .then(response => response.json())
        .then(data => loadSelect(select, data.data))
        .catch(error => document.getElementById(select).innerHTML = "<option value=''>No se encontraron resultados</option>");
}

function loadSelect(select_id, data){
    let select = document.getElementById(select_id);
    if(select == null){
        return;
    }

    if(data.length == 0){
        select.innerHTML = "<option value=''>No se encontraron resultados</option>";
        return;
    }

    select.innerHTML = "";
    for (var i = 0; i < data.length; i++){
        let option = document.createElement("option");
        option.innerText = data[i].name;
        option.value = data[i].id;
        select.add(option);
    }
}
