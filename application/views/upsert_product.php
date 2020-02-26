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
			echo form_open(base_url('/product/upsert/'.$upt->id_product));
		?>
			<div class="row">
				<div class="form-group col">
					<label for="name">Nome Produto</label>
					<input type="hidden" name="id_product" value="<?php echo $upt->id_product ? $upt->id_product : ''; ?>" />
					<input type="text" class="form-control <?php if(form_error('name')) { echo 'is-invalid';} ?>" id="name" name="name" 
						value="<?php echo ($upt->name ? $upt->name : ((!$form_status || $form_alert == 'alert-danger') ? set_value('name') : '')); ?>" placeholder="Iphone Xs Plus">
					<?php if(form_error('name')): ?>
					<div class="invalid-feedback">
						<?php echo form_error('name'); ?>
					</div>
					<?php endif; ?>
				</div>
				<div class="form-group col">
					<label for="price">Preço</label>
					<input type="number" class="form-control <?php if(form_error('price')) { echo 'is-invalid';} ?>" id="price" name="price" 
						value="<?php echo ($upt->price ? $upt->price : ((!$form_status || $form_alert == 'alert-danger') ? set_value('price') : '')); ?>" placeholder="7.120.99" step="0.01" min="0">
					<?php if(form_error('price')): ?>
					<div class="invalid-feedback">
						<?php echo form_error('price'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="url">Url</label>
					<input type="text" class="form-control" id="url" name="url" 
						value="<?php echo ($upt->url ? $upt->url : ((!$form_status || $form_alert == 'alert-danger') ? set_value('url') : '')); ?>" placeholder="iphone-xs-plus">
				</div>
				<div class="form-group col">
					<label for="id_category">Categoria</label>
					<select id="id_category" name="id_category" class="form-control <?php if(form_error('id_category')) { echo 'is-invalid';} ?>">
						<option value="" <?php echo (!$form_status || $form_alert == 'alert-danger') && set_value('id_category') == "" ? 'selected="selected"' : ''; ?> >Selecione uma Categoria</option>
						<?php foreach($categories as $cat): ?>
						<option value="<?php echo $cat->id_category; ?>" <?php echo $upt->id_category == $cat->id_category || ((!$form_status || $form_alert == 'alert-danger') && set_value('id_category') == $cat->id_category) ? 'selected="selected"' : '';?> ><?php echo $cat->name; ?></option>
						<?php endforeach; ?>
					</select>
					<?php if(form_error('id_category')): ?>
					<div class="invalid-feedback">
						<?php echo form_error('id_category'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="description">Descrição</label>
					<textarea class="form-control" id="description" name="description" rows="4" maxlength="255"><?php 
						echo ($upt->description ? $upt->description : ((!$form_status || $form_alert == 'alert-danger') ? set_value('description') : ''));
					?></textarea>
				</div>
			</div>

			<button type="submit" class="btn btn-primary"><?php echo $btn; ?></button>
			<button type="button" class="btn btn-warning float-right" onclick="window.open('<?php echo base_url("/product"); ?>', '_self');">Voltar</button>
		<?php echo form_close();?>

	</div>
</main>