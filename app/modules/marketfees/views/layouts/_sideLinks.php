<?php if ($this->showLink(UserResources::RES_MARKET_FEES)): ?>
        <li  class="<?php echo $this->activeMenu === MarketfeesModuleController::MENU_MARKET_FEES ? 'active' : '' ?>">
                <a href="<?php echo Yii::app()->createUrl(ModulesEnabled::MOD_MARKET_FEES . '/default/index') ?>">
                        <i class="icon-money"></i>
                        <span class="menu-text"> <?php echo Lang::t('Market Fees') ?></span>
                </a>
        </li>
<?php endif; ?>

