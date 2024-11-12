<?php

// app/Http/Controllers/ResourceController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View; // Tambahkan ini




class ResourceController extends Controller
{
    public function createForm(): View
    {
        $title = "Halaman Modul";
        $subtitle = "Menu Modul";
        return view('create_resource_form', compact('title', 'subtitle'));
    }

    public function createResource(Request $request)
    {
        $tableName = $request->input('nama_table');
        $fields = $request->input('fields');
        Log::info('Fields received:', $fields); // Log untuk memastikan fields diterima
        
        $modelName = Str::studly(Str::singular($tableName));
        $controllerName = "{$modelName}Controller";
        $controllerNamespace = "App\\Http\\Controllers\\{$controllerName}";
        $resourceRoute = "    Route::resource('{$tableName}', {$controllerName}::class);\n";
        $useController = "use {$controllerNamespace};\n";
    
        // 1. Membuat migration
        Artisan::call('make:migration', [
            'name' => "create_{$tableName}_table"
        ]);
    
        $migrationFile = database_path('migrations/' . now()->format('Y_m_d_His') . "_create_{$tableName}_table.php");
    
        // Mengisi migration dengan field-field
        if (File::exists($migrationFile)) {
            $content = File::get($migrationFile);
            $fieldsMigration = '';
    
            foreach ($fields as $field) {
                $fieldsMigration .= "\$table->{$field['type']}('{$field['name']}');\n            ";
            }
    
            $content = str_replace(
                '$table->id();',
                "\$table->id();\n            $fieldsMigration",
                $content
            );
    
            File::put($migrationFile, $content);
        }
    
        // 2. Membuat model
        Artisan::call('make:model', [
            'name' => $modelName
        ]);
    
        // 3. Membuat controller dengan resource
        Artisan::call('make:controller', [
            'name' => $controllerName,
            '--resource' => true
        ]);
    
        // 4. Membuat folder views jika belum ada
        $viewFolderPath = resource_path("views/{$tableName}");
        if (!File::exists($viewFolderPath)) {
            File::makeDirectory($viewFolderPath, 0755, true);
        }
    
        // Membuat file view dasar (index, create, edit, show)
        $views = ['index', 'create', 'edit', 'show'];
        foreach ($views as $view) {
            File::put("$viewFolderPath/$view.blade.php", "<!-- Halaman $view untuk $modelName -->");
        }
    
        // 5. Menambahkan use statement dan route baru di dalam grup middleware 'auth' di web.php
        $webRouteFile = base_path('routes/web.php');
        $routeGroupStart = "Route::group(['middleware' => ['auth']], function () {";
        
        if (File::exists($webRouteFile)) {
            $content = File::get($webRouteFile);
    
            // Tambahkan use statement di bagian atas file jika belum ada
            if (strpos($content, $useController) === false) {
                $content = preg_replace("/(<\?php\n)/", "$1$useController", $content);
            }
    
            // Cari posisi grup 'auth' dan tambahkan route resource baru di dalamnya
            if (strpos($content, $routeGroupStart) !== false) {
                $content = preg_replace(
                    "/(Route::group\(\['middleware' => \['auth'\]\], function \(\) \{)/",
                    "$1\n$resourceRoute",
                    $content
                );
                File::put($webRouteFile, $content);
            }
        }
    
        // Menjalankan migrasi untuk membuat tabel di database
        Artisan::call('migrate');
    
        return redirect()->route('resource.create')->with('success', "Resource untuk tabel {$tableName} berhasil dibuat dan route ditambahkan.");
    }


}
