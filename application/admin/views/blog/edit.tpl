{extends file="standard.tpl"}

{block name=head}
{include file="visualeditor.tpl"}

<script type="text/javascript">
$(document).ready(function(){
	$("#name").keyup(function(){
		$("#slug").val(generateSlug($("#name").val()));
	});
});
</script>
{/block}

{block name=body}
<h2>{$lang_edit} {$lang_blog} {$lang_post}</h2>

{$form}
{/block}