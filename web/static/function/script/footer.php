
<div id="testMobile" class="d-none d-lg-block"></div>
<script>
    function backToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
    function hashtag() {
        if (window.location.hash) return decodeURIComponent(window.location.hash.substring(1))
        return null;
    }
</script>

<script type="text/javascript">
    // Tooltips Initialization
    $(document).ready(function () {
        $('.mdb-select').materialSelect();
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn-floating').unbind('click');
        $('.fixed-action-btn').unbind('click');
        //$(".loader").delay(1500).fadeOut("slow");

        attachFooter();
        fixedArticle();
    });

    $('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').each(function (element, i) {
        if ((element.value !== undefined && element.value.length > 0) || $(this).attr('placeholder') !== undefined) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
        $(this).trigger("change");
    });

        
    const resizeObserver = new ResizeObserver(entries => attachFooter());
    resizeObserver.observe(document.body);

    let attach = false;
    function attachFooter() {
        let footerHeight = $("#footer").height();
        let bodyHeight = $(document.body).height();
        let windowHeight =  $(window).height();
        if (!attach && (bodyHeight <= windowHeight)) {
            attach = true;
            $('#footer').attr('style', 'position: fixed!important; bottom: 0px;');
        } else if (attach && (bodyHeight + footerHeight > windowHeight)) {
            attach = false;
            $('#footer').removeAttr('style');
        }
    }

    function fixedArticle() {
        //let articleRender = $("#articleRenderer");
        $("#articleRenderer img").each(function() {
            $(this).addClass('z-depth-1 mb-1 imgArticleRenderer');
        });
        // $('.imgArticleRenderer').each(function() {
        //         $(this).click(function() {
        //             $('.imagepreview').attr('src', $(this).attr('src'));
        //             $("#picPreviewModal").modal('show');
        //         });
        //     });
    }

    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
    });

    $('.carouselsmoothanimated').on('slide.bs.carousel', function(e) {
        $(this).find('.carousel-inner').animate({
            height: $(e.relatedTarget).height()
        }, 500);
    });
</script>
<?php mysqli_close($conn); ?>