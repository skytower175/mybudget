<?php if ($page->useJQuery){ ?>
<!-- Import jquery and JS files -->
<script src="jquery/jquery-3.1.0.min.js"></script>
<?php } ?>
<?php if ($page->useBootstrap){ ?>
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php } ?>
<script src="js/responsiveslides.min.js"></script>

<!-- this is to start img slider, doesn't work when in "Script" for some reason?? -->
<script>
  $(function() {
    $(".rslides").responsiveSlides();
  });

</script>

<?php 
if (getenv('USE_ANALYTICS') == 1){
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86647040-1', 'auto');
  ga('send', 'pageview');

</script>
<?php
}
?>
