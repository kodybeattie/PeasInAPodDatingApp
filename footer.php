<!--  
Filename: footer.php
Group: Group 05
Date Modified: 2017-11-04
Description: This is the footer for all pages on the site.
-->		
		<?php ob_flush(); ?>
			<footer id="footer">
				<div class="inner">
					<div class="flex">
						<div class="copyright">
							<?php echo displayCopyrightInfo();?>
							<a href="aup.php">Acceptable Use Policy</a>
							<a href="privacy-policy.php">Privacy Policy</a>
						</div>
			
						<!-- Links to social media -->
						<ul class="icons">
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-linkedin"><span class="label">linkedIn</span></a></li>
							<li><a href="#" class="icon fa-pinterest-p"><span class="label">Pinterest</span></a></li>
							<li><a href="#" class="icon fa-vimeo"><span class="label">Vimeo</span></a></li>
						</ul>
						<!-- Links to Validators -->
						<p class = "verify">
							<a href="http://validator.w3.org/check?uri=referer"><img
							src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a> 
							<a href="http://jigsaw.w3.org/css-validator/check/referer">
							<img style="border:0;width:88px;height:31px"
							src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
							alt="Valid CSS!" /></a>
						</p>
					</div>
				</div>
			</footer>
			
	<!-- Scripts -->
		<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
		<script src="../assets/js/skel.min.js" type="text/javascript"></script>
		<script src="../assets/js/util.js" type="text/javascript"></script>
		<script src="../assets/js/main.js" type="text/javascript"></script>

	</body>
</html>
			
