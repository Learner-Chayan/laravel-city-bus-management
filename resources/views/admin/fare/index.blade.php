@extends('admin.layout.layout')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="">

                        <form  action="" method="GET">
                            <div class="row">
                                <div class="col-4 offset-2">
                                    <div class="form-group">
                                        <select name="route" class="form-control">
                                            <option value="">Selct One</option>
                                            @foreach($routes as $route)
                                                <option value="{{$route->id}}">{{$route->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="">
                        @if(isset($selected_route))
                            <form action="{{route('fare.update')}}" method="POST" >

                                @php
                                $stoppages = json_decode($selected_route->stoppage_id);
                                $i = 0;
                                @endphp

                                <input type="hidden" name="route_id" value="{{$selected_route->id}}">
                                @csrf
                                <table class="table table-striped">
                                    @foreach($stoppages as $stoppage)


                                        @if($i < 1)
                                        <tr>
                                            <td></td>
                                            @foreach($stoppages as $stoppage2)

                                                    <td>
                                                        {{ $stoppages_arr[$stoppage2] }}
                                                    </td>
                                            @endforeach
                                        </tr>
                                        @endif
                                        @php
                                            $i++
                                        @endphp

                                        <tr>
                                            <td> {{ $stoppages_arr[$stoppage] }}</td>
                                            @foreach($stoppages as $stoppage2)
                                                <td>

                                                    <input class="form-control" type="text" name="fare_{{$selected_route->id}}_{{$stoppage}}_{{$stoppage2}}"
                                                   @if($stoppage == $stoppage2) value="0" readonly
                                                    @else(count($price_arr))
                                                     value="<?php echo  $price_arr ? $price_arr['fare_'.$selected_route->id.'_'.$stoppage.'_'.$stoppage2] : '' ?>"
                                                      @endif

                                                    >
                                                </td>
                                            @endforeach
                                        </tr>

                                    @endforeach
                                </table>

                                <button type="submit" class="btn btn-success ">Submit</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
