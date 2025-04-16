@php
    $pageProperties = isset($pageProperties) ? base64_encode(serialize($pageProperties)) : null;
    $params = isset($params) ? base64_encode(serialize($params)) : null;
@endphp

<a class="btn btn-secondary" href="{{route('exports.print', ['view_name' => $viewName, 'title' => $title, 'params' => $params, 'pageProperties' => $pageProperties])}}">
    <i class='bx bxs-printer'></i>
</a>