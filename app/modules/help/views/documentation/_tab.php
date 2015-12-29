<ul class="nav nav-tabs my-nav">
    <?php if(Acl::hasPrivilege($this->privileges, $this->resource,  Acl::ACTION_VIEW,false)):?><li <?php if($this->activeTab==1){ echo 'class="active"';}?>><a href="<?php echo $this->createUrl('documentation/index')?>"><?php echo CHtml::encode($this->homeTitle);?></a></li><?php endif;?>
    <?php if(Acl::hasPrivilege($this->privileges, $this->resource,Acl::ACTION_VIEW,false)):?><li <?php if($this->activeTab==2){ echo 'class="active"';}?>><a href="<?php echo $this->createUrl('documentation/admin')?>">Manage <?php echo CHtml::encode($this->homeTitle);?></a></li><?php endif;?>
    <?php if(Acl::hasPrivilege($this->privileges, $this->resource,Acl::ACTION_VIEW,false)):?><li <?php if($this->activeTab==3){ echo 'class="active"';}?>><a href="<?php echo $this->createUrl('documentation/helpCategory')?>">Manage Help Category</a></li><?php endif;?>
</ul>
