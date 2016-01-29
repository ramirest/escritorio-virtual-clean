<?php /* Smarty version 2.6.25-dev, created on 2016-01-28 16:12:00
         compiled from menu.tpl */ ?>
<?php 
$ci_uri = trim($this->uri->uri_string(), '/');
$attr = ' class="active"';
$nav = ' in';
 ?>
<li>
    <a<?php  echo (preg_match("|^escritorio-virtual/dashboard.*$|", $ci_uri) > 0)? $attr: '';  ?> href="<?php  echo site_url('escritorio-virtual/dashboard');  ?>"> <i
            class="fa fa-dashboard"></i> <span>Principal</span>
    </a>
</li>
