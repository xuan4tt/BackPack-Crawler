@extends('layouts.main')
@section('title', 'exam')
@section('content')

    {{-- <div><span id="time">60:00</span></div> --}}
    
    @livewire('doing', ['exam' => $exam])

    <script>
        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }

        window.onload = function() {
            var fiveMinutes = 90 * 60,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };

    </script>
@endsection
