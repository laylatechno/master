<?php

namespace App\Http\Controllers;

use App\Models\MenuGroup;
use App\Models\MenuItem;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:menuitem-list|menuitem-create|menuitem-edit|menuitem-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:menuitem-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:menuitem-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menuitem-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $title = "Halaman Menu Item";
        $subtitle = "Menu Menu Item";
        $data_menu_item = MenuItem::all();
        return view('menu_item.index', compact('data_menu_item', 'title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Menu Item";
        $subtitle = "Menu Tambah Menu Item";
        $data_menu_group = MenuGroup::pluck('name', 'id')->all();
        $data_permission =  Permission::pluck('name', 'id')->all();
        return view('menu_item.create', compact('title', 'subtitle', 'data_permission', 'data_menu_group'));
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
            'name' => 'required|unique:menu_items,name',
            'permission_name' => 'required',
            'status' => 'required',
            'icon' => 'required',
            'route' => 'required',
            'position' => 'required',
            'menu_group_id' => 'required|exists:menu_groups,id', // Validasi ID menu_group
        ], [
            'name.required' => 'Nama wajib diisi.',
            'icon.required' => 'Icon wajib diisi.',
            'route.required' => 'Route wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
            'permission_name.required' => 'Nama Permission wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'position.required' => 'Urutan wajib diisi.',
            'menu_group_id.required' => 'Menu Group wajib dipilih.',
            'menu_group_id.exists' => 'Menu Group tidak ditemukan.',
        ]);
    
        // Menyimpan menu item dengan ID menu_group
        MenuItem::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'route' => $request->route,
            'permission_name' => $request->permission_name,
            'status' => $request->status,
            'position' => $request->position,
            'menu_group_id' => $request->menu_group_id, // Menyimpan ID menu_group
        ]);
    
        return redirect()->route('menu_item.index')
            ->with('success', 'Menu Item berhasil dibuat.');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  \App\MenuItem  $menu_item
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Menu Item";
        $subtitle = "Menu Lihat Menu Item";
        $data_menu_item = MenuItem::find($id);
        $data_permission =  Permission::pluck('name', 'name')->all();
        $data_menu_group =  MenuGroup::pluck('name', 'id')->all();
        return view('menu_item.show', compact('data_menu_item', 'title', 'subtitle', 'data_permission', 'data_menu_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuItem  $menu_item
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Menu Item";
        $subtitle = "Menu Edit Menu Item";
        $data_menu_item = MenuItem::findOrFail($id); // Menggunakan findOrFail untuk memastikan data ditemukan
        $data_permission = Permission::pluck('name', 'name')->all();
        $data_menu_group = MenuGroup::pluck('name', 'id')->all(); // Mengambil nama dan id menu_group untuk dropdown
        
        return view('menu_item.edit', compact('data_menu_item', 'title', 'subtitle', 'data_permission', 'data_menu_group'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuItem  $menu_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menu_item): RedirectResponse
    {
        // Validasi data yang diterima
        $this->validate($request, [
            'name' => 'required|unique:menu_items,name,' . $menu_item->id, // Pastikan nama unik kecuali untuk menu yang sedang diupdate
            'permission_name' => 'required',
            'status' => 'required',
            'icon' => 'required',
            'route' => 'required',
            'position' => 'required|integer',  // Validasi untuk urutan
            'menu_group_id' => 'required|exists:menu_groups,id', // Validasi ID menu_group
        ], [
            'name.required' => 'Nama wajib diisi.',
            'icon.required' => 'Icon wajib diisi.',
            'route.required' => 'Route wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
            'permission_name.required' => 'Nama Permission wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'position.required' => 'Urutan wajib diisi.',
            'menu_group_id.required' => 'Menu Group wajib dipilih.',
            'menu_group_id.exists' => 'Menu Group tidak ditemukan.',
        ]);
    
        // Update menu item dengan data yang diterima
        $menu_item->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'route' => $request->route,
            'permission_name' => $request->permission_name,
            'status' => $request->status,
            'position' => $request->position,
            'menu_group_id' => $request->menu_group_id, // Menyimpan ID menu_group
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('menu_item.index')
            ->with('success', 'Menu Item berhasil diperbaharui');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuItem  $menu_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menu_item): RedirectResponse
    {
        $menu_item->delete();

        return redirect()->route('menu_item.index')
            ->with('success', 'Menu Item berhasil dihapus');
    }
}
