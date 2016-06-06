<?php

require_once('stripe-php/init.php');

\Stripe\Stripe::setApiKey('sk_test_lPVWZh9bw2AWQTL1arQ4nInj');

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$amount = $_POST['amount'];
$name = $_POST['name'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = \Stripe\Charge::create(array(
  		"amount" => $amount, 
  		"currency" => "usd",
  		"source" => $token,)
	);

	//email the purcahse and code info to your email
	mail("jorge.andre290992@gmail.com","Purchase done","amount: $amount , name: $name");

	// create a json output with completion variable, (this will be read from the ios app as response)
	$json = array(
		'completion' => 'done'
	);
	echo json_encode($json);
	
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
  
  $errorMessage = $e->getMessage();
  
  $json = array(
		'completion' => $errorMessage
	);
	echo json_encode($json);
	
}
	
?>