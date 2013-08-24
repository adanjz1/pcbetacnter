<?php

function pagination($count,$frmName)

{

	$noOfPages = ceil($count/$GLOBALS['show']);

?>

<script language="JavaScript">

<!--

function prevPage(no){

	document.<?=$frmName?>.action="<?=$_SERVER['PHP_SELF']?>";

	document.<?=$frmName?>.pageNo.value = no-1;

	document.<?=$frmName?>.submit();

}

function nextPage(no){

	document.<?=$frmName?>.action="<?=$_SERVER['PHP_SELF']?>";

	document.<?=$frmName?>.pageNo.value = no+1;

	document.<?=$frmName?>.submit();

}

function disPage(no){

	document.<?=$frmName?>.action="<?=$_SERVER['PHP_SELF']?>";

	document.<?=$frmName?>.pageNo.value = no;

	document.<?=$frmName?>.submit();

}



//-->

</script>

<br/>

	<table align="center" border="0" cellspacing="0" cellpadding="4" class="text_normal">

	  <tr>

		<?php /*?><td align="left" class="texthead">

			<span id="dFunctionButton">

			<? if($_POST[pageNo]!=1){ ?>

				<a href="javascript:prevPage(<?=$_POST[pageNo] ?>);" class="alternate " onmouseout="javascript:window.status='Done';" onmousemove="javascript:window.status='Go to Previous Page';"><< Previous</a>

			<? }

			else echo "";

			?>

			</span>

		</td><?php */?>

		<td align="center" class="texthead">
		
		<span id="dFunctionButton">

			<? if($_POST[pageNo]!=1){ ?>

				<a href="javascript:prevPage(<?=$_POST[pageNo] ?>);" class="alternate " onmouseout="javascript:window.status='Done';" onmousemove="javascript:window.status='Go to Previous Page';"><< Previous</a>

			<? }

			else echo "";

			?>

			</span>

		<? ####### script to display no of pages #########

			//condition where no of pages is less than display limit

			$displayPageLmt = 5; #holds no of page links to display

			if($noOfPages <= $displayPageLmt){

				for($pgLink = 1; $pgLink <= $noOfPages; $pgLink++){

					if($pgLink==$_POST[pageNo]){

						//echo "<a href=\"#\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">[$pgLink]</a>";

						echo "<span id=\"dFunctionButton\">".$pgLink."</span>";						

					}

					else{

						echo "<span id=\"dFunctionButton\"><a href=\"javascript:disPage($pgLink)\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">$pgLink</a></span>";

					}	

					if($pgLink<>$noOfPages) echo "&nbsp;&nbsp;";

				} #end of for loop

			} #end of if

			//condition for no of pages greater than display limit

			if($noOfPages > $displayPageLmt){

				if(($_POST[pageNo]+($displayPageLmt-1)) <= $noOfPages){

					for($pgLink = $_POST[pageNo]; $pgLink <= ($_POST[pageNo]+$displayPageLmt-1); $pgLink++){

						if($pgLink==$_POST[pageNo]){

							//echo "<a href=\"#\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">[$pgLink]</a>";

							echo "<span id=\"dFunctionButton\">".$pgLink."</span>";

						}

						else{

							echo "<span id=\"dFunctionButton\"><a href=\"javascript:disPage($pgLink)\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">$pgLink</a></span>";

						}

						if($pgLink<>($_POST[pageNo]+$displayPageLmt-1)) echo "&nbsp;&nbsp;";

					}#end of for loop						

				}#end of inner if

				else{

					for($pgLink = ($noOfPages - ($displayPageLmt-1)); $pgLink <= $noOfPages; $pgLink++){

						if($pgLink==$_POST[pageNo]){

							//echo "<a href=\"#\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">[$pgLink]</a>";

							echo "[".$pgLink."]";

						}

						else{

							echo "<span id=\"dFunctionButton\"><a href=\"javascript:disPage($pgLink)\" class=\"alternate\" onmouseout=\"javascript:window.status='Done';\" onmousemove=\"javascript:window.status='Go to this Page';\">$pgLink</a></span>";

						}

						if($pgLink<>$noOfPages) echo "&nbsp;&nbsp;";

					}#end of for loop

				}					

			}#end of if noOfPage>displayPageLmt

		?>
		
		<span id="dFunctionButton">

			<? if($_POST[pageNo] != $noOfPages) { ?>

				<a href="javascript:nextPage(<?=$_POST[pageNo] ?>)"  class="texthead" onmouseout="javascript:window.status='Done';" onmousemove="javascript:window.status='Go to Next Page';">Next >></a>

			<? }

			   else echo "";

			?>

			</span>
		
		</td>

		<?php /*?><td align="right" class="texthead">

			<span id="dFunctionButton">

			<? if($_POST[pageNo] != $noOfPages) { ?>

				<a href="javascript:nextPage(<?=$_POST[pageNo] ?>)"  class="texthead" onmouseout="javascript:window.status='Done';" onmousemove="javascript:window.status='Go to Next Page';">Next >></a>

			<? }

			   else echo "";

			?>

			</span>

		</td><?php */?>			

	  </tr>

	</table>

<?

}

function getCount($table_name)

{

	$sql = "select count(*) from ".$table_name;

	$rs  = mysql_query($sql);

	$rec = mysql_fetch_array($rs); 

	$count = $rec[0];

	mysql_free_result($rs);

	return $count;

}

function getRowCount($sql)

{

	$count = 0;



	if ($sql != ""){

		$rs = mysql_query($sql);

		$count = mysql_num_rows($rs);

	}

	return $count;

}

?>