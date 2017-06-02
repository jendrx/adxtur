<nav  class="col-md-5">

	<ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' =>'domains','action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' =>'domains','action' => 'index']) ?></li>
	    <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Users'),['controller' => 'Users','action' => 'admin_index' ])?></li>
    </ul>
</nav>