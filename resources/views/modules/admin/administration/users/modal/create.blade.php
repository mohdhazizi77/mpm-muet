<!--  Add News -->
<div id="modal_create" class="modal modal-form fade bs-example-modal-lg" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header-form">
                <h5 class="modal-title" id="myLargeModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="form_users_add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row py-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                <span class="text-danger" id="name_text"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required
                                    autocomplete="off">
                                <span class="text-danger" id="email_text"></span>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="phonenumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phonenumber" name="phonenumber" required
                                    autocomplete="off">
                                <span class="text-danger" id="phone_text"></span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="" class="form-control" required>
                                <option disabled selected value="">Please Select</option>
                                @foreach ($role as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="role_text"></span>

                        </div>

                        <div class="col-6">
                            <label for="role" class="form-label">Status</label>
                            <select name="status" id="" class="form-control" required>
                                <option disabled selected value="">Please Select</option>
                                @foreach (['Active', 'Inactive'] as $k => $v)
                                    <option value={{ $k }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="status_text"></span>
                        </div>

                    </div><!--end row-->
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <button type="button" class="btn btn-soft-dark waves-effect waves-light mr-1"
                            data-bs-dismiss="modal">
                            Back
                        </button>
                        <button type="button" id="submit_add" class="btn btn-soft-primary waves-effect waves-light">
                            Register
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
