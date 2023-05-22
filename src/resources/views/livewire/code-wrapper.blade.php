
@if ($content)
    <div class="p-2 space-y-2 rounded-xl shadow text-white border-gray-600 bg-gray-800 text-xs overflow-y-scroll">
        <pre>
            {{ $content }}
        </pre>
    </div>
@endif