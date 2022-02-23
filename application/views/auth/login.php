
<div id="particles">
<div class="intro">
<div class="container mt-3">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900">Halaman Login</h1>
                                </div>

                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group row">
										<label for="email" class="col-sm-3 col-form-label text-gray-900"><b>Email</b></label>
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group row">
										<label for="email" class="col-sm-3 col-form-label text-gray-900"><b>Password</b></label>
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
									</button>
									<button type="reset" class="btn btn-danger btn-user btn-block">
                                        Reset
                                    </button>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotPassword') ?>">Lupa Password?</a>
                                </div>

                                <br>
                                <div class="text-center text-gray-900">
                                    <b>AWP-HRD Version 2.0 &copy; Achmad Firmansyah Project.</b>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

	</div>
  </div>
</div>
