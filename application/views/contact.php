<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container">

		<h1 class="my-5"><?php echo $h1; ?></h1>
		<?php 

			if($form_status):
			echo '
				<div class="alert '.$email_alert.'" role="alert">
					'.$email_msg.'
				</div>
			';
			endif;

			# Cria tag form de abertura com action para form
			echo form_open(base_url('/contact')); 
		?>
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" class="form-control <?php if(form_error('name')) { echo 'is-invalid';} ?>" name="name" id="name" value="<?php echo !$form_status ? set_value('name') : ''; ?>" placeholder="Fabio Dias">
				<?php if(form_error('name')): ?>
				<div class="invalid-feedback">
					<?php echo form_error('name'); ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control <?php if(form_error('email')) { echo 'is-invalid';} ?>" name="email" id="email" value="<?php echo  !$form_status ? set_value('email') : ''; ?>" placeholder="nome@exemplo.com.br">
				<?php if(form_error('email')): ?>
				<div class="invalid-feedback">
					<?php echo form_error('email'); ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="subject">Assunto</label>
				<select class="form-control <?php if(form_error('subject')) { echo 'is-invalid';} ?>" name="subject" id="subject">
					<option value="" <?php echo  !$form_status && set_value('subject') == "" ? 'selected="selected"' : ''; ?>>Selecione um assunto</option>
					<option value="feedback" <?php echo !$form_status && set_value('subject') == "feedback" ? 'selected="selected"' : ''; ?>>Feedeback</option>
					<option value="duvida" <?php echo !$form_status && set_value('subject') == "duvida" ? 'selected="selected"' : ''; ?>>Dúvida</option>
					<option value="reclamacao" <?php echo !$form_status && set_value('subject') == "reclamacao" ? 'selected="selected"' : ''; ?>>Reclamação</option>
					<option value="sugestao" <?php echo !$form_status && set_value('subject') == "sugestao" ? 'selected="selected"' : ''; ?>>Sugestão</option>
					<option value="suporte" <?php echo !$form_status && set_value('subject') == "suporte" ? 'selected="selected"' : ''; ?>>Suporte</option>
				</select>
				<?php if(form_error('subject')): ?>
				<div class="invalid-feedback">
					<?php echo form_error('subject'); ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="message">Sua mensagem</label>
				<textarea class="form-control" name="message" id="message" rows="3" ><?php echo  !$form_status ? set_value('message') : ''; ?></textarea>
			</div>

			<button type="submit" class="btn btn-primary">Enviar</button>
			<?php echo form_close();?>
	</div>
</main>