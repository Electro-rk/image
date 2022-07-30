
<?php
error_reporting(0);
 
$msg = "";
 
// If upload button is clicked ...
if (isset($_POST['upload'])) {
 
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;
	$head = $_POST['head'];
    $db = mysqli_connect("localhost", "root", "", "db_image");
 
	$deta = "SELECT * FROM `tb_image` WHERE `filename` LIKE '$filename'";
	//echo "<pre>";print_r($deta);
	
	$result_new = mysqli_query($db,$deta);
	//echo "<pre>";print_r($result_new);
	$data1 = mysqli_fetch_assoc($result_new);
	
		if ($data1['filename'] == $filename){
			echo "<script>alert('This is alredy selected');</script>";
		}
		else{
		$sql = "INSERT INTO tb_image (filename , heading) VALUES ('$filename','$head')";
		mysqli_query($db, $sql);
 
    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
		}
	
    // Get all the submitted data from the form
    

// echo "<pre>";print_r($sql);
 
    // Execute query
    
 
}
?>

<!DOCTYPE html>
<html>
   
<head>
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
	<style>
	
*{
    margin: 0;
      padding: 0;
      box-sizing: border-box;
}
 
#content{
    width: 50%;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    border: 1px solid #cbcbcb;
}
form{
    width: 50%;
    margin: 20px auto;
}
 
#display-image{
    width: 100%;
    justify-content: center;
    padding: 5px;
    margin: 15px;
}
img{
    margin: 5px;
    width: 350px;
    height: 250px;
}
	
	
	
	</style>
</head>
   
<body>
    <div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>
			<div class="form-group">
                <input class="form-control" type="text" name="head" value="" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
    </div>
    <div id="display-image">
    <?php
        $query = " select * from tb_image order by id desc limit 1";
		//echo"<pre>";print_r($query);die;
        $result = mysqli_query($db, $query);
		//echo"<pre>";print_r($result);die;
 
        while ($data = mysqli_fetch_assoc($result)) {
			
			//echo "<pre>";print_r($data);
    ?>
        <img src="./image/<?php echo $data['filename']; ?>">
		<button type="button" name="delete">delete here </button>
		<h2><?php echo $data['heading']; ?></h2>
 
    <?php
        }
    ?>
    </div>
</body>
 
</html>
