<?php 
  require_once("../includes/initialize.php");
  
  $page = !empty($_GET["page"]) ? (int)$_GET["page"] : 1;
  $per_page = 6;
  
  $total_count = Photograph::count_all();
  
  $photos = Photograph::find_all();
?>
<?php include_layout_template('header.php'); ?>
  <h2>Gallery</h2>
  <?php foreach($photos as $photo): ?>
    <div style="float: left; margin-left:20px;">
      <a href="photo.php?id=<?php echo $photo->id; ?>">
        <img src="<?php echo $photo->image_path(); ?>" width="200" />
      </a>
    </div>
  <?php endforeach; ?>
<?php include_layout_template('footer.php'); ?>