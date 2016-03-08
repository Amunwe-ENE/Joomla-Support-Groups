<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			6th March, 2016
	@created		24th February, 2016
	@package		Support Groups
	@subpackage		support_groups_fullwidth.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Support Groups 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

// set the defaults
$items	= $displayData->vvwsupport_groups;
$user	= JFactory::getUser();
$id	= $displayData->item->id;
$edit	= "index.php?option=com_supportgroups&view=support_groups&task=support_group.edit";
$ref	= ($id) ? "&ref=location&refid=".$id : "";
$new	= "index.php?option=com_supportgroups&view=support_group&layout=edit".$ref;
$can	= SupportgroupsHelper::getActions('support_group');

?>
<div class="form-vertical">
<?php if ($can->get('support_group.create')): ?>
	<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('COM_SUPPORTGROUPS_NEW'); ?></a><br /><br />
<?php endif; ?>
<?php if (SupportgroupsHelper::checkArray($items)): ?>
<table class="footable table data support_groups metro-blue" data-filter="#filter_support_groups" data-page-size="20">
<thead>
	<tr>
		<th data-toggle="true">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_NAME_LABEL'); ?>
		</th>
		<th data-hide="phone">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_PHONE_LABEL'); ?>
		</th>
		<th data-hide="phone">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_LOCATION_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_CLINIC_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_MALE_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_FEMALE_LABEL'); ?>
		</th>
		<th width="10" data-hide="phone,tablet">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_STATUS'); ?>
		</th>
		<th width="5" data-type="numeric" data-hide="phone,tablet">
			<?php echo JText::_('COM_SUPPORTGROUPS_SUPPORT_GROUP_ID'); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ($items as $i => $item): ?>
	<?php
		$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = SupportgroupsHelper::getActions('support_group',$item,'support_groups');
	?>
	<tr>
		<td class="nowrap">
			<?php if ($canDo->get('support_group.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref=location&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'support_groups.', $canCheckin); ?>
					<?php endif; ?>
			<?php else: ?>
				<div class="name"><?php echo $displayData->escape($item->name); ?></div>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->phone); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->location_name); ?>
		</td>
		<td class="nowrap">
			<?php if ($user->authorise('clinic.edit', 'com_supportgroups.clinic.' . (int)$item->clinic)): ?>
				<a href="index.php?option=com_supportgroups&view=clinics&task=clinic.edit&id=<?php echo $item->clinic; ?>&ref=location&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->clinic_name); ?></a>
			<?php else: ?>
				<div class="name"><?php echo $displayData->escape($item->clinic_name); ?></div>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->male); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->female); ?>
		</td>
		<?php if ($item->published == 1):?>
			<td class="center"  data-value="1">
				<span class="status-metro status-published" title="<?php echo JText::_('PUBLISHED');  ?>">
					<?php echo JText::_('PUBLISHED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 0):?>
			<td class="center"  data-value="2">
				<span class="status-metro status-inactive" title="<?php echo JText::_('INACTIVE');  ?>">
					<?php echo JText::_('INACTIVE'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 2):?>
			<td class="center"  data-value="3">
				<span class="status-metro status-archived" title="<?php echo JText::_('ARCHIVED');  ?>">
					<?php echo JText::_('ARCHIVED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == -2):?>
			<td class="center"  data-value="4">
				<span class="status-metro status-trashed" title="<?php echo JText::_('ARCHIVED');  ?>">
					<?php echo JText::_('ARCHIVED'); ?>
				</span>
			</td>
		<?php endif; ?>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
<tfoot class="hide-if-no-paging">
	<tr>
		<td colspan="8">
			<div class="pagination pagination-centered"></div>
		</td>
	</tr>
</tfoot>
</table>
<?php else: ?>
	<div class="alert alert-no-items">
		<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php endif; ?>
</div>
