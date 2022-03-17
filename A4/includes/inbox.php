<?php if (!isset($_REQUEST['email'])) { ?>
	<h2>Inbox</h2>
	<ul class="list-group">
		<?php generate_email_list(); ?>
	</ul>
<?php } else { ?>
	<h2>Email</h2>
	<?php display_email($_REQUEST['email']);
} ?>