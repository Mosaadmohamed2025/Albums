<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbum;
use App\Http\Requests\UpdateAlbum;

use App\Interface\AlbumRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    private $Albums;

    public function __construct(AlbumRepositoryInterface $Albums)
    {
        $this->Albums = $Albums;
    }
    public function index()
    {
       return $this->Albums->index();
    }


    public function create()
    {
        return $this->Albums->create();
    }


    public function store(StoreAlbum $request)
    {
        return $this->Albums->store($request);
    }

    public function show(string $id)
    {
        return $this->Albums->show($id);
    }


    public function addAlbumImages(Request $request, $id)
    {
        $request->validate([
            'name.*' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // يجب أن تكون جميع الصور مطلوبة وصور
        ]);

        return $this->Albums->addAlbumImages($request ,$id);

    }



    public function deleteAlbumImages($id)
    {
        return $this->Albums->deleteAlbumImages($id);
    }

    public function edit(string $id)
    {
        return $this->Albums->edit($id);

    }


    public function update(UpdateAlbum $request, string $id)
    {
        return $this->Albums->update($id);
    }


    public function destroy(Request $request)
    {
        return $this->Albums->destroy($request);

    }

    public function move($id)
    {
        return $this->Albums->move($id);
    }
    public function moveImagesToAlbum(Request $request)
    {
        return $this->Albums->moveImagesToAlbum($request);
    }

}
