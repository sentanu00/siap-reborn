<ul class="nav nav-tabs  tabs" role="tablist" style="margin-bottom:10px;">
  <li  class="nav-item" >
    <a href="<?php echo site_url('sximo/module/config/'.$module_name);?>" class="nav-link <?php if($active == 'config') echo 'active';?>"><?php echo $this->lang->line('core.modtab_info'); ?> </a></li>
  <li class="nav-item" >
  <a href="<?php echo site_url('sximo/module/sql/'.$module_name);?>" class="nav-link <?php if($active == 'sql') echo 'active';?>"><?php echo $this->lang->line('core.modtab_sql'); ?> </a></li>
  <li class="nav-item">
  <a href="<?php echo site_url('sximo/module/table/'.$module_name);?>" class="nav-link <?php if($active == 'table') echo 'active';?>"><?php echo $this->lang->line('core.modtab_table'); ?> </a></li>
  <li  class="nav-item">
  <a href="<?php echo site_url('sximo/module/form/'.$module_name);?>" class="nav-link <?php if($active == 'form') echo 'active';?>"><?php echo $this->lang->line('core.modtab_form'); ?> </a></li> 
  <li class="nav-item" >
  <a href="<?php echo site_url('sximo/module/permission/'.$module_name);?>" class="nav-link <?php if($active == 'permission') echo 'active';?>"><?php echo $this->lang->line('core.modtab_permission'); ?> </a></li>
   <li  class="nav-item"  >
   <a href="javascript://ajax" onclick="SximoModal('<?php echo site_url('sximo/module/build/'.$module_name);?>','<?php echo $this->lang->line('core.modtab_rebuildtitle'); ?> <?php echo $module_name;?>')" class="nav-link"><?php echo $this->lang->line('core.modtab_rebuild'); ?> </a></li>
</ul>