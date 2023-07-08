@extends('admin.layout.layout')


@section('content')
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <form action="{{route('search.trip')}}" method="POST">
                        @csrf
                        <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="bus-name" class="col-form-label">From:</label>
                                        <select name="from" id="from" class="select2 form-control" style="width: 100%">
                                            <option value="">Select One</option>
                                            @foreach($stoppages as $stoppage)
                                                <option value="{{$stoppage->id}}">{{$stoppage->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="bus-name" class="col-form-label">To:</label>
                                        <select name="to" id="to" class="select2 form-control" style="width: 100%">
                                            <option value="">Select One</option>
                                            @foreach($stoppages as $stoppage)
                                                <option value="{{$stoppage->id}}">{{$stoppage->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                        <br/>
                                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>


@endsection


@push('js')
        <script>
        function matchStart(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        // Skip if there is no 'children' property
        if (typeof data.children === 'undefined') {
            return null;
        }

        // `data.children` contains the actual options that we are matching against
        var filteredChildren = [];
        $.each(data.children, function (idx, child) {
            if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            filteredChildren.push(child);
            }
        });

        // If we matched any of the timezone group's children, then set the matched children on the group
        // and return the group object
        if (filteredChildren.length) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.children = filteredChildren;

            // You can return modified objects from here
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
        }

        $("#from").select2({
            matcher: matchStart
        });
        $("#to").select2({
            matcher: matchStart
        });
    </script>
@endpush