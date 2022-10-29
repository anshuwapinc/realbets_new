<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>404 Sports Book</title>
   <base target="_top">
   <link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap" rel="stylesheet">
   <style type="text/css">
      html * {
         text-align: center;
         color: #000 !important;
         font-family: 'Lato', sans-serif, Arial !important;
      }
   </style>
</head>

<body bgcolor="#FFFFFF">
   <p align="center">&nbsp;</p>
   <p align="center">&nbsp;</p>
   <p align="center">&nbsp;</p>
   <p align="center">
      <h1><?php echo $heading; ?></h1>
      <div>
         <?php echo $message; ?>
      </div>
   </p>
</body>

</html>