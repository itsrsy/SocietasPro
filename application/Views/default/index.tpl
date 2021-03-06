{extends file="standard.tpl"}

{block name=head}
<script type="text/javascript">
function checkVersion () {
	$.get("{$root}admin/default/version", function (data) {
		if (data != "") {
			$("#version").html(data);
			$("#version").slideDown();
		}
	});
}

function loadTweets () {
	$.get("{$root}admin/default/tweets", function (data) {
		$("#tweets").html(data);
	});
}

$(document).ready( function () {
	checkVersion();
	loadTweets();
});
</script>

<style type="text/css">
.col1 {
	width: 49%;
	float: left;
}

.col2 {
	width: 49%;
	float: right;
}

#version {
	display: none;
}
</style>
{/block}

{block name=body}
<h2>{$lang_control_panel}</h2>

<div class="col1">

	<table border="1" width="100%">
		<tr>
			<th colspan="2">{$lang_stats}</th>
		</tr>
		<tr>
			<td>{$lang_members}</td>
			<td class="right">{$total_members}</td>
		</tr>
		<tr>
			<td>{$lang_mailing_list} {$lang_subscribers}</td>
			<td class="right">{$total_subscribers}</td>
		</tr>
		<tr>
			<td>{$lang_events}</td>
			<td class="right">{$total_events}</td>
		</tr>
		<tr>
			<td>{$lang_pages}</td>
			<td class="right">{$total_pages}</td>
		</tr>
		<tr>
			<td>{$lang_blog} {$lang_posts}</td>
			<td class="right">{$total_blog_posts}</td>
		</tr>
	</table><br />
	
	<table border="1" width="100%">
		<tr>
			<th>{$lang_shortcuts}</th>
		</tr>
		<tr>
			<td>
				<ul>
					<li><a href="{$root}admin/members/create">{$lang_create} {$lang_member|lower}</a></li>
					<li><a href="{$root}admin/events/create">{$lang_create} {$lang_event|lower}</a></li>
					<li><a href="{$root}admin/blog/create">{$lang_create} {$lang_blog|lower} {$lang_post|lower}</a></li>
				</ul>
			</td>
		</tr>
	</table>
	
	<div id="version"></div>

</div>

<div class="col2">

	<table border="1" width="100%">
		<tr>
			<th>Twitter</th>
		</tr>
		<tr>
			<td>
				<div id="tweets">
					<p>
						<img src="{$root}admin/resources/images/loader1.gif" alt="" />
					</p>
				</div>
			</td>
		</tr>
	</table>

</div>

<div class="clear"></div>
{/block}