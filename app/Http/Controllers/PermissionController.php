<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $title = "Halaman Permission";
        $subtitle = "Menu Permission";
        $data_permission = Permission::all();
        return view('permission.index', compact('data_permission', 'title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Permission";
        $subtitle = "Menu Tambah Permission";
        return view('permission.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
{
    $this->validate($request, [
        'name' => [
            'required',
            Rule::unique('permissions')->where(function ($query) use ($request) {
                return $query->where('guard_name', $request->guard_name);
            }),
        ],
        'guard_name' => 'required',
    ], [
        'name.required' => 'Nama wajib diisi.',
        'name.unique' => 'Nama sudah terdaftar.',
        'guard_name.required' => 'Guard wajib diisi.',
    ]);

    Permission::create($request->all());

    return redirect()->route('permission.index')
        ->with('success', 'Permission berhasil dibuat.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    
    {
        $title = "Halaman Lihat Permission";
        $subtitle = "Menu Lihat Permission";
        $data_permission = Permission::find($id);
        return view('permission.show', compact('data_permission','title','subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Permission";
        $subtitle = "Menu Edit Permission";
        $data_permission = Permission::find($id);
        return view('permission.edit', compact('data_permission','title','subtitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'guard_name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'guard_name.required' => 'Guard wajib diisi.',

        ]);

        $permission->update($request->all());

        return redirect()->route('permission.index')
            ->with('success', 'Permission berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return redirect()->route('permission.index')
            ->with('success', 'Permission berhasil dihapus');
    }
}
