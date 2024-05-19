<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8">
            <div class="mb-1 text-base font-medium dark:text-white">Time: <span id="time">0</span></div>
            <div id="progressBar" class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full"></div>
            </div>

            <form id="quizForm" method="post" action="{{ route('quiz.submit') }}">
                @foreach($questions as $question)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5">
                        <div class="p-6 text-gray-900 mt-1">
                            <h1>{{$question->question}}</h1>
                            <div class="mt-4">
                                @foreach($question->choices as $choice)
                                    <div class="flex items-center">
                                        <input id="default-radio-{{$question->id}}-{{$loop->index + 1}}" type="radio" value="{{$choice->choice}}" name="answers[{{$question->id}}]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-{{$question->id}}-{{$loop->index + 1}}" class="ml-2 text-sm font-medium text-gray-900 dark:text-black">{{$choice->choice}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <br>
                <input type="hidden" name="activityId" value="{{$activity->id}}">
                <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>
                {{csrf_field()}}
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    // Retrieve time limit from PHP variable
    const timeLimitMinutes = {{$activity->time}};

    // Calculate time limit in milliseconds
    const timeLimitMs = timeLimitMinutes * 60 * 1000;

    // Get the form element
    const quizForm = document.getElementById('quizForm');

    // Get the progress bar element
    const progressBar = document.querySelector('#progressBar > div');

    // Function to submit the form
    function submitForm() {
        quizForm.submit();
    }

    // Start the countdown timer
    function startTimer() {
        let timeLeftMs = timeLimitMs;
        const timerElement = document.getElementById('time');

        // Update timer every second
        const timerInterval = setInterval(() => {
            // Calculate remaining minutes and seconds
            const minutes = Math.floor(timeLeftMs / 60000);
            const seconds = Math.floor((timeLeftMs % 60000) / 1000);

            // Update timer display
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            // Calculate the percentage of time remaining
            const percentageRemaining = (timeLeftMs / timeLimitMs) * 100;

            // Set the width of the progress bar
            progressBar.style.width = `${percentageRemaining}%`;

            // Subtract one second from remaining time
            timeLeftMs -= 1000;

            // If time is up, submit the form and stop the timer
            if (timeLeftMs < 0) {
                clearInterval(timerInterval);
                submitForm();
            }
        }, 1000);
    }

    // Start the timer when the page loads
    window.onload = startTimer;
</script>
