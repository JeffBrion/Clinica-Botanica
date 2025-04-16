<div style="position: fixed; top: 70px; z-index: 101; cursor: pointer;" id="message-alert" onclick="this.remove()">
    <div class="alert alert-danger fade show my-0 mx-2 p-2" role="alert" style="min-width: 300px;">
        <ul class="m-0">
            @foreach($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>