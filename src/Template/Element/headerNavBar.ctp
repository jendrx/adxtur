<?php
?>
<li class="nav-item"> <a class="nav-item nav-link" href="/homes/index">Home <span class="sr-only">(current)</span></a></li>
<li class="nav-item"><?= $this->Html->link(__('Admin'),['controller' => 'domains', 'action' =>'index'],['class'=> ['nav-item nav-link']])?></li>
<li class="nav-item"><?= $this->Html->link(__('Logout'),['controller' => 'users', 'action' =>'logout'],['class'=> ['nav-item nav-link']])?></li>
