</div>
        <footer class="row">
            <?php global $tp_options;; ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong><?php echo $tp_options['footer-name'];?></strong></h2>
                </div>
                <div class="panel-body text-center">
                    <?php echo $tp_options['footer-address'];?>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="<?php echo get_template_directory_uri(); ?>/asset/app/js/app.bundle.js"></script>
    <?php wp_footer(); ?>
</body>

</html>
</div>