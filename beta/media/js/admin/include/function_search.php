<?
function SearchAlphabet()
{
?>
<script>
	function searchAlphabet(strSearch_text,strAction)
	{
		document.frmsearch_alpha.action.value		= strAction;
		document.frmsearch_alpha.search_txt.value	= strSearch_text;
		document.frmsearch_alpha.submit();
	}
</script>
<table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
	<tr> 
      <td class="TDHEAD">Alphabetic Search</td>
    </tr>
	<form name="frmsearch_alpha" action="" method="post">
	<input type="hidden" name="action">
	<input type="hidden" name="search_txt">
		<tr>
		  <td align="center" style="padding:10px 0 10px 0;">			
			<?php 
				$str="A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
				$str=preg_split("/[\s,]+/",$str);
				for($i=0; $i < sizeof($str); $i++){
				echo "<span id=\"dFunctionButton\"><a href=\"javascript:searchAlphabet('".$str[$i]."','alpha')\">$str[$i]</a>
				</span>";
				}
			?>
<span id="dFunctionButton" style="font:Verdana, Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:14px"><a href="javascript:searchAlphabet('%','alpha');">ShowAll</a></span></td>
		</tr>
	</form>	
</table>
<?
}
function Search($search_fields,$field_name)
{
	$arr_search_fields = array();
	$arr_field_name    = array();
	if ( ($search_fields != "" && $field_name != "") ){
		if ( strstr($search_fields,",") == false ) $arr_search_fields[0] = $search_fields;
		else $arr_search_fields = explode(",",$search_fields);
		if ( strstr($field_name,",") == FALSE ) $arr_field_name[0] = $field_name;
		else $arr_field_name = explode(",",$field_name);
?>

<table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
<form name="frmsearch" action="" method="post">
<input type="hidden" name="action" value="search">
<input 	type="hidden" 	name="parent_link_id"	value="<? echo $_REQUEST['parent_link_id']; ?>">
	<tr>
		<td align="center" style="padding:10px 0 10px 0;"><span class="text_small">Search by:</span>				
				<select name="search_field">							
					<?
						for($i=0;$i<count($arr_search_fields);$i++)	{ 													
						echo "<option value=".$arr_field_name[$i].">".$arr_search_fields[$i]."</option>";
						}
					?>							
				</select>
				&nbsp;&nbsp;
				<span class="text_small">Search for:</span>&nbsp;<input type="text" name="search_txt">&nbsp;&nbsp;
				<input type="submit" value="Go" class="button">&nbsp;&nbsp;
		</td>
	</tr> 
</form>	
</table>
<?
	}// end if
}

?>