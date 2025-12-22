<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
<head>
    <?php require_once '../static/function/script/head.php'; ?>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<?php require_once '../static/function/navigation/navbar.php'; ?>
<body>
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 col-md-12">
                <a href="/submission-abstract/list" class="md-dark">
                    <div class="card navbar-color-two mb-3" style="min-height: 160px">
                        <div class="card-body">
                            <span class="display-6 badge white mb-3 z-depth-1 p-0 m-0">
                                <i class="fa-solid fa-note-sticky p-2 m-2 text-dark" style="font-size: 30px;"></i>
                            </span>
                            <br>
                            <text class="display-8 font-weight-bold text-white font-bai-jamjuree">Abstract Submission</text>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 col-md-12">
                <a href="#/submission-paper/list" class="md-dark">
                    <div class="card navbar-color-three mb-3" style="min-height: 160px">
                        <div class="card-body">
                            <span class="display-6 badge white mb-3 z-depth-1 p-0 m-0">
                                <i class="fa-solid fa-file-circle-check p-2 m-2 text-dark" style="font-size: 30px;"></i>
                            </span>&nbsp;
                            <div class="badge badge-danger text-white">Not Available Yet</div>
                            <br>
                            <text class="display-8 font-weight-bold text-white font-bai-jamjuree">Full Paper Submission</text>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 col-md-12">
                <a href="/registration/list" class="md-dark">
                    <div class="card navbar-color-one mb-3" style="min-height: 160px">
                        <div class="card-body">
                            <span class="display-6 badge white mb-3 z-depth-1 p-0 m-0">
                                <i class="fa-solid fa-address-card p-2 m-2 text-dark" style="font-size: 30px;"></i>
                            </span>
                            <br>
                            <text class="display-8 font-weight-bold text-dark font-bai-jamjuree">Conference Registration</text>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-md-12">
                <a href="/submission-school/list" class="md-dark">
                    <div class="card default-color-dark mb-3" style="min-height: 120px">
                        <div class="card-body">
                            <span class="display-6 badge white mb-3 z-depth-1 p-0 m-0">
                                <i class="fa-solid fa-school p-2 m-2 text-dark" style="font-size: 30px;"></i>
                            </span>
                            <br>
                            <text class="display-8 font-weight-bold text-white font-bai-jamjuree">High School Project Submission</text>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-md-12">
                <a href="/submission-senior/list" class="md-dark">
                    <div class="card default-color-dark mb-3" style="min-height: 120px">
                        <div class="card-body">
                            <span class="display-6 badge white mb-3 z-depth-1 p-0 m-0">
                                <i class="fa-solid fa-graduation-cap p-2 m-2 text-dark" style="font-size: 30px;"></i>
                            </span>
                            <br>
                            <text class="display-8 font-weight-bold text-white font-bai-jamjuree">Senior Project Submission</text>
                        </div>
                    </div>
                </a>
            </div>
        </div>
            
    </div>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; ?>
    <?php require_once '../static/function/script/footer.php'; ?>
</body>
</html>