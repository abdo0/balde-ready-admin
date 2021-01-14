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
                                <h3 class="text-primary">Add NAS</h3>
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
                                <form action="{{ route('nas.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                        <label class="small mb-1" for="nas_ip">IP </label>
                                        <input class="form-control" id="nas_ip" name="nas_ip" type="text">
                                    </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="nas_ssh_port">SSH port</label>
                                            <input class="form-control" id="nas_ssh_port" type="number" name="nas_ssh_port" value="22">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="active">Status</label>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" id="active1" type="radio" name="active" value="1">
                                                    <label class="custom-control-label" for="active1">ON</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" id="active2" type="radio" name="active" value="0">
                                                    <label class="custom-control-label" for="active2">OFF</label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1" for="nas_username">username</label>
                                            <input class="form-control" id="nas_username" name="nas_username" type="text">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="small mb-1" for="nas_password">password</label>
                                            <input class="form-control" id="nas_password" name="nas_password" type="text">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="zone_id">Zone</label>
                                            <select class="form-control" id="zone_id" name="zone_id">
                                                @foreach($zones as $zone)
                                                    <option value='{{ $zone->id }}'>{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nas_device_type">Device Type</label>
                                            <select class="form-control" id="nas_device_type" name="nas_device_type">
                                                @foreach($devices as $device)
                                                    <option value='{{ $device->id }}'>{{ $device->name }}</option>
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
