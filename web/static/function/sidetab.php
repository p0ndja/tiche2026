<div class="card mb-3 <?php if (!isset($_GET['notAutoHide'])) { echo "d-none d-lg-block"; } ?>">
    <div class="card-body">
        <h4 class="card-title font-weight-bold text-md">Important Dates</h4>
        <small>
        <p class='text-muted'><b>Abstract Submission</b><br>
            <span style='color:red;text-decoration:line-through'>
                <span>until March 15, 2026</span><br>
            </span>
            <span>until April 27, 2026</span>&nbsp;<span class="badge badge-danger">CLOSED</span>
        </p>
        <p class='text-muted'><b>Notification of Acceptance</b><br>
            <span style='color:red;text-decoration:line-through'>
                <span>until April 15, 2026</span><br>
            </span>
            <span>until April 30, 2026</span>
        </p>
        <p class='text-muted'><b>Early Bird Registration</b><br>   <span>until March 31, 2026</span></p>
        <p class='text-muted'><b>Full Delegate Registration</b><br><span>until April 30, 2026</span></p>
        <p class='text-muted'><b>Full Paper Submission (Proceedings)</b><br><span>until April 30, 2026</span></p>
        </small>
        <p><b style="color:#0D47A1">Conference Date</b><br>           <span>June 9-10, 2026</span></p>
    </div>
    <!-- <div class="mb-3" style="margin-top: -2.5rem;">
    <script src="https://cdn.logwork.com/widget/countdown.js"></script>
    <a href="https://logwork.com/countdown-timer" class="countdown-timer" data-timezone="Asia/Bangkok" data-date="2026-06-09 08:30">&nbsp;</a>
    </div> -->
</div>
<!-- <div class="card card-body mb-3 <?php if (!isset($_GET['notAutoHide'])) { echo "d-none d-lg-block"; } ?>">
    <h4 class="card-title font-weight-bold text-md">Announcement</h4>
    <div class="row">
    <?php
        $_GET['page'] = 1;
        $_GET['category'] = "ประชาสัมพันธ์";
        $_GET['maximum'] = 3;
        $_GET['maxPerLine'] = 1;
        $_GET['LM2VA'] = true;
        include '../endpoint/post_load.php';
    ?>
    </div>
</div> -->
