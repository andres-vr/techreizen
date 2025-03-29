<form method="post" action="{{ $action ?? '' }}" class="mt-6">
    @csrf
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        <input id="trix-content" type="hidden" name="content" value="{{ $content ?? '' }}">
        <trix-editor input="trix-content" class="trix-content min-h-[300px] bg-white rounded shadow-sm border border-gray-300 p-2"></trix-editor>
        
        <div class="mt-4 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ $submitText ?? 'Submit' }}
            </button>
        </div>
    @endif
</form>