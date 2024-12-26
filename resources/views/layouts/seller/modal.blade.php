@auth
    {{-- Create / Edit Comment --}}
    <div class="modal fade" id="m_comment" tabindex="-1" role="dialog" aria-labelledby="m_comment" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-white"> Edit Comment <i class="fas fa-edit ml-1"></i></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="comment_form" autocomplete="off">
                        <div class="form-group">
                            <input class="form-control" type="text" name="comment" id="comment">
                            <input type="hidden" name="pet_id" id="pet_id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary float-end btn_update_comment"
                        onclick="updateComment('.comment_form', 'comments.update', event)">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Create / Edit Comment --}}
@endauth
