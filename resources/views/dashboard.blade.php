<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="py-12">
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8">

{{--            Carousel--}}
            <div class="bg-gray-50 overflow-hidden shadow sm:rounded-lg p-5">
                <h2 class="text-4xl dark:text-white">Welcome {{$user->name}}!</h2>
                <br><hr class="max-w-full mx-auto border border-1 border-black mb-4 shadow-md">
                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-[300px] overflow-hidden rounded-lg md:h-[500px]">
                        <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="/carousel1.jpg" class="absolute block w-full h-full object-cover top-0 left-0" alt="...">
                        </div>
                        <!-- Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="/carousel2.jpg" class="absolute block w-full h-full object-cover top-0 left-0" alt="...">
                        </div>
                        <!-- Item 3 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="/carousel3.jpg" class="absolute block w-full h-full object-cover top-0 left-0" alt="...">
                        </div>
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
                    </button>
                </div>



            </div>
        </div>

        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 mt-5">
            <div class="bg-gray-50 p-5">
                <div class="flex justify-between">
                <h1 class="text-2xl mb-3" >Modules</h1>
                    <a href="/modules" class="text-blue-500 underline antialiased">View All</a>
                </div>
                <hr class="max-w-full mx-auto border border-1 border-black mb-4 shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($modules->take(3) as $module)
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
        </div>

        <div id='calendar' class="max-w-[1438px] max-h-[800px] mx-auto sm:px-6 lg:px-8 mt-5 bg-gray-100 rounded-[10px] shadow">

        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Get the tasks data from PHP and convert it to a JavaScript array
            var tasks = <?php echo json_encode($activities); ?>;
            console.log(tasks);

            // Create an empty array to store the events
            var events = [];

            // Loop through each task and create an event object
            tasks.forEach(function(task) {
                var event = {
                    title: task.name,
                    start: task.deadline,
                    url: '/',
                };
                events.push(event);
            });

            // Initialize the calendar with the events
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events
            });
            calendar.render();
        });


    </script>


</x-app-layout>
