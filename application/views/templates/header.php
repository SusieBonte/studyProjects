<html>
        <head>
                <title>Quiz Tool</title>
				<link rel="stylesheet" href="https://bootswatch.com/readable/bootstrap.min.css">
				<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
				<script src="http://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        </head>
        <body>

		
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo base_url(); ?>">Quiz Tool</a>
				</div>
				<div id="navbar">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo base_url(); ?>">Home</a></li>
						<li><a href="<?php echo base_url(); ?>about">About</a></li>
						<li><a href="<?php echo base_url(); ?>tests">Tests</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if(!$this->session->userdata('logged_in')) : ?>
							<li><a href="<?php echo base_url(); ?>users/login">Login</a></li>
							<li><a href="<?php echo base_url(); ?>users/register">Register</a></li>
						<?php endif; ?>
						<?php if($this->session->userdata('logged_in')) : ?>
							<li><a href="<?php echo base_url(); ?>users/logout">Logout</a></li>
						<?php endif; ?>
						<?php if($this->session->userdata('privy') == 'admin') : ?>
							<li><a href="<?php echo base_url(); ?>tests/create">Edit Tests</a></li>
							
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class ="container">
			<?php if($this->session->flashdata('user_registered')): ?>
				<?php echo '<p class="alert alert-succes">'.$this->session->flashdata('user_registered').'</p>' ;?>			
			<?php endif; ?>
			
			<?php if($this->session->flashdata('login_failed')): ?>
				<?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>' ;?>			
			<?php endif; ?>		

			<?php if($this->session->flashdata('user_loggedin')): ?>
				<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>' ;?>			
			<?php endif; ?>		

			<?php if($this->session->flashdata('user_loggedout')): ?>
				<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>' ;?>			
			<?php endif; ?>	
			

