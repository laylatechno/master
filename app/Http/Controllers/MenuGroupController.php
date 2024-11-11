<?php

namespace App\Http\Controllers;

use App\Models\MenuGroup;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class MenuGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:menugroup-list|menugroup-create|menugroup-edit|menugroup-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:menugroup-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:menugroup-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menugroup-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $title = "Halaman Menu Group";
        $subtitle = "Menu Menu Group";
        $data_menu_group = MenuGroup::all();
        return view('menu_group.index', compact('data_menu_group', 'title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Menu Group";
        $subtitle = "Menu Tambah Menu Group";
        $data_permission =  Permission::pluck('name','name')->all();
        return view('menu_group.create', compact('title', 'subtitle','data_permission'));
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
        'name' => 'required|unique:menu_groups,name',
        'permission_name' => 'required',
        'status' => 'required',
        'position' => 'required',
    ], [
        'name.required' => 'Nama wajib diisi.',
        'name.unique' => 'Nama sudah terdaftar.',
        'permission_name.required' => 'Nama Permission wajib diisi.',
        'status.required' => 'Status wajib diisi.',
        'position.required' => 'Urutan wajib diisi.',

    ]);

    MenuGroup::create($request->all());

    return redirect()->route('menu_group.index')
        ->with('success', 'Menu Group berhasil dibuat.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\MenuGroup  $menu_group
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    
    {
        $title = "Halaman Lihat Menu Group";
        $subtitle = "Menu Lihat Menu Group";
        $data_menu_group = MenuGroup::find($id);
        $data_permission =  Permission::pluck('name','name')->all();
        return view('menu_group.show', compact('data_menu_group','title','subtitle','data_permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuGroup  $menu_group
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Menu Group";
        $subtitle = "Menu Edit Menu Group";
        $data_menu_group = MenuGroup::find($id);
        $data_permission =  Permission::pluck('name','name')->all();
        return view('menu_group.edit', compact('data_menu_group','title','subtitle','data_permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuGroup  $menu_group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuGroup $menu_group): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission_name' => 'required',
            'status' => 'required',
            'position' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'permission_name.required' => 'Nama Permission wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'position.required' => 'Urutan wajib diisi.',
    
        ]);

        $menu_group->update($request->all());

        return redirect()->route('menu_group.index')
            ->with('success', 'Menu Group berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuGroup  $menu_group
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuGroup $menu_group): RedirectResponse
    {
        $menu_group->delete();

        return redirect()->route('menu_group.index')
            ->with('success', 'Menu Group berhasil dihapus');
    }
}
