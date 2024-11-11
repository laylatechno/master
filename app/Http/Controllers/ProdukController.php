<?php
    
namespace App\Http\Controllers;
    
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class ProdukController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:produk-list|produk-create|produk-edit|produk-delete', ['only' => ['index','show']]);
         $this->middleware('permission:produk-create', ['only' => ['create','store']]);
         $this->middleware('permission:produk-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:produk-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $produk = Produk::latest()->paginate(5);

        return view('produk.index',compact('produk'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('produk.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        Produk::create($request->all());
    
        return redirect()->route('produk.index')
                        ->with('success','Produk created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk): View
    {
        return view('produk.show',compact('produk'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk): View
    {
        return view('produk.edit',compact('produk'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $produk->update($request->all());
    
        return redirect()->route('produk.index')
                        ->with('success','Produk updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();
    
        return redirect()->route('produk.index')
                        ->with('success','Produk deleted successfully');
    }
}
