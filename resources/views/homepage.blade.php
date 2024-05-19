<x-app-layout>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Modules') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="max-w-[1500px] mx-auto py-12">
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 p-5 h-full bg-gray-50 rounded-[10px] shadow-md ">

            <div>
            <br>
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Your Modules</h1>
            <hr class="max-w-[1450px] mx-auto border border-1 border-black mb-4 shadow-md">
            <br>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($modules as $module)
                    <div class="relative bg-gray-100 text-gray-700 shadow-md rounded-xl overflow-hidden">
                        <div class="relative w-full h-60 md:h-40 lg:h-56 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1471&amp;q=80" alt="card-image" class="object-cover w-full h-full" />
                        </div>
                        <div class="p-6">
                            <h6 class="mb-4 text-base font-semibold text-gray-700 uppercase">Module</h6>
                            <h4 class="mb-2 text-xl font-semibold text-blue-gray-900">{{$module->name}}</h4>
                            <p class="mb-4 text-sm text-gray-700">{{$module->description}}</p>
                            <a href="/modules/{{$module->id}}" class="inline-block">
                                <button class="flex items-center gap-2 px-6 py-3 text-xs font-bold text-gray-900 uppercase transition-all rounded-lg select-none disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none bg-green-500 hover:bg-green-700 active:bg-green-600" type="button">
                                    Learn More
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>


        <div class="md:flex mx-auto justify-center">

            <div id='calendar' class="flex-grow max-w-[1150px] max-h-[800px] mx-auto sm:px-6 lg:px-8 mt-5 bg-gray-100 rounded-[10px] shadow"></div>



            <div class="w-full sm:w-[330px] h-full rounded-[10px] shadow-md mt-5 ml-5">
                <div class="h-full max-w-[450px] bg-green-700 p-4 shadow-md rounded-lg">
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
                                    <script>
                                        var tasks = <?php echo json_encode($activities); ?>;
                                    </script>
                                @endforeach
                    </ul>
                </div>
            </div>

    </div>

        <script>

            document.addEventListener('DOMContentLoaded', function() {
                // Get the tasks data from PHP and convert it to a JavaScript array
                console.log(tasks);

                // Create an empty array to store the events
                var events = [];

                // Loop through each task and create an event object
                tasks.forEach(function(task) {
                    var event = {
                        title: task.name,
                        start: task.deadline,
                        url: '/activity/' + task.id,
                    };
                    events.push(event);
                });

                // Initialize the calendar with the events
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    events: events,
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay' // user can switch between the two
                    },
                    slotEventOverlap: false,
                });
                calendar.render();
            });


        </script>
</x-app-layout>

