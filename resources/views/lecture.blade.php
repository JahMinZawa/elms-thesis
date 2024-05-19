<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Lecture
            </h2>

            <div>
                @php
                    // Get the ID of the current lecture
                    $currentLectureId = $lecture->id;
                    // Initialize variables for storing indices
                    $currentIndex = null;
                    $previousIndex = null;
                    $nextIndex = null;

                    // Finding the current lecture's index
                    foreach ($lectures as $index => $lecture) {
                        // Check if the current lecture ID matches the current lecture in the loop
                        if ($lecture->id == $currentLectureId) {
                            // If found, store the index and break the loop
                            $currentIndex = $index;
                            break;
                        }
                    }

                    // Calculating previous and next indices
                    if ($currentIndex !== null) {
                        // Calculate the index of the previous lecture, ensuring it doesn't go out of bounds
                        $previousIndex = max($currentIndex - 1, 0);
                        // Calculate the index of the next lecture, ensuring it doesn't go out of bounds
                        $nextIndex = min($currentIndex + 1, count($lectures) - 1);
                    }
                @endphp

                @if($previousIndex !== null)
                    <!-- Render the "Previous" link if there is a previous lecture -->
                    <a href="/lecture/{{$lectures[$previousIndex]->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Previous</a>
                @endif

                @if($nextIndex !== null)
                    <!-- Render the "Next" link if there is a next lecture -->
                    <a href="/lecture/{{$lectures[$nextIndex]->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-5">Next</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 p-10">

        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 p-5 h-full bg-gray-50 rounded-[10px] shadow-md">
            <h1 class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-black">
                {{ $lecture->name }}
            </h1>
        <br>
        <hr class="max-w-[1450px] mx-auto border border-1 border-black mb-4 shadow-md">
        <br>

            <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 flex">
                <div class="w-3/4">
                    <div class="flex flex-col justify-center items-center">
                        <iframe class="w-full h-[600px]" src="{{asset('/storage/' . $lecture->file)}}" allowfullscreen allow="autoplay"></iframe>
                    </div>
                </div>

                <div class="w-1/4 h-full bg-green-700 p-4 ml-5 shadow-md rounded-lg">
                    <!-- Sidebar content goes here -->
                    <div class="flex justify-between mb-4">
                        <h3 class="font-semibold text-lg text-white">Activities</h3>
                        <a href="#" class="text-sm text-blue-500 underline">More</a>
                    </div>

                    <ul class="bg-white shadow-md rounded-lg">
                        @foreach($activities as $activity)
                            <li class="flex items-center justify-between p-5 hover:bg-gray-50 shadow-md rounded-lg">
                                <a href="/activity/{{$activity->id}}" class="flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700 hover:underline">
                                    @if($activity->count_attempts($user->id) > 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path d="M5.5 10.5L8 13l6-6" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path d="M6 6l8 8m0-8l-8 8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                    {{$activity->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 mt-8">
                <div class="block font-sans text-xl antialiased font-normal leading-relaxed text-inherit max-w-[1500px] break-words">
                    {!! $lecture->content !!}
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
