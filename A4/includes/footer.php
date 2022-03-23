			<!-- JS | Bootstrap from https://getbootstrap.com/ @ 18:07 11-Mar-2022 -->
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

		
		</main>
		<!-- Footer slightly adapted from A3 footer -->
		<footer class="container-fluid py-2">
			<div class="row">
				<div class="col-12 col-sm-8">
					<p>&copy; <?php echo date("Y"); ?></p>
					<p>MailYoda: Simple and secure, it is; a way to securely send messages.</p>
				</div>
				<div class="col-12 col-sm-4 d-sm-flex justify-content-end align-items-center">
					<ul class="list-group text-center text-sm-end">
						<li class="list-group-item border-0 px-0"><a href="#">Privacy Policy</a></li>
						<li class="list-group-item border-0 px-0"><a href="#">Terms of Use</a></li>
						<li class="list-group-item border-0 px-0"><a href="#">Contact Us</a></li>
					</ul>
				</div>
			</div>
		</footer>

	</body>
</html>
<?php ob_end_flush(); ?>