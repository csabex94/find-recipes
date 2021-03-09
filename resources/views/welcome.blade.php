<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href={{ asset('css/app.css') }} >   
        @livewireStyles     
    </head>
    <body>
        <div  class="flex items-center justify-center w-screen h-screen bg-gradient-to-br from-purple-900 to-indigo-500">
            <div class="w-9/12 bg-white shadow-md rounded-xl wrapper">
                <h2>Find Recepies</h2>

                {{-- AutoComplete Component --}}
                @livewire('auto-complete-handler')

            </div>
        </div>
        @livewireScripts
    </body>
</html>
