@props([
    'disabled' => false,
    'withicon' => false
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4'
@endphp

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
            'class' => $withiconClasses . ' py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white
           ',
        ])
    !!}
>
