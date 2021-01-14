@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        {{--<h1 class="h3 mb-2 text-gray-800">Tables</h1>--}}
        {{--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>--}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">NAS List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="dataTable_length">
                                    <button class="btn btn-sm btn-primary" type="button" onclick="window.location.href='{{ route('nas.create') }}'">Add NAS</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="dataTable_filter" class="dataTables_filter">
                                    <form action="{{ route('nas.search') }}" method="POST">
                                        @csrf
                                    <label>Search: <input type="search" name="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                    </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 130px;">ip</th>
                                        <th style="width: 100px;">username</th>
                                        <th>password</th>
                                        <th>SSH port</th>
                                        <th>type</th>
                                        <th>ping</th>
                                        <th>zone</th>
                                        <th>status</th>
                                        <th></th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($nass as $nas)
                                        <tr role="row" class="odd">
                                            <td>{{ $nas->nas_ip }}</td>
                                            <td>{{ $nas->nas_username }}</td>
                                            <td>{{ $nas->nas_password }}</td>
                                            <td>{{ $nas->nas_ssh_port }}</td>
                                            <td>{{ $nas->nasDevice->name }}</td>
                                            <td style="color: green">{{ $nas->ping_time }} ms</td>
                                            <td>{{ $nas->zoneName->name }}</td>
                                            <td>
                                                @if($nas->active)
                                                    <div class="badge badge-primary badge-pill">UP</div>
                                                @else
                                                    <div class="badge badge-danger badge-pill">DOWN</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <form action="{{ route('nas.destroy',$nas) }}" method="POST"  style="margin-left: 5px">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure!')"><i class="fas fa-fw fa-trash"></i></button>
                                                    </form>
                                                    <a class="btn btn-xs btn-info" href="{{ route('nas.show', [$nas]) }}" style="margin-left: 5px"><i class="fas fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-xs btn-primary" href="{{ route('nas.edit', [$nas]) }}" style="margin-left: 5px"><i class="fas fa-fw fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                {{--<div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Showing {{ $nass->from() }} to {{ $nass->to() }} of {{ $nass->total() }} entries</div>--}}
                            </div>
                            <div class="col-sm-12 col-md-7">
                                {{--<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">--}}
                                    {{--<ul class="pagination">--}}
                                        {{--<li class="paginate_button page-item previous disabled" id="dataTable_previous">--}}
                                            {{--<a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="paginate_button page-item active"><a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>--}}
                                        {{--<li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>--}}
                                        {{--<li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>--}}
                                        {{--<li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>--}}
                                        {{--<li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>--}}
                                        {{--<li class="paginate_button page-item next" id="dataTable_next">--}}
                                            {{--<a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                                {{ $nass->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection
