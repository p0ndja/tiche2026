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
                    <?php echo createHeader("Plenary Lecture"); ?>
                    <!-- <h5 class="text-center text-muted py-5">To be announced</h5> -->
                    <p class='font-italic text-muted'>
                        <table cellspacing="0" class="MsoTableGrid" style="border:0px; text-align:left; vertical-align:middle; white-space:normal">
                            <tbody>
                                <tr>
                                    <td>
                                        <img
                                        src="/static/asset/upload/people/speaker/Rachit%20Agarwal.jpg"
                                        style="width: 120px"
                                        class="z-depth-1"
                                        />
                                    </td>
                                    <td class="pl-3">
                                        <h6><strong>Topic: AI as the New Performance Divide in the Chemicals Industry</strong></h6>
                                        <h6><strong>Mr. Rachit Agarwal, Principal</strong></h6>
                                        Boston Consulting Group (BCG), Singapore
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-2">
                                        <img
                                        src="/static/asset/upload/people/speaker/Ms.%20Insa%20Illgen.jpg"
                                        style="width: 120px"
                                        class="z-depth-1"
                                        />
                                    </td>
                                    <td class="pl-3 pt-2">
                                        <h6><strong>Topic: Accelerating Industrial Decarbonization under Thailand's Net Zero Agenda</strong></h6>
                                        <h6><strong>Ms. Insa Illgen</strong></h6>
                                        Deutsche Gesellschaft für Internationale Zusammenarbeit (GIZ),<br>
                                        Germany
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-2">
                                        <img
                                        src="/static/asset/upload/people/speaker/Mr.%20Burin%20Adulwattana.jpg"
                                        style="width: 120px"
                                        class="z-depth-1"
                                        />
                                    </td>
                                    <td class="pl-3 pt-2">
                                        <h6><strong>Topic: Financial Innovation: Unlocking Thailand's Potentials</strong></h6>
                                        <h6><strong>Mr. Burin Adulwattana</strong></h6>
                                        Managing Director and Chief Economist,<br>
                                        Kasikorn Research Center (KResearch),<br>
                                        Kasikornbank, Thailand
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </p>
                    <br>
                    <?php echo createHeader("Invited Speakers"); ?>
                    <!-- <h5 class="text-center text-muted py-5">To be announced</h5> -->
                    <p class='font-italic text-muted'>
                        <table cellspacing="0" class="MsoTableGrid" style="border:0px; text-align:left; vertical-align:middle; white-space:normal">
                            <tbody>
                            <tr>
                                <td>
                                    <img
                                    src="/static/asset/upload/people/speaker/5.%20Dr.%20Cattaleeya%20Pattamaprom.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3">
                                    <h6><strong>Topic: Natural Rubber-Based Sustainable Packaging: 10 Years of Innovation from Functional Performance to End-of-Life Degradation</strong></h6>
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
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/2.%20Dr.%20Hiroyasu%20Tabe.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Glass Engineering of Metal-Organic Frameworks/Coordination Polymers for Composite Catalytic Systems</strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Hiroyasu Tabe<br />
                                        Associate Professor</strong
                                    >
                                    </h6>
                                    Institute for Integrated Cell-Material Sciences<br>
                                    Kyoto University, Japan
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/3.%20Prof.%20Dr.%20Hui%20Tong%20Chua.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Lamp Ablation Technology for Accessing Various Nanostructures</strong></h6>
                                    <h6>
                                    <strong
                                        >Prof. Dr. Hui Tong Chua<br />
                                        Professor</strong
                                    >
                                    </h6>
                                    Department of Chemical Engineering<br>
                                    School of Engineering, The University of Western Australia, Australia
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/Mr.%20Michael%20Potts.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Enabling a Growth Mindset and Learning at IChemE</strong></h6>
                                    <h6>
                                    <strong>Mr. Michael Potts</strong>
                                    </h6>
                                    Head of Learning and Development, IChemE<br>
                                    Institution of Chemical Engineers, United Kingdom
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/1.%20Dr.%20Pawin Iamprasertkun.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 p">
                                    <h6><strong>Topic: Electrolyte Engineering: From Solution Thermodynamics to High-Voltage Energy Storage Applications</strong></h6>
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
                                    src="/static/asset/upload/people/speaker/2.%20Dr.%20Pornnapa Kasemsiri.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Functional Biopolymers Integrated with Bioactive Compounds</strong></h6>
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
                                    src="/static/asset/upload/people/speaker/3.%20Dr.%20Ravin Narain.jpg"
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
                                    src="/static/asset/upload/people/speaker/6.%20Dr.%20Supareak Praserthdam.jpg"
                                    style="width: 120px"
                                    class="z-depth-1"
                                    />
                                </td>
                                <td class="pl-3 pt-2">
                                    <h6><strong>Topic: Quantum Chemistry-informed Optimization of Heterogeneous Catalytic Processes: A Case Study of Integrated Carbon Capture and Conversion</strong></h6>
                                    <h6>
                                    <strong
                                        >Dr. Supareak Praserthdam<br />
                                        Associate Professor</strong
                                    >
                                    </h6>
                                    Department of Chemical Engineering<br>
                                    Faculty of Engineering, Chulalongkorn University, Bangkok, Thailand
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-2">
                                    <img
                                    src="/static/asset/upload/people/speaker/4.%20Dr.%20Thanh-Binh Nguyen.jpg"
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
