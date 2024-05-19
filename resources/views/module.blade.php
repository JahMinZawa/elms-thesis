<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ $module->name }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="py-12">
        <h1 class="block font-sans text-5xl antialiased font-semibold leading-tight tracking-normal text-inherit">
        </h1>
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8 p-5 h-full bg-gray-50 rounded-[10px] shadow-md">

            <br>
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">
                {{ $module->name }}
            </h1>
            <hr class="max-w-[1450px] mx-auto border border-1 border-black mb-4 shadow-md">
            <br>

            <div class="flex flex-col justify-center ml-8">
                @foreach($unlockedLectures as $lecture)
                    <div class="relative flex bg-clip-border rounded-xl bg-gray-100 text-gray-700 shadow-md w-full max-w-[300rem] flex-row mb-10">
                        <div class="relative w-2/5 m-0 overflow-hidden text-gray-700 bg-white rounded-r-none bg-clip-border rounded-xl shrink-0">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1471&amp;q=80" alt="card-image" class="object-cover w-full h-full" />
                        </div>
                        <div class="p-6">
                            <h6 class="block mb-4 font-sans text-base antialiased font-semibold leading-relaxed tracking-normal text-gray-700 uppercase">
                                Lecture
                            </h6>
                            <h4 class="block mb-2 font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                                {{$lecture->name}}
                            </h4>
                            <p class="block mb-8 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
                                {{$lecture->description}}
                            </p>

                            <ul class="list-disc pl-6 mb-12">
                                @foreach($lecture->activities as $activity)
                                    <li class="mb-2">{{$activity->name}}</li>
                                @endforeach
                            </ul>

                            <a href="/lecture/{{$lecture->id}}" class="inline-block"><button class="flex items-center gap-2 px-6 py-3 text-xs font-bold text-gray-900 uppercase transition-all rounded-lg select-none disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none bg-green-500 hover:bg-green-700 active:bg-green-600" type="button">
                                    Learn More<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                   stroke-width="2" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                    </svg></button></a>
                        </div>
                    </div>
                @endforeach


                    @foreach($lockedLectures as $lecture)
                        <div class="relative flex bg-clip-border rounded-xl bg-gray-400 text-gray-700 shadow-md w-full max-w-[300rem] flex-row mb-10"> <!-- Add bg-gray-200 for locked lectures -->
                            <div class="relative w-2/5 m-0 overflow-hidden text-gray-700 bg-white rounded-r-none bg-clip-border rounded-xl shrink-0">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1471&amp;q=80" alt="card-image" class="object-cover w-full h-full" />
                            </div>
                            <div class="p-6">
                                <h6 class="block mb-4 font-sans text-base antialiased font-semibold leading-relaxed tracking-normal text-gray-700 uppercase">
                                    Lesson
                                </h6>
                                <h4 class="block mb-2 font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                                    {{$lecture->name}}
                                </h4>
                                <p class="block mb-8 font-sans text-base antialiased font-normal leading-relaxed text-gray-700">
                                    {{$lecture->description}}
                                </p>
                                <form id="unlock" method="POST" action="{{route('lecture.unlock')}}">
                                    <input type="hidden" name="lectureId" value="{{$lecture->id}}">
                                <a class="inline-block"><button type='submit' class="flex items-center gap-2 px-6 py-3 font-sans text-l font-bold text-center text-gray-800 uppercase align-middle transition-all rounded-lg select-none disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none hover:bg-gray-900/10 active:bg-gray-900/20">
                                        Unlock with coins 100<img src="/coin.png" class="w-5 h-5"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                       stroke-width="2" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                        </svg></button></a>

                                    {{csrf_field()}}
                                </form>
                            </div>
                        </div>
                    @endforeach


            </div>
        </div>
    </div>

    <div id="loading-spinner" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="animate-spin rounded-full h-20 w-20 border-t-2 border-b-2 border-gray-100"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('unlock');
            const loadingSpinner = document.getElementById('loading-spinner');

            form.addEventListener('submit', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Check if the user has enough coins to unlock the lecture
                if ({{ Auth::user()->coins }} < 100) {
                    alert('You do not have enough coins to unlock this lecture.');
                    return;
                }

                // Show loading spinner
                loadingSpinner.classList.remove('hidden');

                // Wait for 1.5 seconds (1500 milliseconds) before submitting the form
                setTimeout(function () {
                    form.submit();
                }, 1500); // Change 1500 to the desired delay in milliseconds
            });
        });
    </script>





</x-app-layout>
