@extends('layouts.app')

@push('style')
<link href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<link href="//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet"/>
<style>
    .form-no-margin {
        margin: 0;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="row resources-top clearfix">
            <div class="col-xs-12">
                <h1>
                    Invoices
                </h1>
            </div>
            <div class="latest-vacancies-description col-xs-8">
                <p>
                    Here you can see Corporation's invoices.
                </p>
            </div>
            <div class="col-xs-12">
                <div class="line">
                </div>
            </div>
        </div>
        @if(session('user')->role)
            <div class="row new-list-all">
                <div class="col-md-12">
                    <div class="header-meni-create-corp">
                        <p class="text-header-corporation col-xs-7">
                            <i aria-hidden="true" class="fa fa-building-o create-corp-icon">
                            </i>
                            Create Corporation
                        </p>
                        <button class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn" data-target="#linkCorporationModal" data-toggle="modal">
                            Link
                        </button>
                        <button class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn" data-target="#editCorporationModal" data-toggle="modal">
                            Add
                        </button>

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
                                Invoice date
                            </th>

                            <th class="table-name-data">
                                Invoice
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="table-data" data-order="{{ $invoice->id }}" data-search="{{ $invoice->id }}">
                                        {{$invoice->id}}
                                    </td>

                                    <td class="table-data" data-order="{{ $invoice->created_at }}" data-search="{{ $invoice->created_at->format('m/d/Y') }}">
                                        {{$invoice->created_at->format('m/d/Y')}}
                                    </td>

                                    <td class="table-data" data-order="{{ $invoice->id }}" data-search="{{ $invoice->id }}">
                                        <a target="_blank" href="file/corporation/{{ $invoice->invoice_id }}_invoices.pdf">View</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </br>
    </div>

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
