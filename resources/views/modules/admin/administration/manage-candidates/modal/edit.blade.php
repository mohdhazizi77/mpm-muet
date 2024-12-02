<!-- Add News -->
<div id="modal_edit" class="modal modal-form fade bs-example-modal-lg" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-form">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_candidate_edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row py-4">
                        <input type="text" id="id" name="id" hidden>
                        <div class="col-12 divNamaIC">
                            <div class="mb-3">
                                <label for="name_edit" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <span class="text-danger" id="name_text_edit"></span>
                            </div>
                        </div>

                        <div class="col-12 divNamaIC">
                            <div class="mb-3">
                                <label for="nric_edit" class="form-label">Identity Card Number tanpa -</label>
                                <input type="text" class="form-control" id="nric_edit" name="nric" required autocomplete="off">
                                <span class="text-danger" id="nric_text_edit"></span>
                            </div>
                        </div>

                        <!-- Editable Score Fields -->
                        <div class="col-3 divMarkah">
                            <div class="mb-3">
                                <label for="listening_score" class="form-label">Listening Score</label>
                                <input type="text" class="form-control" id="listening-score" name="listening_score" required>
                            </div>
                        </div>
                        <div class="col-3 divMarkah">
                            <div class="mb-3">
                                <label for="speaking_score" class="form-label">Speaking Score</label>
                                <input type="text" class="form-control" id="speaking-score" name="speaking_score" required>
                            </div>
                        </div>
                        <div class="col-3 divMarkah">
                            <div class="mb-3">
                                <label for="reading_score" class="form-label">Reading Score</label>
                                <input type="text" class="form-control" id="reading-score" name="reading_score" required>
                            </div>
                        </div>
                        <div class="col-3 divMarkah">
                            <div class="mb-3">
                                <label for="writing_score" class="form-label">Writing Score</label>
                                <input type="text" class="form-control" id="writing-score" name="writing_score" required>
                            </div>
                        </div>

                        <!-- Aggregated Score Field -->
                        <div class="col-6 divMarkah">
                            <div class="mb-3">
                                <label for="aggregated_score" class="form-label">Aggregated Score</label>
                                <input type="text" class="form-control" id="aggregated-score" name="aggregated_score" required>
                            </div>
                        </div>

                        <!-- Band Achieved Field -->
                        <div class="col-6 divMarkah">
                            <div class="mb-3">
                                <label for="band_achieved" class="form-label">Band Achieved</label>
                                <input type="text" class="form-control" id="band-achieved" name="band_achieved" required>
                            </div>
                        </div>
                    </div><!-- end row -->
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <button type="button" class="btn btn-soft-dark waves-effect waves-light mr-1" data-bs-dismiss="modal">
                            Back
                        </button>
                        <button type="button" id="submit" class="btn btn-soft-primary waves-effect waves-light">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
