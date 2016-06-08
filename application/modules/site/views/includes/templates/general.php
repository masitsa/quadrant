<!DOCTYPE html>
<html class="no-js" lang="en">
	<?php echo $this->load->view('includes/header', '', TRUE);?>
	
    <body>
    	<!-- LOADER ===========================================-->
        <div id="loader">
            <div class="loader">
                <div class="position-center-center">
                	<div id="preloader6"> <span></span> <span></span> <span></span> <span></span> </div>
                </div>
            </div>
        </div>
		
        <div id="wrap">
			<?php echo $this->load->view('includes/navigation', '', TRUE);?>
            <?php echo $content; ?>
            <?php echo $this->load->view('includes/footer', '', TRUE);?>
		</div>
        
        <!-- JavaScripts --> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/bootstrap.min.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/own-menu.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/flexslider/jquery.flexslider-min.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/jquery.isotope.min.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/owl.carousel.min.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/vendors/jquery.sticky.js"></script>
        
        <!-- SLIDER REVOLUTION 4.x SCRIPTS  --> 
        <script type="text/javascript" src="<?php echo base_url().'assets/themes/infinity/'?>rs-plugin/js/jquery.themepunch.tools.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url().'assets/themes/infinity/'?>rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
        <script src="<?php echo base_url().'assets/themes/infinity/'?>js/main.js"></script>
        <script type="text/javascript">
			$( document ).on( "submit", "form#contact-form", function(e) 
			{
				var formData = new FormData(this);
				
				$.ajax({
					url: '<?php echo site_url();?>site/contact_us/book_appointment',
					data: formData,
					processData: false,
					contentType: false,
					type: 'POST',
					dataType: "json",
					success: function(data)
					{
						alert(data.message);
						if(data.status == 'success')
						{
							$( "form#contact-form" )[0].reset();
						}
						
						else
						{
							
						}
					}
				});
				
				return false;
			});
		</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75783930-1', 'auto');
  ga('send', 'pageview');

</script>
        <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/56f3a13cd68ada7f0fa9f91e/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
	</body>
</html>