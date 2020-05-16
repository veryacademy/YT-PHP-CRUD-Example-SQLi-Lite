<?php
require_once 'functions.php';
include ('header.php');
$row = update_get();
?>

     <div class="container">
        <div class="col pt-5">
            <h2>Update Data</h2>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id'];?>" method="post">
            <div class="form-group">
            <label for="update_title">Title</label>
            <input type="text" name="update_title" class="form-control" id="update_title" placeholder="Title" value="<?php echo $row['title'];?>" required>
            <small class="form-text text-muted">Make sure your title is unique</small>
            </div>
            <div class="form-group">
            <label for="update_content">Content</label>
            <textarea class="form-control" id="update_content" name="update_content" rows="4" cols="50" value="ad" required><?php echo $row['content'];?>
            </textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

<?php
include ('footer.php');
?>