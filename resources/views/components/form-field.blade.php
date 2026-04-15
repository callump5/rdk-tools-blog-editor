<div>

    <textarea wire:model.live="elementData.{{ $key }}.value" rows="8" style='width:100%'></textarea>
    <div class="data">
        {!! nl2br($data) !!}
    </div>
</div>
