<?php
if(!isset($_POST['submit']))
{
    echo "error; you need to submit the form!";
}

$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

if(empty($_POST['name'])||
    empty( $_POST['email']))
{
    echo "Name and email are mandatory!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'no-reply@lamournails.co.nz';
$email_subject = "New Message";
$email_body = "You have received a new message form $name.\n".
    "email: $visitor_email\n".
    "Here is the message: \n $message". 
$to = "lamournailsnz@gmail.com";
$headers = "From: $email_from \r\n";


$headers .= "Reply-To: $visitor_email \r\n";

mail($to, $email_subject, $email_body, $headers);

header('Location: contact.html');


echo "success";

function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>