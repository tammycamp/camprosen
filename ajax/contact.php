<?php
// Configuration
$params = array(
    'to' => 'tammy@tammycamp.com', // Your Personal Email
    'from' => 'tammy@tammycamp.com' // Your "Noreply" Email
);

$name = trim( $_POST['name'] );
$email = trim( $_POST['email'] );
$subject = trim( $_POST['subject'] );
$message = trim( $_POST['message'] );

if ( empty( $name ) or empty( $message ) ) {
    echo json_encode( array( 'status' => 'error' ) );
} else if ( empty( $email ) or ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
    echo json_encode( array( 'status' => 'email' ) );
} else {
    $headers = 'From: ' . $name . ' ' . $params['from'] . "\r\n" .
    'Reply-To: ' . $email . "\r\n" .
    'X-Mailer: PHP/' . phpversion( );
    $message = str_replace( array( "\r", "\n" ), array( '', "\r\n" ), $message );

    if ( mail( $params['to'], ( empty( $subject ) ? 'New message without subject' : 'New message: ' . $subject ), $message, $headers ) ) {
        echo json_encode( array( 'status' => 'ok' ) );
    } else {
        echo json_encode( array( 'status' => 'error' ) );
    }
}
?>