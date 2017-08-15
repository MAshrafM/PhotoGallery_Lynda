<?php 
  require_once("../includes/initialize.php");
?>
<?php
  $photos = Photograph::find_all();
?>
<?php include_layout_template('header.php'); ?>
  <h2>Gallery</h2>
  <?php echo output_message($message); ?>
  <?php foreach($photos as $photo): ?>
    <div style="float:left; margin-left:20px;">
      <img src="<?php echo $photo->image_path(); ?>" width="200" />
      <p><?php echo $photo->caption; ?></p>
    </div>
  <?php endforeach; ?>
<?php include_layout_template('footer.php'); ?>