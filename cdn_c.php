<?php
require_once 'HTML/QuickForm2.php';

$form = new HTML_QuickForm2('simple_form', 'post');

// Add input fields with required rule

$birthcountryElement = $form->addElement('text', 'country_of_birth', ['size' => 50, 'maxlength' => 255])
    ->setLabel('Enter your country of birth:')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'This field is required.');

$citizenshipElement = $form->addElement('text', 'citizenship', ['size' => 50, 'maxlength' => 255])
    ->setLabel('Enter your citizenship:')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'This field is required.');



//initialize these variables
$conditionalMessage = '';
//$wishToBecomeField = null;
$applyforCitizenshipLink = '';


$wishToBecomeField = $form->addElement('select', 'wish_to_become', ['id' => 'wish_to_become'])
    ->setLabel('Do you wish to become a Canadian citizen?')
    ->loadOptions([
        ''    => '-- Select an option --', // Placeholder option
        'yes' => 'Yes',
        'no'  => 'No',
    ]);


// process form logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = $form->getValue();
    $countryOfBirth = strtolower($values['country_of_birth'] ?? '');
    $citizenship = strtolower($values['citizenship'] ?? '');
    
    
    // if born in canada, but not canadian... 
    if ($countryOfBirth === 'canada' && $citizenship !== 'canadian') {
        $conditionalMessage = '<p style="color: blue;">Unless your citizenship has been revoked, you are a Canadian citizen by birth.</p>';
    }

        // Add dynamic link if "Yes" is selected
    if (!empty($values['wish_to_become']) && $values['wish_to_become'] === 'yes'){ $applyforCitizenshipLink = '<p><strong>Apply for Canadian Citizenship:</strong> <a href="https://www.canada.ca/en/immigration-refugees-citizenship/services/canadian-citizenship.html" target="_blank">Click here</a></p>';
    }
}


// Add a submit button
$form->addElement('submit', 'submit_button', ['value' => 'Submit']);



// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $form->validate()) {
    $values = $form->getValue();
    echo '<p>Your country of birth: ' . htmlspecialchars($values['country_of_birth']) . '</p>';
    echo '<p>Your citizenship: ' . htmlspecialchars($values['citizenship']) . '</p>';
    
    // Output the value of the dynamic field if it exists
    if (isset($values['wish_to_become'])) {
        echo '<p>Do you wish to become a Canadian citizen? ' . htmlspecialchars($values['wish_to_become']) . '</p>';
    }

    echo $conditionalMessage;
    echo $applyForCitizenshipLink;

} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p style="color: red;">Please fill out all required fields correctly.</p>';
    }

}
// Display the form
echo $form;

?>