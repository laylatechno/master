<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogHistori;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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

    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        $log = new LogHistori();
        $log->tabel_asal = $tabelAsal;
        $log->id_entitas = $idEntitas;
        $log->aksi = $aksi;
        $log->waktu = now();  
        $log->pengguna = $pengguna;
        $log->data_lama = $dataLama;
        $log->data_baru = $dataBaru;
        $log->save();
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

        $loggedInUserId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'User', $users->id, $loggedInUserId, null, json_encode($users));
    
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
        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);    
        }
    
        // Ambil data lama sebelum update
        $users = User::find($id);
        $oldData = $users->toArray();
    
        // Lakukan update
        $users->update($input);
    
        // Update peran pengguna
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $users->assignRole($request->input('roles'));
    
        // Simpan log histori dengan data lama dan data baru
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Update', 'User', $users->id, $loggedInUserId, json_encode($oldData), json_encode($input));
    
        return redirect()->route('users.index')
                         ->with('success', 'User berhasil diperbaharui');
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan');
        }
    
        $this->simpanLogHistori('Delete', 'User', $id, Auth::id(), json_encode($user->toArray()), null);
    
        $user->delete();
    
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
    
}
