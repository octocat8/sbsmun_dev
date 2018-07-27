<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SBSMUN | ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
        $username = $_SESSION['username'];
        echo $username;
    ?>
    <a href="index.php?logout">Logout</a>
    <?php
        if (isset($_POST['sub_news'])) {
            $filetoupload = $_FILES["newsletter"];
            $path = mysqli_real_escape_string($conn, $filetoupload["name"]);
            $sql_add_newsletter = "INSERT INTO newsletters(filename) VALUES ('".$path. "');";
            $add_newsletter = mysqli_query($conn, $sql_add_newsletter);
            if($add_newsletter) {
                $target_dir = "../";
                $file_type = explode(".",$path);
                $file_ext = $file_type[1];
                $allowed = "pdf";
                if($file_ext = $allowed) {
                    if(move_uploaded_file($filetoupload["tmp_name"], $target_dir.$path)) {
                        echo "File Moved Congrats :)";
                    } else {
                        echo "Unable to move file";
                    }
                } else {
                    echo "filetype not supported";
                }
            } else {
                echo "could not add record";
            }
        }
    ?>
    <h1>ADD / DELETE FILE</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Newsletter: </label><input type="file" name="newsletter" required><br>
        <input type="submit" value="Submit" name="sub_news">
    </form>
    <?php
        if (isset($_POST["sub_link"])) {
            $news = $_POST["link_photos"];
            $link = mysqli_real_escape_string($conn, $news);
            $sql_add_link = "INSERT INTO links(link) VALUES ('".$link."');";
            // echo $sql_add_link;
            $add_link = mysqli_query($conn, $sql_add_link);
            if ($add_link) {
                echo "Yay";
            }
        }
    ?>
    <h1>ADD / DELETE Link</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Link: </label><input type="text" name="link_photos" required><br>
        <input type="submit" value="Submit" name="sub_link">
    </form>
</body>
</html>