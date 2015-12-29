<?php if ($this->showLink(UserResources::RES_BUSINESS_PERMIT)): ?>
        <li  class="<?php echo $this->activeMenu === BizpermitModuleController::MENU_BIZ_PERMIT ? 'active' : '' ?>">
                <a href="<?=$this->createUrl('/bizpermit/default/section',array('entity'=>'permit'));?>">
                        <i class="icon-certificate">
                        </i>
                        <span class="menu-text">Permits Manager</span>
                </a>
                 <ul class="submenu">
                    <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'feeSchedule'));?>"><i class="icon-double-angle-right"></i>Schedules Manager</a></li>
                        <ul>
                            <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'scheduleCategory'));?>"><i class="icon-double-angle-right"></i>Categories</a></li>
                            
                            <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'feeSchedule'));?>"><i class="icon-double-angle-right"></i>Fee Schedules</a></li>
                            <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'councilSchedule'));?>"><i class="icon-double-angle-right"></i>Council Schedule</a></li>
                            <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'penaltyRate'));?>"><i class="icon-double-angle-right"></i>Penalty Rate</a></li>
                        
                        </ul>

                    <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'Business'));?>"><i class="icon-double-angle-right"></i>Business Manager</a></li>                        
                        <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'Ward'));?>"><i class="icon-double-angle-right"></i>Wards</a></li>
                        <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'Zone'));?>"><i class="icon-double-angle-right"></i>Zones</a></li>
                        <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'Bill'));?>"><i class="icon-double-angle-right"></i>Bills Manager</a>
                              <ul>
                                <li class=""><a href="<?=$this->createUrl('/bizpermit/default/grid',array('entity'=>'feeSchedule'));?>"><i class="icon-double-angle-right"></i>All Bills</a></li>
                             </ul>
                        </li>
                        
                </ul>
        </li>
<?php endif; ?>

