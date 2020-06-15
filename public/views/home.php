<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Automoto Replacer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
</head>
<body>
<div class="container pt-5">

    <div class="jumbotron">
        <?php 
        if (isset($_POST['replacer']) && !empty($_POST['replacer'])) {
            $uploaddir = __DIR__ . '/../uploads/';
            if (!is_dir($uploaddir)) {
                mkdir($uploaddir, 0777);
            }
            $uploadfile = $uploaddir . basename($_FILES['file_to_upload']['name']);
            if (move_uploaded_file($_FILES['file_to_upload']['tmp_name'], $uploadfile)) {
                $content = file_get_contents($uploadfile);
                $content = bin2hex($content);
                foreach ($_POST['replacer']['text_to_replace'] as $i => $replacer)
                {
                    $to_replace = trim($replacer);
                    $to_replace = str_replace(' ','',$to_replace);
                    $remplacement = trim($_POST['replacer']['replacement'][$i]);
                    $remplacement = str_replace(' ','',$remplacement);
                    $content = str_ireplace($to_replace,$remplacement,$content);
                }
                $new_file = $uploaddir . "/NEW_FILE_" . date('YmdHis') . ".data";

                file_put_contents($new_file, $content);
                print "<div class=\"alert alert-success\" role=\"alert\">
                    File upload done successfully you can download the replaced file 
                    <a href='" . $_SERVER['HTTP_REFERER'] . "uploads/" . basename($new_file) . "' download='' target='_blank'>".basename($new_file)."</a>
                </div>";
            } else {
                print "<div class=\"alert alert-danger\" role=\"alert\">File not uploaded successfully</div>";
            }
        }
        ?>
        <div class="page-header">
            <h1>Automoto Replacment</h1><br>
        </div>
        <form class="navbar-form navbar-left" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>File to update</label><br>
                <input type="file" placeholder="select file from local disk" name="file_to_upload" required>
            </div>
            <div id="all_text">
                <div class="row group_text" id="group_text">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Text to replace</label>
                            <input type="text" class="form-control" placeholder="Insert text to replace in file"
                                   name="replacer[text_to_replace][]" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Replacement text</label>
                            <input type="text" class="form-control" placeholder="Insert text to search in file"
                                   name="replacer[replacement][]" required>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-top: 32px;">
                        <button class="btn btn-info" id="addinputs" onclick="duplicateInput(event)">Add</button>
                        <button class="btn btn-danger" id="addinputs" onclick="removeInput(event)">Del</button>
                    </div>
                </div>
            </div>


            <div class="form-group pull-left" style="text-align: end;padding-top: 10px;">
                <button class="btn btn-success">Launch Treatment</button>
            </div>
        </form>
    </div>
</div>
<script  type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function duplicateInput(event) {
        event.preventDefault();
        var $clone = $("#group_text").clone(true);
        $("#all_text").append($clone);
    }
    function removeInput(event) {
        event.preventDefault();
        if($(".group_text").length <=1) {
            return;
        }
        $(event.target).closest("#group_text").remove();
    }
</script>
</body>
</html>
