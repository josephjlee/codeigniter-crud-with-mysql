<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container">

		<?php if($msg_type): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_label; ?>
		</div>
		<?php endif; ?>

		<h1 class="my-5"><?php echo $h1; ?></h1>

		<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Categoria</th>
				<th scope="col">Url</th>
				<th scope="col">Criado em:</th>
				<th scope="col">Editado em:</th>
				<th scope="col">
					<button type="button" class="btn btn-sm btn-outline-success" onclick="window.open('<?php echo base_url("/category/upsert"); ?>', '_self');"><i class="fas fa-plus"></i> Categoria</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($categories as $item): ?>
			<tr>
				<th scope="row"><?php echo $item->id_category; ?></th>
				<td><?php echo $item->name; ?></td>
				<td><?php echo $item->url; ?></td>
				<td><?php echo date('d/m/Y \à\s H:i:s', strtotime($item->createdAt)); ?></td>
				<td><?php echo date('d/m/Y \à\s H:i:s', strtotime($item->updatedAt)); ?></td>
				<td>
					<button type="button" class="btn btn-sm btn-outline-danger" onclick="window.open('<?php echo base_url("/category/delete/".$item->id_category); ?>', '_self');"><i class="far fa-trash-alt"></i></button>
					<button type="button" class="btn btn-sm btn-outline-primary" onclick="window.open('<?php echo base_url("/category/upsert/".$item->id_category); ?>', '_self'); return false;"><i class="fas fa-pencil-alt"></i></button>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>

	</div>
</main>