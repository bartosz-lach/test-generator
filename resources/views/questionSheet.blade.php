@extends('layouts.main')

@section('content')
<div>
    <div class="student-info" >
        <div class="name-box">
                <p class="caption">LAST NAME</p>
        </div>
        <div class="name-box">
                <p class="caption">FIRST NAME</p>
        </div>
        <div class="name-box">
                <p class="caption">INDEX NUMBER</p>
        </div>
        <div class="name-box">
                <p class="caption">GROUP</p>
        </div>
    </div>
    
        <table class="questions-table">
                @foreach ($version['content']['questions'] as $index => $q)
                    
                        <tr >
                            <td class="cell-table"><b>{{ $index+1 }}.</b></td>
                            @foreach($q['answers'] as $a)
                                <td class="cell-table">           
                                </td>
                            @endforeach
                        </tr>
                   
                @endforeach
            </table>
</div>

@endsection