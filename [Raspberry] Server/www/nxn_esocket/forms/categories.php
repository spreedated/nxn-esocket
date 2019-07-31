<style type="text/css">
#categories {
	position: relative;
	margin: auto;
	width: auto;
	max-width: 450px;
	font-size: 12px;
	text-align: center;
	display: block;
}
#toggle_categories {
	display: block;
	cursor: pointer;
	color: #555;
	font-size: 32px;
	width: auto;
	max-width: 150px;
	margin: auto;
	padding: 0px;
	line-height: 24px;
}
#toggle_categories:hover {
	color: #999;
}
#cat_names{
	display: none;
	margin-top: 8px;
}
#cat_name	{
	position: relative;
	display: inline-block;
	border-radius: 5px 5px 5px 5px;
	border: solid thin #606060;
	background-color: #303030;
	color: #fff;
	font-size: 12px;
	font-weight:none;
	text-align: center;
	cursor: pointer;
	margin:0px;
	margin-bottom:4px;
	margin-left:-6px;
	width:auto;
	padding-left: 5px;
	padding-right: 5px;
}
#cat_name:hover {
	background-color: #505050;
}
</style>
<script type="text/javascript">
var cat_toggle = true;
function toggle_visibility_categories() {
	if(cat_toggle){
		$('#toggle_categories').fadeOut(400, function() {
			$('#toggle_categories').html('<i class="fal fa-angle-double-up"></i> <i class="fal fa-angle-double-up"></i> <i class="fal fa-angle-double-up"></i>');
			$('#toggle_categories').fadeIn(400);
			$('#cat_names').slideDown(400, function(){
				$('#cat_names').css('display','inline-block');
			})
			cat_toggle = false;
		});
	}else{
		$('#toggle_categories').fadeOut(400, function() {
			$('#toggle_categories').html('<i class="far fa-ellipsis-h"></i> <i class="far fa-ellipsis-h"></i> <i class="far fa-ellipsis-h"></i>');
			$('#toggle_categories').fadeIn(400);
			$('#cat_names').slideUp(400, function(){
				$('#cat_names').css('display','none');
			})
			cat_toggle = true;
		});
	}
}
</script>

<?PHP
function categories($conn) {
	$sql = "SELECT COUNT(*) AS cnt FROM categories";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
		if(intval($row['cnt']) <= 1) {
			return NULL;
		}
	}
	$output = '<div id="categories">'.
							'<div id="toggle_categories" onClick="toggle_visibility_categories();"><i class="far fa-ellipsis-h"></i> <i class="far fa-ellipsis-h"></i> <i class="far fa-ellipsis-h"></i></div>';
	$output .= '<div id="cat_names"><div id="cat_name">All</div>';

	$sql = "SELECT * FROM categories";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {

	}
	$output .= '</div></div>';
	return $output;
}
?>
