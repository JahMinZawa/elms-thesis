<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8">

            <form id="activityForm" action="@if($activity->type == 'Quiz')
                /quiz/{{$activity->id}}
                @elseif($activity->type == "Fill in the blanks")
                /fillBlanks/{{$activity->id}}
                @elseif($activity->type == "FileSubmission")
                /fileSubmit/{{$activity->id}}
                @endif">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $activity->name }}
                </h2>
                <p class="text-xl text-gray-800 leading-tight">
                    {{ $activity->description }}
                </p>
                <br>

                <div class="mx-auto sm:px-6 lg:px-8">
                    <h2 class="text-xl text-gray-800 leading-tight"><strong>Instruction:</strong> {{$activity->instruction}}</h2>
                </div>

                <div class="mx-auto sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attempts: {{$activity->count_attempts($user->id)}}</h2>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">Score: {{$activity->score($user->id)}}</h2>
                </div>

                @php
                    $adjustedTime = time() + (8 * 3600); // Add 8 hours (28800 seconds)
                @endphp

                @if($activity->count_attempts($user->id) < $activity->attemptLimit && strtotime($activity->deadline) > $adjustedTime)
                    <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Take Activity</button>
                @endif

            </form>

            @if($activity->count_attempts($user->id) >= $activity->attemptLimit || strtotime($activity->deadline) < $adjustedTime)
                <form id="unlockForm" method="POST" action="{{route('activity.attempt')}}">
                    <input type="hidden" name="activityId" value="{{$activity->id}}">
                    <a class="inline-block">
                        <button type='submit' class="flex items-center gap-2 px-6 py-3 font-sans text-l font-bold text-center text-gray-800 uppercase align-middle transition-all rounded-lg select-none disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none hover:bg-gray-900/10 active:bg-gray-900/20">
                            Unlock with coins 100<img src="/coin.png" class="w-5 h-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </button>
                    </a>
                    {{csrf_field()}}
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
