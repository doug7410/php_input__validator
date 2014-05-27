<?php

/**
 * validate a string by checking if it exist, is a min and max length,
 * does not contain any characters specified by a regular expression
 * @param array $input_arry list of paramaters for the validateString function
 * 			     string => the string to be validate
 * 			     label => the name of the string (ex: First Name)
 * 			     min_letters => the minimum ammount of letters that must be in the string
 * 			     min =>	the minimum length of the string
 * 			     max => the max length of the strign
 * 			     allowed => a regular expression with what is allowd in the string (ex: /[^A-Za-z]/)
 * 			     message => the error message shown if the regex check fails				
 */
function validateString($input_array){	
		
	//check if the string is empty
	if(!$input_array['string']){ 
		$error_message .= "Please enter a " . $input_array['label'] . ".<br>"; 
	}

	//check if the string exceedes the maximum characters allowed
	if($input_array['max']){ 
		if(strlen($input_array['string']) > $input_array['max']){ 
			$error_message .= $input_array['label'] . " can not be more than " . $input_array['max'] . " characters.<br>"; 
		}
	}

	// check if the string has at lest the minimum number of letters
	if($input_array['string'] && $input_array['min_letters']){
		if( strlen( preg_replace("/[^A-Za-z]/", '', $input_array['string']) ) < $input_array['min_letters']){
			$error_message .=  $input_array['label'] . " must contain at least " . $input_array['min_letters'] . " letters.<br>";
		}
	}

	// check if the string has at lest the minimum number of numbers
	if($input_array['string'] && $input_array['min_numbers']){
		if( strlen( preg_replace("/[^0-9]/", '', $input_array['string']) ) < $input_array['min_numbers']){
			$error_message .=  $input_array['label'] . " must contain at least " . $input_array['min_numbers'] . " numbers.<br>";
		}
	}

	//check if the string is less than the minimum characters allowed
	if($input_array['string'] && $input_array['min']){ 
		if(strlen($input_array['string']) < $input_array['min']){ 
			$error_message .=  $input_array['label'] . " must be at least " . $input_array['min'] . " characters.<br>"; 
		}
	}

	//check if the string contains invalid characters
	if($input_array['string'] && $input_array['allowed']){ 
		if(preg_match($input_array['allowed'], $input_array['string'])){ 
			$error_message .= $input_array['label'] . " " . $input_array['message'] . ". (you entered " . $input_array['string'] . ")<br>";
		}
	}

	//check if the string matched a regex format
	if($input_array['string'] && $input_array['match_format']){ 
		if(!preg_match($input_array['match_format'], $input_array['string'])){ 
			$error_message .= $input_array['label'] . " " . $input_array['message'] . ". (you entered " . $input_array['string'] . ")<br>";
		}
	}

	//check if the string is in an array as a key
	if($input_array['string'] && $input_array['array_key']){
		if(!array_key_exists($input_array['string'], $input_array['array_key'])){
			$error_message .= "You entered an invalid"  .$input_array['label'] . " (you entered " . $input_array['string'] . ")<br>";
		}
	}
	return $error_message;	
}

/**
 * create an HTML <option> list for a <select> element
 * @param  array $option_array an array containing all the options
 * @param  string $list_name    the name of the <select> element
 * @return string               an html <option> list
 */
function option_list($option_array, $list_name){
		$list = '<option value="">Please choose...</option>';
	foreach ($option_array as $key => $value ) {
		if($_REQUEST[$list_name] == $key){
		$list .= '<option value="'.$key.'" selected>'.$value.'</option>';
		}else{
		$list .= '<option value="'.$key.'">'.$value.'</option>';
		};
	}
	return $list;
}

/**
 * an html formated error message
 * @param  string $errors  a list of errors
 * @return string          html error message block
 */
function error_message($errors = false){
	if($errors){
		$message_html = '<div><p><strong>Error!</strong><br>Please fix the errors listed below</p></div>';
		$message_html .= '<div>' . $errors . '</div>';
	return $message_html;
	};
}

/**
 * an html formated success message
 * @param  string $message a success message string
 * @return string           html success message block
 */
function success_message($message = false){
	$message = "All the data looks good!";
	if($message){
		$message_html = '<div>' . $message . '</div>';
	return $message_html;
	};
}