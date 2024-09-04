<a href="{{ $url }}"
    class="relative hover:scale-110 rounded-box aspect-square h-48 max-w-48 bg-primary grid grid-rows-[1fr_auto] overflow-hidden drop-shadow hover:drop-shadow-lg cursor-pointer border">
    <div class="overflow-hidden p-1 flex justify-center items-center shadow-inner">
        <img src="{{ $icon }}" alt="{{ $name }} icon" class="aspect-square h-full">
    </div>
    <div class="glass text-primary-content p-1">
        <p class="text-center text-lg">{{ $name }}</p>
    </div>
    @if (isset($notif) && $notif > 0)
        <div class="absolute top-1 end-1 badge badge-warning shadow-lg border">{{ $notif }}</div>
    @endif
</a>
