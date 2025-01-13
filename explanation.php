<?php
require_once 'HTML/QuickForm2.php';

#variable holding instance of the HTML_Quickform2 object
$form = new HTML_QuickForm2('simple_form','post');

#variable storing reference to new text input field

//$form->addElement:
//adds text input field to the form


$birthCountryField = $form->addElement('
	text','birth_country', ['size' => 50, 'maxlength' => 255])
    ->setLabel('What country were you born in?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your country of birth.');

//parameters: 'text' (input type)
//'birth country'
//size = "width"
//maxlength = "max characters, ie 255"

//resulting html:
//<input type="text" //name="birth_country" 
//id="birth_country" size="50" maxlength="255">

->setLabel('What country were you born in?')

  