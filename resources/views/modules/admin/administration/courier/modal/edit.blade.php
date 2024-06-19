<!--  Add News -->
<div id="modal_edit" class="modal modal-form fade bs-example-modal-lg" data-bs-backdrop="static"  data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header-form">
                <h5 class="modal-title" id="myLargeModalLabel">Kemaskini Kurier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_courier_edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col">
                            <label for="">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <input type="text" name="id" id="id" class="form-control" hidden>
                        </div>
                    </div>
                    
                    <div class="form-group row mt-5">
                        <div class="col-6">
                            <label for="">Jenis Mata Wang <span class="text-danger">*</span></label>
                            <input type="text" name="currency" id="currency" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="">Kadar <span class="text-danger">*</span></label>
                            <input type="number" name="rate" id="rate" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <div class="col-6">
                            <label for="">Durasi <span class="text-danger">*</span></label>
                            <input type="text" name="duration" id="duration" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-dark waves-effect waves-light mr-1" data-bs-dismiss="modal">
                    Kembali
                </button>
                <button type="button" id="submit" class="btn btn-soft-primary waves-effect waves-light" >
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>