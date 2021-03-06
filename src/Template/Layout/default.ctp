<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$title = 'ゼミ管理システム';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css("//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css") ?>
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('laboratory.css') ?>
    <?= $this->Html->css('load.css') ?>
    <?php if($this->request->controller === 'Users' && $this->request->action === 'login'): ?>
      <?= $this->Html->css('login.css') ?>
    <?php endif ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66496075-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-66496075-2');
    </script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <head>
    <?php if($this->request->controller === 'Users' && $this->request->action === 'login'): ?>
        <?php //echo $this->element('login_header'); ?>
    <?php else: ?>
        <?= $this->element('header'); ?>
    <?php endif ?>
    </head>
    <div class="container clearfix">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
<?= $this->Html->script('load.js') ?>
</body>
</html>
