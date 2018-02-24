@extends('layouts.app')

@push('style')
<link href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<link href="//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet"/>
<style>
    .form-no-margin {
        margin: 0;
    }
    @media (max-width:992px) {
    .arrow-corporation {
        display:none;
    }
}
</style>
@endpush

@section('content')
    <div class="container">
        <div class="row resources-top clearfix">
            <div class="col-xs-12">
                <h1>
                    @if(session('user')->role)
                    Corporations
                        @else
                        Practices
                        @endif
                </h1>
            </div>
            <div class="latest-vacancies-description col-xs-8">
                <p>
                    Here you can add new Corporations.
                </p>
            </div>
            <div class="col-xs-12">
                <div class="line">
                </div>
            </div>
        </div>
        @if(session('user')->role)
            <div class="row new-list-all">
                <div class="header-meni-create-corp col-md-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 custom-margin-medium">
                            <p class="text-header-corporation">
                                <i aria-hidden="true" class="fa fa-building-o create-corp-icon">
                                </i>
                                Create Corporation
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 custom-display custom-margin-medium">
                            <button class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn custom-margin-phone" data-target="#linkCorporationModal" data-toggle="modal">
                                Link
                            </button>
                            <button class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn custom-margin-right" data-target="#editCorporationModal" data-toggle="modal">
                                Add
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endif
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table cellspacing="0" class="table table-striped table-bordered dt-responsive nowrap" id="corporations-table" width="100%">
                        <thead>
                        <tr>
                            <th class="table-name-data">
                                #
                            </th>
                            <th class="table-name-data">
                                Name
                            </th>
                            @if(session('user') && session('user')->role)
                                <th class="table-name-data date-responsive">
                                    Corp. Creation date
                                </th>
                                <th class="table-name-data">
                                    No. of Practices
                                </th>
                            @else
                                <th class="table-name-data date-responsive">
                                    Practice Creation date
                                </th>
                                <th class="table-name-data">
                                    No. of Employees
                                </th>
                            @endif
                            <th class="table-name-data">
                                Total Revenue
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(session('user') && session('user')->role)
                            @foreach($corporations as $corporation)
                                <tr>
                                    <td class="table-data" data-order="{{ $corporation->id }}" data-search="{{ $corporation->id }}">
                                        {{$corporation->id}}
                                    </td>
                                    <td class="table-data" data-order="{{ $corporation->name }}" data-search="{{ $corporation->name }}">
                                        {{$corporation->name}}
                                    </td>
                                    <td class="table-data" data-order="{{ $corporation->created_at }}" data-search="{{ $corporation->created_at->format('m/d/Y') }}">
                                        {{$corporation->created_at->format('m/d/Y')}}
                                    </td>
                                    <td class="table-data" data-order="{{ $corporation->practices->count() }}" data-search="{{ $corporation->practices->count() }}">
                                        {{$corporation->practices->count()}}
                                    </td>
                                    <td class="table-data" data-order="{{ $corporation->totalEarnings }}" data-search="{{ $corporation->totalEarnings }}">
                                        ${{number_format($corporation->totalEarnings)}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($practices as $practice)
                                <tr>
                                    <td class="table-data" data-order="{{ $practice->id }}" data-search="{{ $practice->id }}">
                                        {{$practice->id}}
                                    </td>
                                    <td class="table-data" data-order="{{ $practice->name }}" data-search="{{ $practice->name }}">
                                        {{$practice->practice_name}}
                                    </td>
                                    <td class="table-data" data-order="{{ $practice->created_at }}" data-search="{{ $practice->created_at->format('m/d/Y') }}">
                                        {{$practice->created_at->format('m/d/Y')}}
                                    </td>
                                    <td class="table-data" data-order="{{ $practice->no_of_staff }}" data-search="{{ $practice->no_of_staff }}">
                                        {{$practice->no_of_staff}}
                                    </td>
                                    <td class="table-data" data-order="{{ $practice->totalEarnings }}" data-search="{{ $practice->totalEarnings }}">
                                        ${{number_format($practice->totalEarnings)}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </br>
    </div>
    <!-- Modal -->
    @if(session('user')->role)
        <div aria-labelledby="editCorporationLabel" class="modal fade" id="editCorporationModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ url('corporation/store') }}" class="form-no-margin" method="post">
                        <div class="modal-header">
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                            </button>
                            <h4 class="modal-title" id="editCorporationLabel">
                                Create corporation form
                            </h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div class="form-group col-md-6 col-xs-12">
                                <label class="col-2 col-form-label" for="example-text-input">
                                    Corporation name
                                </label>
                                <div class="col-10">
                                    <input class="form-control input-create-corp" name="name" placeholder="LocumOD" type="text">
                                    @if ($errors->has('name'))
                                        <p class="alert alert-danger">
                                            {{ $errors->first('name') }}
                                        </p>
                                        @endif
                                        </input>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <label class="col-2 col-form-label" for="example-search-input">
                                    Corporation email
                                </label>
                                <div class="col-10">
                                    <input class="form-control input-create-corp" name="email" placeholder="example@example.com" type="email">
                                    @if ($errors->has('email'))
                                        <p class="alert alert-danger">
                                            {{ $errors->first('email') }}
                                        </p>
                                        @endif
                                        </input>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-success" type="submit">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal For Link-->
        <div aria-labelledby="linkCorporationLabel" class="modal fade" id="linkCorporationModal" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ url('corporation/link') }}" method="post" class="form-no-margin">
                        <div class="modal-header">
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                            </button>
                            <h4 class="modal-title" id="editCorporationLabel">
                                Create practice for corporation
                            </h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div class="form-group col-md-5 col-xs-12">
                                <label for="example-search-input" class="col-2 col-form-label">Practice</label>
                                <div class="col-10">
                                    <select name="practice" class="form-control input-create-corp">
                                        @foreach($freePractices as $freePractice)
                                            <option value="{{ $freePractice->id}}">{{ $freePractice->practice_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 arrow-corporation" style="font-size:50px;text-align:center">=></div>
                            <div class="form-group col-md-5 col-xs-12">
                                <label for="example-text-input" class="col-2 col-form-label">Corporation </label>
                                <div class="col-10">
                                    <select name="corporation" class="form-control input-create-corp">
                                        @foreach($corporations as $corporation)
                                            <option value="{{$corporation->id}}">{{$corporation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-success" type="submit">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript">
</script>
<script src="//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#corporations-table').DataTable();
    });
</script>
@endpush
