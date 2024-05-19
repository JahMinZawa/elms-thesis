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
                @foreach($questions as $index => $question)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5">
                        <h2 class="m-5 font-semibold text-xl text-gray-800 leading-tight">
                            Question {{$index+1}}:
                        </h2>
                        <div class="p-6 text-gray-900 mt-1">
                            <div>
                                <!-- Replace only one occurrence of "___" -->
                                <div>
                                    {!! str_replace('___', '<input type="text" name="answers['.$index.'][]" id="answer_' . $index . '" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:border-green-500 w-20 sm:w-auto" />', $question->question) !!}
                                </div>
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
