	<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/flashxyz/BookMe/wiki
 * @since      1.0.0
 *
 * @package    Wp_book_me
 * @subpackage Wp_book_me/admin/partials
 */




global $wpdb;


$group_options_table = $wpdb->prefix . "bookme_group_options";

$general_options_table = $wpdb->prefix . "bookme_general_options";


$selectSQL = $wpdb->get_results( "SELECT * FROM $group_options_table  ORDER BY id ASC" );


$getGeneralOptions = $wpdb->get_results( "SELECT * FROM $general_options_table" );

	$dateFormat = $getGeneralOptions[0]->dateFormat;

	$isRTL = $getGeneralOptions[0]->isRTL;

	$firstDayOfWeek = $getGeneralOptions[0]->firstDayOfWeek;


$siteURL = get_site_url()."/wp-admin/admin.php";

?>

<script type="text/javascript">

var siteURL = <?php echo json_encode($siteURL);?>;

function checkMe(arg) {

var del = arg;

    if (confirm("Are you sure you want to delete this rooms group (id "+ del +")? All settings will be irrevocable deleted.")) {
        //alert("Clicked Ok");
		//confirmForm(); 
		//fDeleteFieldAndData(del);
		//e.preventDefault();
		//window.location.href = '?page=contest-gallery/index.php&delete=true&group_id='+del+'';
		window.location.replace(siteURL+'?page=wp_book_me&delete=true&group_id=' + del +'');
	    return true;
    } else {
        //alert("Clicked Cancel");
        return false;
    }
}

</script>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	<hr>

	<div>
		<h3>General Setting</h3>

		<hr>

		<table width='550px'>
			<tr>
				
				<td width='250px' >
					<span>Date Format: </span>
				</td>
				
				<td width='100px' >
					<label for="<?php echo $this->plugin_name; ?>_dateFormat">
						<input type="text" id="<?php echo $this->plugin_name; ?>_dateFormat" name="<?php echo $this->plugin_name; ?>[dateFormat]" value="<?php echo $dateFormat ?>"/>
					</label>
				</td>
			</tr>
			
			<tr>
				
				<td width='250px' >
					<span>First Day Of Week: </span>
				</td>
				
				<td width='100px' >
					<label for="<?php echo $this->plugin_name; ?>_firstDay">
						<input type="text" id="<?php echo $this->plugin_name; ?>_firstDay" name="<?php echo $this->plugin_name; ?>[firstDay]" value="<?php echo $firstDayOfWeek ?>"/>
					</label>
				</td>

				<td width='100px' >
				</td>
				
				<td width='100px' >
					<input class="button-primary" type="submit" name="saveOptionsBTN" value="Save" />
				</td>
			</tr>
			
			<tr>
				<td width='250px' >
					<span>RTL: </span>
				</td>
				
				<td width='100px' >
					<label for="<?php echo $this->plugin_name; ?>_rtl">
						<input type="checkbox" id="<?php echo $this->plugin_name; ?>_rtl" name="<?php echo $this->plugin_name; ?>[rtl]" <?php checked($isRTL, 1); ?>/>
					</label>
				</td>
			</tr>
		</table>

		<hr>
	</div>

    <div class="main-table">

		<h3>Group List</h3>

		<hr>
		<?php $group_index = 0; ?>
		<!-- create row for each group we have -->
    	<?php foreach($selectSQL as $value)
    		{
				
				$group_id = $value -> id;
			
				if ($group_index % 2 != 0)
				{
					$backgroundColor = "#DFDFDF";
				} 
				else 
				{
					$backgroundColor = "#ECECEC";
				}    ?>

				<table width='635px' style='border: 1px solid #DFDFDF;background-color:<?php echo $backgroundColor ?>;'>
				<tr style='background-color:<?php echo $backgroundColor ?>;'>
				<td style='padding-left:20px;width:100px;' ><p>Group ID: <?php echo $group_id ?> </p></td>
				<td align='center'><p>Shortcode: <strong>[bk_rooms_group id="<?php echo $group_id ?>"]</strong></p></td>
				<td align="center"><p><form action="?page=wp_book_me&group_id=<?php echo $group_id ?>&edit_group=true" method="POST" ><input type="hidden" name="group_id" value="<?php echo $group_id ?>">
				<input type="hidden" name="page" value="wp_book_me"><input name="" value="Edit" type="Submit" class="button-secondary" style = "background-color:#BBEEAA;"></form></p></td>
				<td align="center"><p><form action="?page=wp_book_me" method="get" ><input type="hidden" name="group_id" value="<?php echo $group_id ?>">
				<input type="hidden" name="delete" value="true"><input type="button" onClick="return checkMe(<?php echo $group_id ?>)" value="Delete" class="button-secondary" style = "background-color:#FF8181;"></form></p></td>



				</tr>
				</table>

		<?php 
		$group_id++;
		$group_index++;		
		} 
		?>

    <br/>

    <?php 
    	$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$group_options_table'");
			$nextID = $last->Auto_increment;
	?>

	<table width='635px'>
	<tr><td style="overflow:hidden;" colspan="4"><p><form action="?page=wp_book_me&group_id=<?php echo $nextID ?>&edit_group=true&create_group=true" method="POST" ><input type="hidden" name="group_id" value="<?php echo $nextID ?>">

	<input type="hidden" name="create" value="true"><input type="hidden" name="page" value="wp_book_me"><input name="" value="Create New Rooms Group" type="Submit" class="button-primary"></form></p></td></tr>
	</table>


</div>