<th @if (!empty($colspan)) colspan="{{ $colspan }}" @endif
    @if (!empty($rowspan)) rowspan="{{ $rowspan }}" @endif class="@if (isset($class)) {{ $class }} @endif">
    {{ $slot }}
</th>
