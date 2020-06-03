@extends('layouts.main')

@section('content')

<table>
        @foreach ($version['content']['questions'] as $index => $q)
            
                <tr>
                    <td class="cell-table"><b>{{ $index+1 }}.</b></td>
                    @foreach($q['answers'] as $a)
                        
                            <td class="cell-table" >
                                @if($a['is_true'] == false)
                                    <div class="cell-table false-answer"></div>
                                @else
                                    <div class="cell-table true-answer"></div>
                                @endif
                            </td>
                        
                    @endforeach
                </tr>                          
        @endforeach
    </table>

@endsection