<?php

require_once('db.php');
$db = new DB;
$db->query("SELECT * FROM `products`");
$products = $db->resultSet();
$db->close();
?>

<html>

<head>
    <title>Stripe Payment Integration in PHP</title>
    <link rel='stylesheet' href='style.css' type='text/css' media='all' />
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
        ?>
                <div class="container">
                    <div class="wrapper">
                        <div class='image'><img src='<?php echo $product['image']; ?> ' width="210                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  px" height="200px" />
                            <hr>
                        </div>
                        <div class='name'><?php echo $product['name']; ?></div>
                        <div class='price'>$<?php echo $product['price']; ?></div>
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_51Lx778CptsxFpI0xYlKtNdCQAlNS4aukjiyWjTMzwHwFl9hWELj3qMeePzckXGdyMdU2LfSabotQW2LzxPky2NGT007Xh8Cwy8" data-amount='<?php echo $product['price'] * 100; ?>' data-name='<?php echo $product['name']; ?>' data-image="https://stripe.com/img/documentation/checkout/marketplace.png" currency='usd' data-locale="auto">
                        </script>
                    </div>
                </div>

        <?php
            }
        }
        ?>
    </form>
</body>

</html>

<?php


require 'vendor/autoload.php';
if (!empty($products)) {
    foreach ($products as $product) {

        if (isset($_POST['stripeToken'])) {



            \Stripe\Stripe::setApiKey('sk_test_51Lx778CptsxFpI0xyzwSktUtOoTt8uVb5cQRqZMuX4KlUU7KJibGPvSz6ATH3fHNo4mHumvVdCsHHzxLNKqHG0GD005LD4A1mE');

            $token = $_POST['stripeToken'];
            $email = $_POST['stripeEmail'];

            $charge = \Stripe\Charge::create([
                'amount' => $product['price'] * 100,
                'currency' => 'usd',
                'source' => $token,

            ]);
            echo "<pre>";
            print_r($charge);
        }
    }
}
