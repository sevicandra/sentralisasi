<label class="form-control {{ $size ?? '' }} {{ $class ?? '' }}">
    <div class="label">
        <span class="label-text">{{ $label }}</span>
    </div>
    <select class="select select-sm select-bordered" {{ $attributes }} name="{{ $name }}">
        {{ $slot }}
    </select>
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">
                {{ $message }}
            </span>
        </div>
    @enderror
</label>
