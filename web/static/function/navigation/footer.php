<footer class="footer mt-3" id="footer">
    <div class="container">
        <div class="row pt-3">
            <div class="col-12 text-center mb-2">
                <h6 class="text-white"><a href="/privacy/">Privacy Policy</a>&nbsp;•&nbsp;<?php if (!isLogin()) { ?><a href="../login/">Manage</a><?php } else { ?><a class="md-light" href="../logout/">Logout</a><?php } ?></h6>
                <h6 class="text-white mt-2">Copyright 2025 - 2026 &copy; Department of Chemical and Environmental Engineering, Faculty of Engineering, Ubon Ratchathani University, Thailand. All Right Reserved.</h6>
                <small class='text-white'>For any inquiries, please contact us at <a href="mailto:tiche2026@ubu.ac.th"><b>tiche2026@ubu.ac.th</b></a>, where we will respond promptly to your messages.</small>
                <br><small class='text-muted'>Please note that <b>tiche2026.noreply@gmail.com</b> is used exclusively for system notifications and confirmations. Any messages sent to this address will not receive a response.</small><br>
                <small class="text-muted"><?php if (isAdmin()) echo 'Page generated in ' . round((microtime(true)-$_SERVER["REQUEST_TIME_FLOAT"])*1000,2) . ' ms.&nbsp;•&nbsp;';?>Visual from <a href="https://www.flaticon.com/" title="Flaticon" target="_blank">Flaticon</a>, <a href="https://www.freepik.com/" title="Freepik" target="_blank">Freepik</a> and <a href="https://fontawesome.com/" title="Fontawesome" target="_blank">Fontawesome</a>&nbsp;•&nbsp;Made by <a href="https://www.pondja.com" class="text-danger">p0ndja</a></small>
            </div>
        </div>
    </div>
</footer><!--div class="loader"></div-->