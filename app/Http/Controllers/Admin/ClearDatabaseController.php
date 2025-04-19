<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ClearDatabaseController extends Controller
{
    function index()
    {
        return view('admin.clear-database.index');
    }

    function deleteFiles() : void
    {
        $path = public_path('uploads');
        $preservedFiles = ['avatar.png', 'media6645c36f03f5b.png', 'media664492c19146c.png', 'media66454706e1c63.png'];
    
        $allFiles = File::allFiles($path);
        foreach ($allFiles as $file) {
            $filename = $file->getFilename();

            if (!in_array($filename, $preservedFiles)) {
                File::delete($file->getPathname());
            }
        }
    }

    function clearDatabase()
    {
        try {
            //Wipe Database
            Artisan::call('migrate:fresh');

            //Delete files from the database
            $this->deleteFiles();

            //Seed default tables into the database
            Artisan::call('db:seed', ['--class' => 'UserSeeder']);
            Artisan::call('db:seed', ['--class' => 'GeneralSettingsSeeder']);
            Artisan::call('db:seed', ['--class' => 'PaymentGatewaySeeder']);
            Artisan::call('db:seed', ['--class' => 'MenuBuilderSeeder']);
            Artisan::call('db:seed', ['--class' => 'SectionTitleSeeder']);

            return response(['status' => 'success', 'message' => 'Database wiped successfully']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
