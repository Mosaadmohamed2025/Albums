<?php


namespace App\Interface;


use Illuminate\Database\Eloquent\Model;


interface AlbumRepositoryInterface{
    public function index();

    public function create();

    public function store($request);

    public function show($id);

    public function addAlbumImages($request, $id);

    public function deleteAlbumImages($id);

    public function edit(string $id);

    public function update($request);

    public function destroy($request);

    public function move($id);

    public function moveImagesToAlbum($request);

}
