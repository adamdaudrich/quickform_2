<?php
require_once 'HTML/QuickForm2.php';

$form = new HTML_QuickForm2('simple_form', 'post');

// Add fields to the form
$nameField = $form->addElement('text', 'name', ['size' => 50, 'maxlength' => 255])
    ->setLabel('What is your name?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your name.');

$ageField = $form->addElement('text', 'age', ['size' => 3, 'maxlength' => 3])
    ->setLabel('What is your age?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your age.');
 //   ->addRule('regex', 'Please enter a valid age (numbers only).', '/^\d+$/'); // Numeric validation

$countryField = $form->addElement('text', 'country', ['size' => 50, 'maxlength' => 255])
    ->setLabel('Which country are you from?')
    ->addFilter('trim') // Remove whitespace
    ->addRule('required', 'Please enter your country.');

// Add a submit button
$form->addElement('submit', 'submit_button', ['value' => 'Submit']);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $form->validate()) {
    // Collect form values
    $values = $form->getValue();

    // Convert values to JSON
    $jsonOutput = json_encode($values, JSON_PRETTY_PRINT);

    // Display JSON output
    header('Content-Type: application/json');
    echo $jsonOutput;
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p style="color: red;">Please fill out all fields correctly.</p>';
    }
}

// Render the form
echo $form;
?>
