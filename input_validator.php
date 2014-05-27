<?php

/**
 * 	get the post variables from form input 
 */
$first_name = $_POST['first_name']; 
$last_name = $_POST['last_name']; 
$street_address = $_POST['street_address'];
$city = $_POST['city'];
$state = $_POST['state']; 
$zip = $_POST['zip']; 
$phone = $_POST['phone'];



/**
 *  this file contains 3 arrays
 *  $us_states : all the US state abbriviations and names in a 'key' => 'value' format
 *  $canadian_provences : all the Canadian provence abbriviations and names in a 'key' => 'value' format
 *  $state_array : this merges both arrays above
 */
require_once('state_list.php');

/**
 *  this file contains 1 array
 *  $ZIPREG : regular expressions for zip codes for the countries listed below
 *  US,UK,DE,CA,FR,IT,AU,NL,ES,DK,SE,BE
 */
require_once('zip_reg.php');

require_once('functions.php');


/*/
 *********************************************************************************************************************
 *  Start Validation
 ********************************************************************************************************************
 **/

if($_POST['submited']){

// run validation for first_name
$error_message .= validateString(array(
		'string' => $first_name,
		'label' => 'First Name',
		'min' => 2,
		'max' => 20,
		'allowed' => "/[^A-Za-z-' ]/i",
		'message' => 'should only contain letters, hyphens, apostrophies, or spaces'
	)
);

// run validation for last_name
$error_message .= validateString(array(
		'string' => $last_name,
		'label' => 'Last Name',
		'min' => 2,
		'max' => 20,
		'allowed' => "/[^A-Za-z-' ]/i",
		'message' => 'should only contain letters, hyphens, apostrophies, or spaces'
	)
);

// run validation for address
$error_message .= validateString(array(
		'string' => $street_address,
		'label' => 'Address',
		'min_letters' => 2,
		'min' => 3,
		'max' => 80,
		'allowed' => "/[^A-Za-z0-9\-#.' ]/i",
		'message' => 'should contain only letters, numbers, the # sign, apostrophes, hyphens, periods and spaces'
	)
);

// run validation for city
$error_message .= validateString(array(
		'string' => $city,
		'label' => 'City',
		'min' => 3,
		'max' => 25,
		'allowed' => "/[^A-Za-z-' ]/i",
		'message' => 'should contain only letters, hyphens, apostrophes, or spaces'
	)
);

// run validation for state 
$error_message .= validateString(array(
		'string' => $state,
		'label' => 'State',
		'min' => 2,
		'max' => 2,
		'array_key' => $us_states
	)
);

// run validation for zip code
$error_message .= validateString(array(
		'string' => $zip,
		'label' => 'Zip Code',
		'min' => 5,
		'max' => 10,
		'match_format' => '/'.$ZIPREG['US'].'/i',
		'message' => 'you entered an invalid US zip code. It should be in this format (33321) or (33312-1234)'
	)
);

// run validation for phone
$error_message .= validateString(array(
		'string' => $phone,
		'label' => 'Phone Number',
		'min' => 10,
		'max' => 12,
		'min_numbers' => 10,
		'allowed' => "/[^0-9\-' ]/i",
		'message' => 'should contain only numbers and hyphens (ex: 555-123-4567)'
	)
);
}
/*/
 *********************************************************************************************************************
 *  End Validation
 ********************************************************************************************************************
 **/



?>




<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Input Validator</title>
</head>
<body>
	<?php
		if($_POST['submited']){
		 echo success_message($success_message);
		 echo error_message($error_message); 
		}
	 ?>
	<h1>Input Validator</h1>
	<form method="post" action="<?php echo getenv('SCRIPT_NAME'); //this just post the form to it's self ?>">
	<input type="hidden" name="submited" value="1">	
  
  <!-- first name -->
  <div >
    <label for="first_name" >First Name</label>
    <div >
      <input type="text" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" >
    </div>
  </div>

  <!-- last name -->
  <div >
    <label for="last_name" >Last Name</label>
    <div >
      <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" >
    </div>
  </div>
  
  <!-- address -->
  <div >
    <label for="street_address" >Address</label>
    <div >
      <input type="text" name="street_address" placeholder="123 Penny Lane" value="<?php echo $street_address; ?>" >
    </div>
  </div>

  <!-- city -->
  <div >
    <label for="city" >City</label>
    <div >
      <input type="text" name="city" placeholder="Some City" value="<?php echo $city; ?>" >
    </div>
  </div>

  <!-- state -->
  <div >
    <label for="state" >State</label>
    <div >
      	 <select class="form-control" name="state" required>
			<?php echo option_list($us_states , 'state'); //create a dropdown list from the states array ?>
		</select>
    </div>
  </div>
  
  <!-- zip -->
  <div >
    <label for="zip">Zip</label>
    <div>
      <input type="text" name="zip" placeholder="32165" value="<?php echo $zip; ?>" >
    </div>
  </div>

  <!-- phone -->
  <div >
    <label for="phone" >Phone</label>
    <div >
      <input type="text" name="phone" placeholder="954-545-5468" value="<?php echo $phone; ?>" >
    </div>
  </div>
  <div>
    <div >
      <button type="submit">Submit</button>
    </div>
  </div>

</form>
</body>
</html>