<?php
    include_once './helper.php';

   $email = $error = '';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email'])) {
        $error = 'Please Enter The Email';
    } else {
        $email = purging($_POST['email']);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please Enter Validation Email';
        }

        try {
            $connection = connect();

            $stmt = $connection->prepare('INSERT INTO newletters (email) VALUES (:email)');
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $error = 'Success To Add Email';
        }
        catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }
   }
?>
<!--/newsletter -->
<section class="newsletter-w3pvt py-5">
    <div class="container py-md-5">
        <form method="post" action="#">
            <p class="text-center">Subscribe to the Handbags Store mailing list to receive updates on new arrivals, special offers and other discount information.</p>
            <div class="row subscribe-sec">
                <div class="col-md-9">
                    <input type="email" class="form-control" id="email" placeholder="Enter Your Email.." name="email" required="" value="<?php echo $email; ?>">
                    <?php echo $error; ?>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn submit">Subscribe</button>
                </div>
            </div>
        </form>
    </div>
</section>
<!--//newsletter -->