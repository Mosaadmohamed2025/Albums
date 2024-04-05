@extends('layouts.master')
@section('title')
    Album Images
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Album Management</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                      Album Images</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-body">
                    <div class="mb-3">
                        <form  action="{{route('album.add.images' , $album->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="Album-Images" class="content"
                                 data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <button type="button" id="btnAdd-1" class="btn btn-sm btn-primary"><i
                                                    style="color: white;" class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row group">
                                    <div class="col-md-6">
                                        <label>name</label>
                                        <input class="form-control form-control-sm" name="name[]" type="text" />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" accept="image/*"  name="images[]">
                                    </div>
                                    <div class="col-md-1 m-1">
                                        <button type="button" class="btn btn-sm btn-danger btnRemove"><i class="text-white  ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-info mt-1">Submit</button>

                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th>name</th>
                                <th>image</th>
                                <th>Process</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($Album_Images) > 0)
                                @foreach($Album_Images as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <img  src="/album_images/{{$item->image}}" style="border-radius: 50%" width="40px" height="40px"  />
                                        </td>
                                        <td>
                                            <form action="{{route('album.images.delete', $item->id)}}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-sm btn-danger btnRemove"><i
                                                            class="text-white  ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <script src="{{URL::asset('asset/js/jquery.multifield.min.js')}}"></script>


    <script>
        $(function () {
            jQuery("[name=select_all]").click(function (source) {
                checkboxes = jQuery("[name=delete_select]");
                for (var i in checkboxes) {
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script>
        $('#Album-Images').multifield();
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_delete_all").click(function () {
                var selected = [];
                $("#example input[name=delete_select]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#delete_select').modal('show')
                    $('input[id="delete_select_id"]').val(selected);
                }
            });
        });
    </script>

@endsection
