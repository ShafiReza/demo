@extends('layouts.app')

@section('title', 'sales')

@section('content')
<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">

    {{-- <div class="btn-group">


    </div> --}}
    <div class="top10">
        <table class="table table-striped table-hover">
            <thead>

                <tr >
                    <td colspan='5'>
                        @if($generateVisible)
                        <form action="{{ route('sales') }}" method="POST">

                            @csrf
                            <button type="submit" class="btn btn-primary btn-md">
                                <span class="glyphicon glyphicon-plus-sign"></span> Generate
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Date</th>
                    <th>Today Total User Sales</th>
                    <th>Server Sales</th>
                    <th>Today Total User Sales VS Server Sales</th>
                    <th>Day End</th>
                </tr>

            </thead>
            <tbody>

                <form action="{{ route('day_end') }}" method="POST">
                    @csrf
                    @foreach ($salesData as $sale)
                        <tr>
                            @foreach($sale as $s)
                            <td>{{$s['day_start']}}</td>

                            <td>{{$s['sale']}}</td>
                            <td>
                                @if($s['day_end']!=null)
                                    @php $flag=1; @endphp
                                    {{$s['server_sales']}}
                                @else
                                    <input type='hidden' name='id' value="{{$s['id']}}">
                                    <input type='text' name='server_sale' value='0'>
                                @endif
                            </td>
                            <td>{{$s['sale']-$s['server_sales']}}</td>
                            <td>
                                @if($s['day_end']!=null)
                                    {{$s['day_end']}}
                                @else
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Day End
                                    </button>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </form>


            </tbody>
        </table>
    </div>
</div>
@endsection
