<?php
    require_once(dirname(__FILE__) . "/../../helper.php");
    require_once(getPath("/database.php"));
    require_once(getPath("/admin/auth.php"));
    require_once(getPath("/admin/validator.php"));

    auth();

    try {
        connect();

        $eId = validate('id', 'request', 'required', $id);

        if (hasErrors($eId)) {
            redirect('404.html');
        }

        $user = query('SELECT * FROM users WHERE id=:id', array(
            ':id' => $id
        ));

        if (count($user) == 0) {
            redirect('404.html');
        }

        $uuPermissions = query('SELECT * FROM permissions WHERE user=:id', array(
            ':id' => $id
        ));
        
        $username = $password = $confirmPassword = $upermissions = NULL;
        $eUsername = $ePassword = $eConfirmPassword = $eUPermissions = [];
        $actions = query('SELECT actions.name as name FROM actions GROUP BY actions.name ORDER BY name');
        $permissions = query('SELECT actions.id AS id, objects.name AS object_name, actions.name AS action_name FROM actions INNER JOIN objects ON actions.object = objects.id ORDER BY object_name, action_name');

        $username = $user[0]['username'];
        for($i = 0, $size = count($uuPermissions), $upermissions = array(); $i < $size; $i++ ) {
            $upermissions[count($upermissions)] = $uuPermissions[$i]['action'];
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            connect();

            $eUsername = validate('username', 'post', 'required', $username);
            $user = query('SELECT * FROM users WHERE username=:username AND NOT id=:id', array(
                'username' => $username,
                ':id' => $id
            ));

            if (count($user) > 0) {
                $eUsername[count($eUsername)] = 'The Username is exits';
            }

            $ePassword = validate('password', 'post', 'required', $password);
            $eConfirmPassword = validate('confirmPassword', 'post', 'required', $confirmPassword);
            if ($password != $confirmPassword) {
                $eConfirmPassword[count($eConfirmPassword)] = 'Please Sure Confirm Password Equal Password';
            }

            if (isset($_POST['permissions']) && is_array($_POST['permissions'])) {
                $state = TRUE;

                for ($i = 0, $size = count($_POST['permissions']); $i < $size; $i++) {
                    
                }

                $eUPermissions = [];
                $upermissions = $_POST['permissions'];
            }
            else {
                $eUPermissions = [];
                $upermissions = [];
            }



            if (!(hasErrors($eUsername) || hasErrors($ePassword) ||
                hasErrors($eConfirmPassword) || hasErrors($eUPermissions))) {        
                    query('UPDATE users SET username=:username, password=:password WHERE id=:id', array(
                        ':username' => $username,
                        ':password' => $password,
                        ':id' => $id
                    ));

                    query('DELETE FROM permissions WHERE user=:id', array(
                        ':id' => $id
                    ));

                    for ($i = 0, $size = count($upermissions); $i < $size; $i++) {
                       query('INSERT INTO permissions(id, `user`, action) VALUES(NULL, :user, :action)', array(
                            ':user' => $id,
                            ':action' => $upermissions[$i]
                       ));
                    }

                    echo "Success";
            }
        }
        else {
            
        }
    } catch (PDOException $ex) {
    }


    function isPermission($id, &$permissions) {
        $state = FALSE;
        for ($i = 0, $size = count($permissions); $i < $size; $i++) {
            if ($id == $permissions[$i]) {
                $state = TRUE;
                break;
            }
        }

        return $state;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <?php include '../layouts/sidebar.php'; ?>


        <!-- Content Start -->
        <div class="content">



            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Edit Product</h6>
                            <form method="post" action="<?php echo purging($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                                <input name="id" type="hidden" value="<?php echo $id; ?>" />
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input name="username" type="text" class="form-control" value="<?php echo $username; ?>">
                                    </div>
                                    <?php showErrors($eUsername); ?>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control" id="inputPassword3" value="<?php echo $password ?>">
                                    </div>
                                    <?php showErrors($ePassword); ?>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input name="confirmPassword" type="password" class="form-control" id="inputPassword3" value="<?php echo $confirmPassword; ?>">
                                    </div>
                                    <?php showErrors($eConfirmPassword); ?>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <?php for ($i = 0, $size = count($actions); $i < $size; $i++) { ?>
                                                <th scope="col"><?php echo ucfirst($actions[$i]['name']); ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for (
                                            $i = 0, $sizep = count($permissions), $cObject = $permissions[0]['object_name'];
                                            $i < $sizep;
                                            $i++
                                        ) {
                                        ?>
                                            <tr>
                                                <td><?php echo ucfirst($cObject); ?></td>
                                                <?php
                                                for ($j = 0, $sizea = count($actions); $j < $sizea; $j++) {
                                                    if ($actions[$j]['name'] == $permissions[$i]['action_name'] ) { ?>
                                                        <td><input name="permissions[]" type="checkbox" value="<?php echo $permissions[$i]['id']; ?>" <?php echo isPermission($permissions[$i]['id'], $upermissions) ? 'checked' : ''; ?>></td>
                                                    <?php
                                                        if ($i + 1 < $sizep) {
                                                            $incr = true;
                                                            $cObject = $permissions[++$i]['object_name']; 
                                                        }
                                                        else {
                                                            $incr = false;
                                                            break;
                                                        }
                                                    } else { ?>
                                                        <td></td>
                                                <?php }
                                                }

                                                $incr ? $i--: $i;

                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php showErrors($eUPermissions); ?>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>