<!DOCTYPE html>  
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/img/icon.png')?>">
    <title>Authentication Tickets</title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url()?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=base_url()?>/assets/css/sb-admin-2.min.css?v=<?=CSS_VERSION?>" rel="stylesheet">
    <link href="<?=base_url()?>/assets/css/app.css?v=<?=CSS_VERSION?>" rel="stylesheet">
</head>

<body class="bg-gray">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-8 p-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <div class="img-login">
                                            <img src="<?=base_url('assets/img/icon.png')?>" alt="logo" title="logo" width="100" height="auto">
                                        </div>
                                        <h1 class="h4 text-gray-900 mb-4 mt-4">Welcome again!</h1>
                                        
                                        <?php if (isset($validation)): ?>
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                
                                                <?php if (method_exists($validation, 'listErrors')): ?>
                                                    <?= $validation->listErrors() ?>
                                                <?php endif; ?>

                                                <?php if (is_string($validation)): ?>
                                                    <?= $validation ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>

                                    <form class="user" method="post" id="form" action="<?=base_url('login')?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="login" name="login" aria-describedby="emailHelp" placeholder="Type your user..." >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Type your password..." >
                                        </div>
                                        <button class="btn btn-gray btn-user btn-block" type="submit"> Login </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url()?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url()?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url()?>/assets/js/sb-admin-2.min.js"></script>
</body>
</html>