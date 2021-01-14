@extends('layouts.app')

@section('content')

    <div class="container mt-n10">
        <!-- Wizard card example with navigation-->
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <!-- Wizard tab pane item 1-->
                    <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel" aria-labelledby="wizard1-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <h3 class="text-primary">معلومات المنتج</h3>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form  method="post" action="{{ route('nas.update', $nas->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="nas_ip">IP </label>
                                            <input class="form-control" id="nas_ip" name="nas_ip" type="text" value="{{ $nas->nas_ip }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="nas_ssh_port">SSH port</label>
                                            <input class="form-control" id="nas_ssh_port" type="number" name="nas_ssh_port" value="{{ $nas->nas_ssh_port }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="active">Status</label>
                                            <select class="form-control" id="active" name="active">
                                                <option value="1" {{ $nas->active == 1 ? 'selected="selected"' : '' }}>Up</option>
                                                <option value="0" {{ $nas->active == 0 ? 'selected="selected"' : '' }}>Down</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1" for="nas_username">username</label>
                                            <input class="form-control" id="nas_username" name="nas_username" type="text" value="{{ $nas->nas_username }}" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1" for="nas_password">password</label>
                                            <input class="form-control" id="nas_password" name="nas_password" type="text" value="{{ $nas->nas_password }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="zone_id">Zone</label>
                                            <select class="form-control" id="zone_id" name="zone_id">
                                                @foreach($zones as $zone)
                                                    <option value='{{ $zone->id }}' {{ $nas->zone_id == $zone->id ? 'selected="selected"' : '' }}>{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nas_device_type">Device Type</label>
                                            <select class="form-control" id="nas_device_type" name="nas_device_type">
                                                <@foreach($devices as $device)
                                                    <option value='{{ $device->id }}' {{ $nas->nas_device_type == $device->id ? 'selected="selected"' : '' }}>{{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-dark" type="button" onclick="window.location.href='/nas'">Back to NAS</button>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
