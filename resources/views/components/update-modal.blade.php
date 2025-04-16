@props(['modal_id' => 'update_modal', 'fields' => []])

<div class="modal fade" id="{{$modal_id}}" tabindex="-1" aria-labelledby="update_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="update_modal_label">Actualizar Registro</h1>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="{{$modal_id}}_form" autocomplete="off">
                    @isset($fields)
                        @foreach ($fields as $field)
                            @if($field['type'] == 'hidden')
                                <input type="hidden" name="{{$field['name']}}" id="{{$field['name']}}" value="{{$field['value']}}">
                                @continue
                            @endif
                            @if($field['type'] == 'select')
                                <div class="form-group">
                                    <label for="{{$field['name']}}">{{$field['label']}}</label>
                                    <select name="{{$field['name']}}" id="{{$field['name']}}" class="form-control" @if($field['required']) required @endif>
                                        @foreach($field['options'] as $option)
                                            <option value="{{$option['value']}}">{{$option['label']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @continue
                            @endif
                            <div class="form-group">
                                <label for="{{$field['name']}}">{{$field['label']}}</label>
                                <input type="{{$field['type']}}" name="{{$field['name']}}" id="{{$field['name']}}" class="form-control" value="" @if($field['required']) required @endif>
                            </div>
                        @endforeach
                    @endisset
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="{{$modal_id}}_form" class="btn btn-primary" id="update_modal_btn">Actualizar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts3')
<script>
    
    function showUpdateModal(url, jsonstring, modal_id = 'update_modal')
    {
        let modal = new bootstrap.Modal(document.getElementById(modal_id));
        let form = document.getElementById(modal_id + '_form');
        form.action = url;

        let data = JSON.parse(jsonstring);
        let fields = form.querySelectorAll('input:not([name="_method"]):not([name="_token"])');
        fields.forEach(field => {
            field.value = data[field.name];
        });

        let token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{csrf_token()}}';

        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';

        let selects = form.querySelectorAll('select');
        selects.forEach(select => {
            //seleccionar la opción que corresponde al valor del campo
            let options = select.querySelectorAll('option');
            options.forEach(option => {
                if(option.value == data[select.name])
                {
                    option.selected = true;
                }
            });
        });

        form.appendChild(token);
        form.appendChild(method);

        modal.show();
    }
    
    document.addEventListener('DOMContentLoaded', function domContentLoaded() {
        let deleteButtons = document.querySelectorAll('.update-button');
        deleteButtons.forEach(button => {
            button.onclick = () => showUpdateModal(button.getAttribute('data-url'), button.getAttribute('data-json-string'), button.getAttribute('data-modal-id') || 'update_modal');
        });
    });
</script>
@endsection