<button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#{{ $modelId }}"><i
        class="fa-solid fa-trash"></i></button>
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="{{ $modelId }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{-- <form method="POST" action="{{ $Action }}">
            @csrf
            @method('PUT') --}}
            <div class="modal-body">
                <div class="text-center my-5">
                    <span class="cancel-icon"><i class="fa-solid fa-xmark fa-2xl"></i></span>
                </div>
                <div class="text-center my-2">
                    <span class="model_title">
                        Are You Sure?
                    </span>
                    <p class="model_description">
                        Do you really want to delete these record?<br>
                        This process cannot be undone.
                    </p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ $Action }}" class="btn btn-danger">Delete</a>

                </div>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
