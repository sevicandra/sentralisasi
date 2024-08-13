<label class="form-control {{ $size ?? '' }} {{ $class ?? '' }}">
    <div class="label">
        <span class="label-text">
            {{ $label }}
        </span>
    </div>
    <input type="file" class="file-input file-input-sm file-input-bordered w-full" name="{{ $name }}" @required($required ?? false) accept="{{ $accept ?? '' }}" />
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">
                {{ $message }}
            </span>
        </div>
    @enderror
</label>
