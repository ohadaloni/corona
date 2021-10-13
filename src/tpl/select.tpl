<select class="form-control" name="{$name}" {$more}>
	<option value=""></option>
	{foreach from=$from item=item}
		<option value="{$item.$idname}"
			{if $selected == $item.$idname}selected="selected"{/if}
		>{$item.$fname}</option>
	{/foreach}
</select>
