<?php 
require_once("../../includes/initialize.php");
  
if(!$session->is_logged_in()){ redirect_to("login.php"); }

$photos = Photograph::find_all();
?>
<?php include_layout_template('admin_header.php'); ?>
  <h2>Photographs</h2>
  <?php echo output_message($message); ?>
  <table class="bordered">
    <tr>
      <td>Image</td>
      <td>Filename</td>
      <td>Caption</td>
      <td>Size</td>
      <td>Type</td>
    </tr>
    <?php foreach($photos as $photo): ?>
      <tr>
        <td><img src="../<?php echo $photo->image_path(); ?>" width="100" /></td>
        <td><?php echo $photo->filename; ?></td>
        <td><?php echo $photo->caption; ?></td>
        <td><?php echo $photo->size_as_text(); ?></td>
        <td><?php echo $photo->type; ?></td>
      </tr>
    <?php endforeach; ?>
  <table>
  <br />
  <a href="photo_upload.php">Upload a new photograph</a>
<?php include_layout_template('admin_footer.php'); ?>