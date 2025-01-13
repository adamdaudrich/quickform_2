<?php
require_once 'HTML/QuickForm2.php';

$form = new HTML_QuickForm2('simple_form', 'post');

// Add a text input field for nationality
$nationalityField = $form->addElement('text', 'nationality', ['size' => 50, 'maxlength' => 255])
    ->setLabel('What is your nationality?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your nationality.');

// Add the "Would you like to apply for Canadian citizenship?" field
$wishToApplyField = $form->addElement('select', 'wish_to_apply', ['id' => 'wish_to_apply'])
    ->setLabel('Would you like to apply for Canadian citizenship?')
    ->loadOptions([
        ''    => '-- Select an option --', // Placeholder option
        'yes' => 'Yes',
        'no'  => 'No',
    ])
    ->addRule('required', 'Please select an option.');

// Set default visibility for dynamic link
$applyForCitizenshipLink = '';


// Add a submit button to the form
$form->addElement('submit', 'submit_button', ['value' => 'Submit']);



// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $form->validate()) {
    $values = $form->getValue();
    $nationality = strtolower($values['nationality'] ?? '');
    $wishToApply = strtolower($values['wish_to_apply'] ?? '');

    echo '<h1>Form Submitted Successfully</h1>';
    echo '<p>Your nationality: ' . htmlspecialchars($values['nationality']) . '</p>';

    // Only display the dropdown selection if nationality is NOT "Canadian"
    if ($nationality !== 'canadian') {
        echo '<p>Would you like to apply for Canadian citizenship? ' . htmlspecialchars($wishToApply) . '</p>';

        // Show the link if "Yes" is selected
        if ($wishToApply === 'yes') {
            $applyForCitizenshipLink = '<p><strong>Apply for Canadian Citizenship:</strong> <a href="https://www.canada.ca/en/immigration-refugees-citizenship/services/canadian-citizenship.html" target="_blank">Click here</a></p>';
            echo $applyForCitizenshipLink;
        }
    } else {
        echo '<p>You are already a Canadian citizen.</p>';
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
