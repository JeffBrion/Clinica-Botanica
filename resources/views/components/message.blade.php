<div style="position: fixed; top: 70px; z-index: 101; cursor: pointer;" id="message-alert" onclick="this.remove()">
    <div class="alert alert-{{$color}} fade show my-0 mx-2 p-2" role="alert" style="min-width: 300px;">
        <strong>{{ $message }}</strong>
    </div>
</div>