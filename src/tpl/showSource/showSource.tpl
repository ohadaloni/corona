<table border="0">
	<tr>
		<td valign="top">
			<table border="0">
				<tr class="coronaHeaderRow">
					<td>File Name</td>
				</tr>
				{foreach from=$files key=fileId item=file}
					<tr class="coronaRow">
						<td>
							<a href="/showSource?file={$file}">{$file}</a>
						</td>
					</tr>
				{/foreach}
				</tr>
			</table>
		</td>
		<td valign="top">
			{if $sourceFile}
				<h4>{$sourceFile}</h4>
				{$source}
			{/if}
		</td>
	</tr>
</table>
