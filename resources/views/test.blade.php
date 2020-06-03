@extends('layouts.main')

@section('content')

        <ol>
            @foreach ($version['content']['questions'] as $q)
                <li class="question"><b>{{ $q['content'] }}</b> </bt>
                    <ol type="a">
                        @foreach($q['answers'] as $a)
                        <li> {{ $a['content'] }}</li>
                        @endforeach
                    </ol>
                </li>
            @endforeach
        </ol>

@endsection

