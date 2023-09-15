<!-- Modal Body -->
<div class="modal fade" id="modalIdSuccess" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center my-5">
                    <span class="success-icon py-3 px-3"><i class="fa-solid fa-check"></i></span>
                </div>
                <div class="text-center my-2 mb-5">
                    <span class="model_title">
                        {{ $title }}
                    </span>
                    <p class="model_description">
                        {{ $desc }} <br>
                    </p>
                    <button type="button" class="btn btn-secondary col"
                        data-bs-dismiss="modal">{{ $closeText }}</button>

                    {{-- @foreach ($ButtonArray as $item)
                        <a href="{{ $item['link'] }}" class="btn btn-primary">{{ $item['text'] }}</a>
                    @endforeach --}}
                    @if ($slot->isEmpty())
                        No content provided.
                    @else
                        {{ $slot }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Your other content -->
@if (session('success'))
    <script>
        // Script to show the modal after the page is loaded
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalIdSuccess'));
            myModal.show();
        });
    </script>
@endif
