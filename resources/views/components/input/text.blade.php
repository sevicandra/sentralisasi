<label class="form-control {{ $size ?? '' }} {{ $class ?? '' }} ">
    <div class="label">
        <span class="label-text">
            {{ $label }}
        </span>
    </div>
    <textarea class="textarea textarea-bordered h-24" placeholder="{{ $placeholder ?? '' }}"
        name="{{ $name }}" @required($required ?? false)>{{ $value ?? '' }}</textarea>
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">
                {{ $message }}
            </span>
        </div>
    @enderror
</label>
