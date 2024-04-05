<?php

namespace App\Repository;
use App\Interface\AlbumRepositoryInterface;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class AlbumRepository implements  AlbumRepositoryInterface
{
    public function index()
    {
        $albums = Album::all();
        return view('albums.index' , compact('albums'));
    }


    public function create()
    {
        return view('albums.add');
    }


    public function store($request)
    {
        $album = new Album();
        $album->name = $request->name;
        $album->save();

        if ($request->has('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = $request->name . '-image-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('album_images'), $imageName);
                Image::create([
                    'album_id' => $album->id,
                    'image' => $imageName
                ]);
            }
        }

        $album->save();

        session()->flash('Add', 'The Album has been added successfully');
        return redirect()->route('Albums.index');
    }

    public function show($id)
    {
        $album = Album::find($id);
        $Album_Images = Image::where('album_id',$id)->get();
        return view('albums.album-images' , compact('Album_Images','album'));
    }


    public function addAlbumImages($request, $id)
    {

        $data = $request->all();

        foreach ($data['name'] as $key => $name) {
            if (!empty($name) && isset($data['images'][$key])) {
                $imageName = $name . '-image-' . time() . rand(1, 1000) . '.' . $data['images'][$key]->extension();
                $data['images'][$key]->move(public_path('album_images'), $imageName);
                Image::create([
                    'album_id' => $id,
                    'name' => $name,
                    'image' => $imageName
                ]);
            }
        }

        return redirect()->back()->with('success', 'Album Images successfully added');
    }



    public function deleteAlbumImages($id)
    {

        $albumImage = Image::find($id);

        if($albumImage)
        {
            $albumImage->delete();
            return redirect()->back()->with('delete', 'The album image has been deleted');

        }else{
            return redirect()->back()->with('error', 'The album image not found');
        }
    }

    public function edit(string $id)
    {
        $album = Album::find($id);
        return view('albums.edit' , compact('album'));
    }


    public function update($request)
    {
        $album = Album::find($request->id);

        $album->name = $request->name;

        $album->save();

        session()->flash('edit', 'The Album has been edited');
        return redirect()->route('Albums.index');
    }


    public function destroy($request)
    {
        if($request->page_id==1){
            $albumID = $request->input('album_id');

            $album = Album::find($albumID);
            if (!$album) {
                session()->flash('error', 'The album is not found');
                return redirect()->route('Albums.index');
            }
            foreach ($album->images as $image) {
                Storage::disk('album')->delete($image->image);
                $image->delete();
            }

            $album->delete();

            session()->flash('delete', 'The Album has been deleted');
            return redirect()->route('Albums.index');

        }
        else
        {
            $delete_select_id = explode(",", $request->delete_select_id);
            foreach ($delete_select_id as $ids_albums){
                $album = Album::findorfail($ids_albums);
                if($album->images){
                    foreach ($album->images as $image) {
                        Storage::disk('album')->delete($image->image);
                        $image->delete();
                    }

                }

                $album->delete();
            }

            session()->flash('delete', 'The All albums have been deleted');
            return redirect()->route('Albums.index');
        }
    }

    public function move($id)
    {
        $album = Album::find($id);
        return view('albums.move-images' , compact('album'));
    }
    public function moveImagesToAlbum($request)
    {
        $destinationAlbumId = $request->album_id;
        $selectedImages = Image::where('album_id', $request->id)->get();

        foreach ($selectedImages as $image) {
            $image->album_id = $destinationAlbumId;
            $image->save();
        }

        return redirect()->back()->with('success', 'Images moved successfully to the new album');
    }
}
