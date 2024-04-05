<!-- Modal -->
<div class="modal fade" id="delete{{ $album->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Albums.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h5>  Are you sure to delete this product : {{$album->name}} ?</h5>
                    <input type="hidden" value="1" name="page_id">
                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    @if(count($album->images) > 0)
                        <a href="{{route('move' , $album->id)}}" class="btn btn-danger">move images To another album</a>
                        <button type="submit" class="btn btn-danger">delete all images</button>
                    @else
                    <button type="submit" class="btn btn-danger">submit</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
