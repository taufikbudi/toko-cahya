
<!DOCTYPE html>
<html>
<head>
    <title>Files upload</title>

    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form">

            <form name="uploader" action="process.php" method="POST" enctype="multipart/form-data">

                <input type="file" name="file">

                <button type="submit">Upload</button>
            </form>

        </div>
    </div>
</body>
</html>