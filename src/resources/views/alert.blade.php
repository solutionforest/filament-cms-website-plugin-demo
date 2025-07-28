@php
    $type = $type ?? 'info';
    $config = [
        'info' => [
            'bg' => 'bg-blue-100',
            'border' => 'border-blue-400',
            'text' => 'text-blue-700',
            'icon' => 'heroicon-o-information-circle',
        ],
        'danger' => [
            'bg' => 'bg-red-100',
            'border' => 'border-red-400',
            'text' => 'text-red-700',
            'icon' => 'heroicon-o-x-circle',
        ],
        'warning' => [
            'bg' => 'bg-yellow-100',
            'border' => 'border-yellow-400',
            'text' => 'text-yellow-700',
            'icon' => 'heroicon-o-exclamation-triangle',
        ]
    ];
    $currentConfig = $config[$type];
@endphp

<div role="alert" @class([
    'border px-4 py-3 rounded relative flex items-start mt-4',
    $currentConfig['bg'],
    $currentConfig['border'],
    $currentConfig['text'],
])>
    <div class="flex-shrink-0">
        @svg($currentConfig['icon'], [
            'class' => 'w-5 h-5 mr-2',
            'stroke' => 'currentColor'
        ])
    </div>
    <div class="flex-1">
        <span class="block sm:inline ml-1">{{ $message ?? 'This is an alert message.' }}</span>
    </div>
</div>