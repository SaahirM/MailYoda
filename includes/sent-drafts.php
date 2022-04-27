<?php if (!isset($_REQUEST['email'])) { ?>
	<h2>Outbox</h2>
	<ul class="list-group">
		<?php generate_sentdrafts_email_list(); ?>
	</ul>
<?php } else { ?>
	<h2>Email</h2>
	<?php display_sentdrafts_email($_REQUEST['email']);
} ?>