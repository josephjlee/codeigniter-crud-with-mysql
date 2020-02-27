<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container">

		<h1 class="my-5"><?php echo $h1; ?></h1>
		
		<?php 
			if($form_status):
			echo '
				<div class="alert '.$form_alert.'" role="alert">
					'.$form_msg.'
				</div>
			';
			endif;

			# Cria tag form de abertura com action para form
			echo form_open(base_url('/category/upsert/'.$upt->id_category));
		?>
			<div class="row">
				<div class="form-group col">
					<label for="name">Nome Categoria</label>
					<input type="hidden" name="id_category" value="<?php echo $upt->id_category ? $upt->id_category : ''; ?>" />
					<input type="text" class="form-control <?php if(form_error('name')) { echo 'is-invalid';} ?>" id="name" name="name" 
						value="<?php echo ($upt->name ? $upt->name : ((!$form_status || $form_alert == 'alert-danger') ? set_value('name') : '')); ?>" placeholder=Celulares>
					<?php if(form_error('name')): ?>
					<div class="invalid-feedback">
						<?php echo form_error('name'); ?>
					</div>
					<?php endif; ?>
				</div>
				<div class="form-group col">
					<label for="url">Url</label>
					<input type="text" class="form-control <?php if(form_error('url')) { echo 'is-invalid';} ?>" id="url" name="url" 
						value="<?php echo ($upt->url ? $upt->url : ((!$form_status || $form_alert == 'alert-danger') ? set_value('url') : '')); ?>" placeholder="celulares">
					<?php if(form_error('url')): ?>
					<div class="invalid-feedback">
						<?php echo form_error('url'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php echo $btn; ?></button>
			<button type="button" class="btn btn-warning float-right" onclick="window.open('<?php echo base_url("/category"); ?>', '_self');">Voltar</button>
		<?php echo form_close();?>

	</div>
</main>