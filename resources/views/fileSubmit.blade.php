<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1500px] mx-auto sm:px-6 lg:px-8">

            <form enctype="multipart/form-data" action="{{route('file.submit')}}" method="POST">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $activity->name }}
                </h2>
                <p class="text-xl text-gray-800 leading-tight">
                    {{ $activity->description }}
                </p>
                <br>


                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="fileInput" name="fileInput" type="file">
                <br>

                <input type="hidden" name="activityId" value="{{$activity->id}}">

                    <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>

                {{csrf_field()}}
            </form>
        </div>

    </div>
</x-app-layout>
