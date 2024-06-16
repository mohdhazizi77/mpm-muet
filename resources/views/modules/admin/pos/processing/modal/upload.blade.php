a<!--  Add News -->
<div id="modal_upload_xlsx" class="modal modal-form fade bs-example-modal-lg" data-bs-backdrop="static"  data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header-form">
                <h5 class="modal-title" id="myLargeModalLabel">Muat Naik Xlsx</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_upluad_xlsx" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control { $('#show-validate').text() ? 'is-invalid' : '' }" accept=".xls,.xlsx" required name="file" type="file" id="formFile">
                    <span id="show-validate" class="text-danger"></span>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <button type="button" class="btn btn-soft-dark waves-effect waves-light mr-1" data-bs-dismiss="modal">
                            Kembali
                        </button>
                        <button type="button" id="submit-upload" class="btn btn-soft-primary waves-effect waves-light" >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>