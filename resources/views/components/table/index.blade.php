<table
    class="table {{ $size ?? 'table-sm' }}  table-pin-cols overflow-y-auto @if (isset($class)) {{ $class }} @endif ">
    {{ $slot }}
</table>
