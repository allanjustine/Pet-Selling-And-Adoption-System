@if (Route::is('admin.categories.index'))
    {{-- Creating category --}}
    <div class="modal fade" id="m_category" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="m_category_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="m_category_header">
                    <h6 class="modal-title text-white" id="m_category_title">{{-- Modal Title --}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form class="category_form" autocomplete="off">
                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Has Vaccination? *</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_vaccination_yes" name="has_vaccination"
                                    class="custom-control-input yes" value="1">
                                <label class="custom-control-label" for="has_vaccination_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_vaccination_no" name="has_vaccination"
                                    class="custom-control-input no" value="0">
                                <label class="custom-control-label" for="has_vaccination_no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Has Deworming? *</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_deworming_yes" name="has_deworming"
                                    class="custom-control-input yes" value="1">
                                <label class="custom-control-label" for="has_deworming_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="has_deworming_no" name="has_deworming"
                                    class="custom-control-input no" value="0">
                                <label class="custom-control-label" for="has_deworming_no">
                                    No
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn float-end btn_add_category btn-primary"
                        onclick="c_store('.category_form','.category_dt', 'admin.categories.store')">Submit</button>
                    <button type="button" class="btn float-end btn_update_category btn-primary"
                        onclick="c_update('.category_form','.category_dt', 'admin.categories.update', event)">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Creating category --}}
@endif


@if (Route::is('admin.breeds.index'))
    {{-- Creating breed --}}
    <div class="modal fade" id="m_breed" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="m_breed_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="m_breed_header">
                    <h6 class="modal-title text-white" id="m_breed_title">{{-- Modal Title --}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form class="breed_form" autocomplete="off">

                        <div class="form-group">
                            <label class="form-label">Department *</label>
                            <select class="form-control" name="category_id" id="d_categories">
                                {{-- display departments --}}
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Breed *</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn float-end btn_add_breed btn-primary"
                        onclick="c_store('.breed_form','.breed_dt', 'admin.breeds.store')">Submit</button>
                    <button type="button" class="btn float-end btn_update_breed btn-primary"
                        onclick="c_update('.breed_form','.breed_dt', 'admin.breeds.update', event)">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Creating breed --}}
@endif

{{-- Creating payment_method --}}
@if (url()->current() === route('admin.payment_methods.index'))
    <div class="modal fade" id="m_payment_method" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="m_payment_method_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="m_payment_method_header">
                    <h6 class="modal-title text-white" id="m_payment_method_title">{{-- Modal Title --}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form class="payment_method_form" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label class="form-label">Type *</label>
                            <input type="text" class="form-control" name="type"
                                placeholder="(Ex. Gcash, BDO, UnionBank)">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Account Name *</label>
                            <input type="text" class="form-control" name="account_name">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Account No. *</label>
                            <input type="text" class="form-control" name="account_no">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn float-end btn_add_payment_method btn-primary"
                        onclick="c_store('.payment_method_form','.payment_method_dt', 'admin.payment_methods.store')">Submit</button>
                    <button type="button" class="btn float-end btn_update_payment_method btn-primary"
                        onclick="c_update('.payment_method_form','.payment_method_dt', 'admin.payment_methods.update', event)">Update</button>
                </div>
            </div>
        </div>
    </div>
@endif
