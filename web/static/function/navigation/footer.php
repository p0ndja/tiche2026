<footer class="footer mt-3" id="footer">
    <div class="container">
        <!-- <div class="row">
            <div class="col-md mt-3">
                <div class="d-flex justify-content-start align-items-center">
                    <div>
                        <img src="../static/asset/logo/ms-icon-150x150.png" width="50" onContextMenu="return false;" />
                    </div>
                    <div class="ml-2 text-white">
                        <div class="d-none d-md-block">
                            <h3 class="mb-0 font-weight-bold">สาขาวิชาวิสัญญีวิทยา</h3>คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น
                        </div>
                        <div class="d-block d-md-none">
                            <h5 class="mb-0 font-weight-bold">สาขาวิชาวิสัญญีวิทยา</h5><small
                                style="line-height: 0cm;">คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น</small>
                        </div>
                    </div>
                </div>
                <hr>
                <p style="color:white;" class="mb-1">
                    ชั้น 3 อาคาร 89 พรรษาสมเด็จย่า โรงพยาบาลศรีนครินทร์<br>คณะแพทยศาสตร์ มหาวิทยาลัยขอนแก่น
                    <br>123 ถนนมิตรภาพ ตำบลในเมือง อำเภอเมืองขอนแก่น จังหวัดขอนแก่น 40002
                    <br><br>โทรศัพท์ 043-363060
                </p>
                <a class="btn btn-rounded btn-primary mr-1 ml-0 btn-md" href="https://www.facebook.com/anest.kku" target="_blank"><i class="fab fa-facebook"></i> สาขาวิชาวิสัญญี</a>
                <a class="btn btn-rounded btn-primary mr-1 ml-0 btn-md" href="https://www.facebook.com/postgradaneskku" target="_blank"><i class="fab fa-facebook"></i> ฝ่ายหลังการศึกษา</a>
                <a class="btn btn-rounded btn-danger mr-1 ml-0 btn-md" href="mailto:anaes2554@gmail.com"><i class="fas fa-envelope"></i> anaes2554@gmail.com</a>
            </div>
            <div class="col-md mt-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3826.153876485414!2d102.82805991449054!3d16.467744288635775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31228ba0219e66a5%3A0x22ffafb31fc7f673!2z4Lig4Liy4LiE4Lin4Li04LiK4Liy4Lin4Li04Liq4Lix4LiN4LiN4Li14Lin4Li04LiX4Lii4LiyIOC4hOC4k-C4sOC5geC4nuC4l-C4ouC4qOC4suC4quC4leC4o-C5jCDguKHguKvguLLguKfguLTguJfguKLguLLguKXguLHguKLguILguK3guJnguYHguIHguYjguJk!5e0!3m2!1sth!2sth!4v1668623803973!5m2!1sth!2sth" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div> -->
        <div class="row pt-3">
            <div class="col-12 text-center mb-2">
                <h6 class="text-white"><a href="/privacy/">Privacy Policy</a>&nbsp;•&nbsp;<?php if (!isLogin()) { ?><a href="../login/">Manage</a><?php } else { ?><a class="md-light" href="../logout/">Logout</a><?php } ?></h6>
                <h6 class="text-white mt-2">Copyright 2025 - 2026 &copy; Department of Chemical Engineering, Faculty of Engineering, Ubon Ratchathani University, Thailand. All Right Reserved.</h6>
                <small class='text-white'>For any inquiries, please contact us at <a href="mailto:tiche2026@ubu.ac.th"><b>[xxx]@[ubu.ac.th]</b></a>, where we will respond promptly to your messages.</small>
                <br><small class='text-muted'>Please note that <b>tiche2026.noreply@gmail.com</b> is used exclusively for system notifications and confirmations. Any messages sent to this address will not receive a response.</small><br>
                <small class="text-muted"><a class="text-warning" data-toggle='modal' data-target='#webstatsModal'><i class="fas fa-chart-line"></i></a><?php if (isAdmin()) echo '&nbsp;•&nbsp;Page generated in ' . round((microtime(true)-$_SERVER["REQUEST_TIME_FLOAT"])*1000,2) . ' ms.';?>&nbsp;•&nbsp;Visual from <a href="https://www.flaticon.com/" title="Flaticon" target="_blank">Flaticon</a>, <a href="https://www.freepik.com/" title="Freepik" target="_blank">Freepik</a> and <a href="https://fontawesome.com/" title="Fontawesome" target="_blank">Fontawesome</a>&nbsp;•&nbsp;Made by <a href="https://www.pondja.com" class="text-danger">p0ndja</a></small>
            </div>
        </div>
    </div>
</footer><!--div class="loader"></div-->