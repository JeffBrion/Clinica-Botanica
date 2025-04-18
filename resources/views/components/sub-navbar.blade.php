<div class="container p-0">
    <ul class="nav nav-tabs flex-row justify-content-end mb-4">
        @isset($links)    
            @foreach ($links as $link)
                <li class="nav-item">
                    <a class="nav-link 
                        @if(array_key_exists('active', $link) && $link['active'] == true) active @endif" 
                        href="{{ Route::has($link['route']) ? route($link['route'], $link['params'] ?? []) : '' }}">
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        @endisset
    </ul>
</div>