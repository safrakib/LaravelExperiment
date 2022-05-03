<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\View;

class Post extends Controller
{
    function fileUpload()
    {
        return View('welcome');
    }

    function store(Request $req)
    {
        header('Content-Type: image/jpeg');
        //return $req->file('pic')->store('images','public');
        // return Storage::disk('public_root')->put('pImages',$req->file('pic'));
        // $data = asset('pImages/ff6B1MMskcvkgQugRMJPMeIJY6JDa3ZFsLNz0mXa.jpg');
        $im = imagecreatefromjpeg('pImages/ff6B1MMskcvkgQugRMJPMeIJY6JDa3ZFsLNz0mXa.jpg');



        imagejpeg($im,null,100);
        imagedestroy($im);
    }
}
