<?php
    $this->layout = NULL;
    $cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>

    <?= $this->Html->charset() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">

    <title>
        Angel 
    </title>

    <?= $this->Html->meta('icon') ?>

   

    <?= $this->Html->script('jquery-1.11.3.min.js'); ?>
    <?= $this->Html->script('bootstrap.min.js'); ?>
    <?= $this->Html->script('bootstrap.js'); ?>
    <?= $this->Html->script('bootstrap-switch.js'); ?>
    <?= $this->Html->script('bootstrap-table.js'); ?>
    <?= $this->Html->script('bootstrap-table-export.js'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body">


</body>
</html>