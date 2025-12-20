<?php require_once '../static/function/connect.php'; ?>
<!DOCTYPE html>
<html lang="th" prefix="og:http://ogp.me/ns#">
    <head>
        <?php require_once '../static/function/script/head.php'; ?>
        <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <style>
            @media (min-width: 960px) {
                .card-columns {
                    -webkit-column-count: 3;
                    -moz-column-count: 3;
                    column-count: 3;
                }
            }

            @media (max-width: 960px) {
                .card-columns {
                    -webkit-column-count: 1;
                    -moz-column-count: 1;
                    column-count: 1;
                }
            }

            div.stretchy-wrapper {
                background-color: #fafafa;
                position: relative;
                width: 100%;
                padding-top: 56.25%; /* 16:9 Aspect Ratio */
            }

            div.stretchy-wrapper > div {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center center;
            }
        </style>
    </head>
    <?php require_once '../static/function/navigation/navbar.php'; ?>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <?php 
                        $_GET['notAutoHide'] = true;
                        include '../static/function/sidetab.php';
                    ?>
                </div>
                <div class="col-12 col-lg-9">
                    <?php
                        $post = new Post((int) 11);
                    ?>
                    <h3 class='font-weight-bold'>
                        <?php echo $post->getTitle(); ?> 
                        <?php if (isAdmin()) { ?>
                            <a href="../post/edit-<?php echo $post->getID(); ?>" class="z-depth-0 btn-sm btn-floating btn-warning mr-0 ml-0 mb-0 mt-0"><i class='fas fa-edit'></i></a>
                        <?php } ?>
                    </h3>
                    <hr>
                    <div>
                        <?php print_r($post->getArticle()); ?>
                    </div>
                    <?php echo createHeader("Plenery Lecture"); ?>
                    <h5 class="text-center text-muted py-5">To be announced</h5>
                    <!-- <p class='font-italic text-muted'>
                        <table cellspacing="0" class="MsoTableGrid" style="border:0px; text-align:left; vertical-align:middle; white-space:normal">
                            <tbody>
                                <tr>
                                    <td><img alt="Ken-ichi Aika (1942-)" src="data:image/jpeg;base64,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" style="width:120px" class="z-depth-1"/></td>
                                    <td class="pl-3">
                                    <h6><strong>Topic: Key factors for establishing green ammonia industry: Aiming CO<sub>2</sub> free fuel world</strong></h6>
                                    <h6><strong>Dr. Ken-ichi Aika<br />
                                    Emeritus Professor</strong><br /></h6>
                                    Tokyo Institute of Technology<br />
                                    National Institute of Technology (KOSEN)<br />
                                    Numazu College, Japan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </p>
                    <br> -->
                    <?php echo createHeader("Invited Speakers"); ?>
                    <!-- <h5 class="text-center text-muted py-5">To be announced</h5> -->
                    <p class='font-italic text-muted'>
                        <table cellspacing="0" class="MsoTableGrid" style="border:0px; text-align:left; vertical-align:middle; white-space:normal">
                            <tbody>
                            <tr>
                                <td>
                                    <img
                                    src="/static/asset/upload/people/speaker/1. Dr. Pawin Iamprasertkun.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3">
                                    <h6><strong>Topic: <i class="text-muted">*to be announced*</i></strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Pawin Iamprasertkun<br />
                                        Assistant Professor</strong
                                    >
                                    </h6>
                                    School of Bio-Chemical Engineering and Technology<br>
                                    Sirindhorn International Institute of Technology, Thammasat University, Thailand
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/2. Dr. Pornnapa Kasemsiri.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: <i class="text-muted">*to be announced*</i></strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Pornnapa Kasemsiri <br />
                                        Professor</strong
                                    >
                                    </h6>
                                    Department of Chemical Engineering<br>
                                    Faculty of Engineering, Khon Kaen University, Thailand
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/3. Dr. Ravin Narain.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Advanced Nanoparticles Formulation for Biomedical Uses</strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Ravin Narain<br />
                                        Professor</strong
                                    >
                                    </h6>
                                    College of Natural and Applied Sciences<br />
                                    University of Alberta, Canada
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/4. Dr. Thanh-Binh Nguyen.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Unlocking the Potential of Metal-Organic Frameworks (MOFs) for Water Purification Strategies</strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Thanh-Binh Nguyen<br />
                                        Associate Professor</strong
                                    >
                                    </h6>
                                    College of Hydrosphere Science<br>
                                    National Kaohsiung University of Science and Technology, Kaohsiung, Taiwan
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/5. Dr. Cattaleeya Pattamaprom.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: <i class="text-muted">*to be announced*</i></strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Cattaleeya Pattamaprom<br />
                                        Professor</strong
                                    >
                                    </h6>
                                    Department of Chemical Engineering<br>
                                    Faculty of Engineering, Thammasat University, Thailand
                                </td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </p>
                    <br>
                    <?php echo createHeader("Conference Venue"); ?>
                    <p>
                        <h5><b>DUSIT THANI PATTAYA HOTEL</b></h5>
                        240, 2 Beach Rd, Muang Pattaya,<br>
                        Bang Lamung District, Chon Buri 20150<br>
                        <a target="_blank" href="https://www.dusit.com/dusitthani-pattaya/">www.dusit.com/dusitthani-pattaya/</a>
                        <div class="row no-gutters mt-3">
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/1R.jpg" class="img-fluid pr-1 pb-1"/>
                            </div>
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/2R.jpg" class="img-fluid px-1 pb-1"/>
                            </div>
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/3R.jpg" class="img-fluid pl-1 pb-1"/>
                            </div>
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/4R.jpg" class="img-fluid pr-1 pt-1"/>
                            </div>
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/5R.jpg" class="img-fluid px-1 pt-1"/>
                            </div>
                            <div class="col-12 col-md-4">
                                <img src="/static/asset/upload/venue/6R.jpg" class="img-fluid pl-1 pt-1"/>
                            </div>
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.3322992804347!2d100.8852883!3d12.9505757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310296043f40e041%3A0xf70bf1dc0b7e5467!2sDusit%20Thani%20Pattaya%20hotel!5e0!3m2!1sen!2sth!4v1735843226450!5m2!1sen!2sth"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            class="pt-2"
                        ></iframe>

                    </p>
                </div>
            </div>
        </div>
        <!-- <div class="container mt-3">
            <div class="container-fluid mb-2">
                <div class="d-block d-md-none text-center">
                <a href="//www.en.kku.ac.th" class="btn btn-floating mb-2 text-center btn-danger mr-0"><img src="/static/asset/logo/EN.png" height="32" onContextMenu="return false;" class="mt-2"/></a>
                    <a href="//www.kku.ac.th" class="btn btn-floating mb-2 text-center btn-warning mr-0"><img src="/static/asset/logo/kku32.png" height="32" onContextMenu="return false;" class="mt-2"/></a>
                    <a href="//tiche.org" class="btn btn-floating mb-2 text-center btn-primary mr-0"><img src="/static/asset/logo/TIChE.png" height="32" onContextMenu="return false;" class="mt-2"/></a> -->
                    <!--a href="//www.khunlook.com" class="btn btn-floating mb-2 text-center btn-secondary mr-0"><img src="/static/asset/logo/khunlook32.png" height="32" onContextMenu="return false;" class="mt-2"/></a-->
                <!-- </div>
                <div class="d-none d-md-block">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <a href="//www.en.kku.ac.th" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-danger btn-block"><img src="/static/asset/logo/EN.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;<text class="text-dark">Faculty of Engineering</text></a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="//www.kku.ac.th" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-warning btn-block"><img src="/static/asset/logo/kku32.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;&nbsp; <text class="text-dark">Khon Kaen University</text></a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="//tiche.org" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-primary btn-block"><img src="/static/asset/logo/TIChE.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;&nbsp; <text class="text-dark">TIChE</text></a>
                        </div> -->
                        <!--div class="col-md-6 col-xl-3">
                            <a href="//www.khunlook.com" class="btn btn-rounded mb-2 btn-lg text-left btn-outline-secondary btn-block"><img src="/static/asset/logo/khunlook32.png" height="22" onContextMenu="return false;"/>&nbsp;&nbsp;<text class="text-dark">แอปพลิเคชัน KhunLook</text></a>
                        </div-->
                    <!-- </div>
                </div>
            </div>
        </div> -->
    </body>
    <?php require_once '../static/function/popup.php'; ?>
    <?php require_once '../static/function/navigation/footer.php'; // Footer can be hidden by full comment this line.?>
    <?php require_once '../static/function/script/footer.php'; ?>
</html>
