<?php
require_once 'HTML/QuickForm2.php';

$form = new HTML_QuickForm2('citizenship_form', 'post');

// Add a text input field for the country of birth
$birthCountryField = $form->addElement('text', 'birth_country', ['size' => 50, 'maxlength' => 255])
    ->setLabel('What country were you born in?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your country of birth.');

// Initialize variables for messages and the link
$applyForCitizenshipLink = '';
$canadianMessage = '';
$wishToApplyField = null;

// Get current form values
$values = $form->getValue();
$birthCountry = strtolower($values['birth_country'] ?? '');

// Add a dropdown field for "Would you like to apply for Canadian citizenship?" dynamically
if ($birthCountry !== 'canada' && !empty($birthCountry)) {
    $wishToApplyField = $form->addElement('select', 'wish_to_apply', ['id' => 'wish_to_apply'])
        ->setLabel('Would you like to apply for Canadian citizenship?')
        ->loadOptions([
            ''    => '-- Select an option --', // Placeholder
            'yes' => 'Yes',
            'no'  => 'No',
        ])
        ->addRule('required', 'Please select an option.');
}

// Add a submit button to the form
$form->addElement('submit', 'submit_button', ['value' => 'Submit']);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $form->validate()) {
    echo '<h1>Form Submitted Successfully</h1>';

    // Display the user's country of birth
    echo '<p>Country of birth: ' . htmlspecialchars($birthCountry) . '</p>';

    // If the user was born in Canada, show a message
    if ($birthCountry === 'canada') {
        $canadianMessage = '<p style="color: blue;">Unless your citizenship has been revoked, you are a Canadian citizen by birth.</p>';
        echo $canadianMessage;
    } else {
        // If not born in Canada, display the dropdown value and link if "Yes" is selected
        $wishToApply = strtolower($values['wish_to_apply'] ?? '');

        if (!empty($wishToApply)) {
            echo '<p>Would you like to apply for Canadian citizenship? ' . htmlspecialchars($wishToApply) . '</p>';
            if ($wishToApply === 'yes') {
                $applyForCitizenshipLink = '<p><strong>Apply for Canadian Citizenship:</strong> <a href="https://www.canada.ca/en/immigration-refugees-citizenship/services/canadian-citizenship.html" target="_blank">Click here</a></p>';
                echo $applyForCitizenshipLink;
            }
        }
    }
} else {
    // Handle validation errors
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p style="color: red;">Please fill out all required fields correctly.</p>';
    }
}

// Display the form
echo $form;
?>
