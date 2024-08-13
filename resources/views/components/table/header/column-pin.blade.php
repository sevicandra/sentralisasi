<th @if (!empty($colspan)) colspan="{{ $colspan }}" @endif
    @if (!empty($rowspan)) rowspan="{{ $rowspan }}" @endif
    class="z-10 before:content-[''] before:w-full before:h-[1px] before:bg-neutral-content before:block before:absolute before:top-0 before:left-0
after:content-[''] after:w-full after:h-[1px] after:bg-neutral-content after:block after:absolute after:bottom-0 after:left-0 @if (isset($class)) {{ $class }} @endif
">
    {{ $slot }}
</th>
