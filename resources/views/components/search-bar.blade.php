<div class="col-sm">
    <div class="row d-flex justify-content-start">
        <div class="col-lg-2 d-flex align-items-center">
            <button type="button" class="btn btn-outline-secondary" id="toggle_search_{{$table}}">
                Activar Filtros
            </button>
        </div>
        <div class="col-lg-10">
            <div class="search-bar-fields" id="search_bar_fields_{{$table}}" style="display: none;">
                <div class="row">
                    <div class="col-lg-5 d-flex">
                        <div class="input-group mb-3 d-flex justify-content-start">
                            <select type="search" class="form-select search_select" id="search_select_{{$table}}" placeholder="Buscar" name="search_select_{{$table}}" data-table="{{$table}}"></select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group mb-3 d-flex justify-content-start">
                            <input class="form-control search_input" id="search_input_{{$table}}" name="search_input_{{$table}}" data-table="{{$table}}">
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="input-group mb-3 d-flex justify-content-start">
                            <button type="button" class="btn btn-outline-success clear_button" id="clear_button_{{$table}}" data-table="{{$table}}">Limpiar</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle_search_{{$table}}');
        const searchFields = document.getElementById('search_bar_fields_{{$table}}');
        if (toggleBtn && searchFields) {
            toggleBtn.addEventListener('click', function() {
                if (searchFields.style.display === 'none') {
                    searchFields.style.display = '';
                } else {
                    searchFields.style.display = 'none';
                }
            });
        }
    });
</script>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.clear_button').forEach(btn => {
            btn.addEventListener('click', function() {
                clear(btn.dataset.table);
            });
        });

        document.querySelectorAll('.search_input,.search_select').forEach(input => {
            input.addEventListener('keyup', function() {
                search(input.dataset.table);
            });
        });

        document.querySelectorAll('.search_select').forEach(input => {
            loadFiels(input, input.dataset.table);
        });
    });

    function getTableFiels(t){
        let fields = [];
        let table = document.getElementById(t);
        let headers = table.getElementsByTagName("th");
        for (let i = 0; i < headers.length; i++) {
            if(headers[i].innerText == "Opciones") continue;
            fields.push(headers[i].innerText);
        }
        return fields;
    }

    function loadFiels(s, table){
        let fields = getTableFiels(table);
        let select = s;
        for (let i = 0; i < fields.length; i++) {
            let option = document.createElement("option");
            option.text = fields[i];
            option.value = fields[i];
            select.add(option);
        }
    }

    function search(t){
        let input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search_input_"+t);
        filter = input.value.toUpperCase();
        table = document.getElementById(t);
        tr = table.getElementsByTagName("tr");
        let index = document.getElementById("search_select_"+t).selectedIndex;
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[index];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function clear(t){
        let table = document.getElementById(t);
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            tr[i].style.display = "";
        }
    }
</script>
@endpush
@endonce
