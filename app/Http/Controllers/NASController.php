<?php

namespace App\Http\Controllers;

use App\NAS;
use App\NASDevice;
use App\NASZone;
use App\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class NASController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $data = NAS::with('zoneName', 'nasDevice')->paginate(10);
        return view('portal.nas.index')->with('nass', $data);
    }

    /**
     * Display a listing of searched resource.
     *
     * @param Request $request
     * @return View
     */
    public function indexSearch(Request $request)
    {
        $search = $request->get('search');
        $data = NAS::with('zoneName', 'nasDevice')->whereRaw('nas_ip like "%'.$search.'%"')
            ->paginate(10);
        return view('portal.nas.index')->with('nas', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $zone = NASZone::select('id', 'name')->where('active',1)->get();
        $device = NASDevice::get();
        return view('portal.nas.create')->with('zones', $zone)->with('devices',$device);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nas_ip'=>'required',
//            'nas_username'=>'required',
//            'nas_password'=>'required',
        ]);

        $default_username = Setting::where('key','nas_default_username')->first();
        $default_password = Setting::where('key','nas_default_password')->first();

        $data = new NAS([
            'nas_ip'    => $request->get('nas_ip'),
            'nas_username'    => $request->get('nas_username') ? $request->get('nas_username') : $default_username->value,
            'nas_password'    => $request->get('nas_password') ? $request->get('nas_password') : $default_password->value,
            'nas_device_type'    => $request->get('nas_device_type'),
            'check_reach'    => $request->get('check_reach'),
            'zone_id'    => $request->get('zone_id'),
            'active'    => $request->get('active')
        ]);

        $data->save();
        return redirect('/nas');
    }

    /**
     * Display the specified resource.
     *
     * @param  NAS  $nas
     * @return View
     */
    public function show(NAS $nas)
    {
        $nas = NAS::with('zoneName', 'nasDevice')->where('id', $nas->id)->first();
        return view('portal.nas.view')->with('nas', $nas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NAS  $nas
     * @return View
     */
    public function edit(NAS $nas)
    {
        $zone = NASZone::select('id', 'name')->where('active',1)->get();
        $device = NASDevice::get();
        return view('portal.nas.edit')->with('nas', $nas)->with('zones', $zone)->with('devices', $device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  NAS  $nas
     * @return RedirectResponse
     */
    public function update(Request $request, $nas)
    {
        $request->validate([
            'nas_ip'=>'required',
            'nas_username'=>'required',
            'nas_password'=>'required',
        ]);

        $data = NAS::find($nas);
        $data->nas_ip = $request->get('nas_ip');
        $data->nas_username = $request->get('nas_username');
        $data->nas_password = $request->get('nas_password');
        $data->nas_device_type = $request->get('nas_device_type');
        $data->check_reach = $request->get('check_reach');
        $data->zone_id = $request->get('zone_id');
        $data->active = $request->get('active');

        $data->update();
        return redirect('/nas/'.$data->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  NAS  $nas
     * @return RedirectResponse
     */
    public function destroy(NAS $nas)
    {
        $nas->delete();
        return redirect('/nas');
    }
}
