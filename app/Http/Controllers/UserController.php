<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $title = "Halaman User";
        $subtitle = "Menu User";
        $data_user = User::all();
        return view('users.index',compact('data_user','title','subtitle'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah User";
        $subtitle = "Menu Tambah User";
        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles','title','subtitle'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.same' => 'Password dan konfirmasi password harus sama.',
            'roles.required' => 'Peran wajib dipilih.'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $users = User::create($input);
        $users->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                         ->with('success', 'User berhasil dibuat');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $title = "Halaman Lihat User";
        $subtitle = "Menu Lihat User";
        $data_user = User::find($id);

        return view('users.show',compact('data_user','title','subtitle'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit User";
        $subtitle = "Menu Edit User";
        $data_user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $usersRole = $data_user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('data_user','roles','usersRole','title','subtitle'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.same' => 'Password dan konfirmasi password harus sama.',
            'roles.required' => 'Peran wajib dipilih.'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $users = User::find($id);
        $users->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $users->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User berhasil diperbaharui');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User berhasil dihapus');
    }
}
