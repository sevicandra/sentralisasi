<label class="form-control {{ $size ?? '' }} {{ $class ?? '' }} ">
    <div class="label">
        <span class="label-text">
            {{ $label }}
        </span>
    </div>
    <input type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? '' }}" class="input input-sm input-bordered w-full"
        value="{{ $value ?? '' }}" name="{{ $name }}" @required($required ?? false) />
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">
                {{ $message }}
            </span>
        </div>
    @enderror
</label>
