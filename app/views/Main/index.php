<div class="container">
    <div class="row flex-lg-nowrap">
        <div class="col">
            <div class="row flex-lg-nowrap">
                <div class="col mb-3">
                    <div class="e-panel card">
                        <div class="card-body">
                            <div class="card-title">
                                <h6 class="mr-2"><span>Users</span></h6>
                            </div>

                            <div id="error-message"></div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control group-action">
                                            <option value="none">Please Select</option>
                                            <option value="active">Set active</option>
                                            <option value="unactive">Set not active</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary group-action-send" type="button">Ok</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary add-user">Add</button>
                                </div>
                            </div>


                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="align-top">
                                                <div
                                                        class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                                                    <input type="checkbox" class="custom-control-input" id="all-items">
                                                    <label class="custom-control-label" for="all-items"></label>
                                                </div>
                                            </th>
                                            <th class="max-width">Name</th>
                                            <th class="sortable">Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="user-table-body">
                                        <?php foreach ($data['listUsers'] as $user):?>
                                            <tr id="user-item-<?=$user['id'];?>">
                                                <td class="align-middle">
                                                    <div
                                                            class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                                                        <input type="checkbox" class="custom-control-input check-item" data-user="<?=$user['id'];?>" id="item-<?=$user['id'];?>">
                                                        <label class="custom-control-label" for="item-<?=$user['id'];?>"></label>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap align-middle"><?=$user['first_name'];?> <?=$user['last_name'];?></td>
                                                <td class="text-nowrap align-middle">
                                                    <span>
                                                        <?php if($user['role'] == 1): ?>
                                                            Admin
                                                        <?php else: ?>
                                                            User
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php if($user['status'] == 1): ?>
                                                        <i class="fa fa-circle active-circle"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-circle not-active-circle"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="btn-group align-top">
                                                        <button class="btn btn-sm btn-outline-secondary badge user-edit" data-user="<?=$user['id'];?>" type="button">Edit</button>
                                                        <button class="btn btn-sm btn-outline-secondary badge user-delete" data-user="<?=$user['id'];?>" type="button"><i
                                                                    class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control group-action">
                                            <option value="none">Please Select</option>
                                            <option value="active">Set active</option>
                                            <option value="unactive">Set not active</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary group-action-send" type="button">Ok</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary add-user">Add</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- User Form Modal -->

            <div class="modal fade" id="user-form-modal" tabindex="-1" aria-labelledby="user-form-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="UserModalLabel">Add user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="error-message-modal"></div>
                            <form action="javascript:;" id="user-form" data-action="">
                                <div class="form-group">
                                    <label for="first-name" class="col-form-label">First Name:</label>
                                    <input name="first-name" type="text" class="form-control" id="first-name">
                                </div>
                                <div class="form-group">
                                    <label for="last-name" class="col-form-label">Last Name:</label>
                                    <input name="last-name" type="text" class="form-control" id="last-name">
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group mt-3 mb-3">
                                            <select name="role" class="form-control" id="role">
                                                <option value="1">admin</option>
                                                <option value="2">user</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        Status:
                                        <label class="switch">
                                            <input name="status" value="1" type="checkbox" class="default" id="status">
                                            <span class="slider round"></span>
                                        </label>
                                    </li>
                                </ul>

                                <input type="hidden" name="id" id="modal-user-id" value="">

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="user-modal-save">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>













    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="confirm-send" data-user="" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>




