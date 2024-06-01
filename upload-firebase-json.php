<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("location:index.php");
    return false;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Upload Firebase Json | <?= ucwords($_SESSION['company_name']) ?> Admin Panel  </title>
        <?php include 'include-css.php'; ?>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php include 'sidebar.php'; ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <br />
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <?php 
                                
                                    $target_path = getcwd() . DIRECTORY_SEPARATOR;
                                    $file = $target_path . '/firebase/firebase_credentials.json';

                                    $status = '';
                                    if(file_exists($file)){
                                        $status = true;
                                    }else{
                                        $status = false;
                                    }
                                
                                ?>    

                                   
                                <div class="x_title">
                                    <h2>Upload Firebase Json</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    
                                    <form id="frm_update"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                        <input type="hidden" id="upload_firebase_json" name="upload_firebase_json" required value='1'/>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Current File Status&nbsp;: <?= ($status == true) ? '<small class="text-success bg-success">File Exists</small>' : '<small class="text-danger bg-danger">File Not Exists,Please Upload</small>' ?></label>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">                                            
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label>Update json <small class="text-danger">Only json file allow</small></label>
                                               <input name="file" type="file" accept=".json" required class="form-control">
                                               
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <button type="submit" id="submit_btn" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-6" style ="display:none;" id="result">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <?php include 'footer.php'; ?>
            <!-- /footer content -->
        </div>

        <!-- jQuery -->
         <script type="text/javascript">
               $('#frm_update').validate({});
         </script>
        <script type="text/javascript">
            $('#frm_update').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($("#frm_update").validate().form()) {
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        beforeSend: function () {
                            $('#submit_btn').html('Please wait..');
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            $('#result').html(result);
                            $('#result').show();
                            $('#submit_btn').html('Submit');
                            setTimeout(function () {
                               location.reload();
                            }, 4000);                            
                        }
                    });
                }
            });
        </script>
    </body>
</html>