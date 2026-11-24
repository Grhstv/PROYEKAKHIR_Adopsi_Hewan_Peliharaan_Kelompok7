<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\KategoriResource;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriResource::collection(Kategori::orderBy('nama')->get());
    }
}
