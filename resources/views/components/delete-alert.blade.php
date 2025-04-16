<div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="delete_modal_label">¿Está Seguro de que desea eliminar este registro?</h1>
            </div>
            <form action="" method="POST" class="d-none" id="delete_modal_form">
                @csrf
                @method('DELETE')
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="delete_modal_btn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts2')
<script>
    function deleteFunction(url)
    {
        let form = document.getElementById('delete_modal_form');
        form.action = url;
        form.submit();
    }
    
    function showDeleteModal(url)
    {
        let modal = new bootstrap.Modal(document.getElementById('delete_modal'));
        document.getElementById('delete_modal_btn').onclick = () => deleteFunction(url);
        modal.show();
    }
    
    document.addEventListener('DOMContentLoaded', function domContentLoaded() {
        let deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.onclick = () => showDeleteModal(button.getAttribute('data-url'));
        });
    });
</script>
@endsection