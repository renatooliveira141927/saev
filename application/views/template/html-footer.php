

<!-- Footer -->
<footer class="footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <?php 
                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                    date_default_timezone_set('America/Sao_Paulo');

                    $date_oct = new DateTime();
                    $data_comum = $date_oct->format('Y');
                
                ?>
                © <?php echo $data_comum ?>. ASSOCIACAO BEM COMUM.
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

</div>
</div>

</body>
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<!-- jQuery  -->

    <script src="<?=base_url('assets/js/detect.js'); ?>"></script>
    <script src="<?=base_url('assets/js/fastclick.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.blockUI.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.slimscroll.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>

    <script src="<?=base_url('assets/js/jquery.core.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.app.js'); ?>"></script>

    <script src="<?=base_url('assets/js/modernizr.min.js'); ?>"></script>

</html>