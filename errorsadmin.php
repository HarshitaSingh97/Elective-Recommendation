<?php  if (count($errorsadmin) > 0) : ?>
  <div class="error">
  	<?php foreach ($errorsadmin as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>
