<?php
# Name: Database.class.php
# File Description: MySQL Class to allow easy and clean access to common mysql commands
# Author: ricocheting
# Web: http://www.ricocheting.com/
# Update: 2010-05-08
# Version: 2.2.5
# Copyright 2003 ricocheting.com


/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



//require("config.inc.php");
//$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);


###################################################################################################
###################################################################################################
###################################################################################################
class Database {


var $server   = "118.139.168.193"; //database server
var $user     = "pccounter"; //database login name
var $pass     = "PC#counter123"; //database login password
var $database = "pccounter"; //database name
var $pre      = ""; //table prefix


#######################
//internal info
var $error = "";
var $errno = 0;

//number of rows affected by SQL query
var $affected_rows = 0;

var $link_id = 0;
var $query_id = 0;


#-#############################################
# desc: constructor
function Database($server, $user, $pass, $database, $pre=''){
	$this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->pre=$pre;
}#-#constructor()


#-#############################################
# desc: connect and select database using vars above
# Param: $new_link can force connect() to open a new link, even if mysql_connect() was called before with the same parameters
function connect($new_link=false) {
	$this->link_id=@mysql_connect($this->server,$this->user,$this->pass,$new_link);

	if (!$this->link_id) {//open failed
		$this->oops("Could not connect to server: <b>$this->server</b>.");
		}

	if(!@mysql_select_db($this->database, $this->link_id)) {//no database
		$this->oops("Could not open database: <b>$this->database</b>.");
		}

	// unset the data so it can't be dumped
	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
}#-#connect()


#-#############################################
# desc: close the connection
function close() {
	if(!@mysql_close($this->link_id)){
		$this->oops("Connection close failed.");
	}
}#-#close()


#-#############################################
# Desc: escapes characters to be mysql ready
# Param: string
# returns: string
function escape($string) {
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return @mysql_real_escape_string($string,$this->link_id);
}#-#escape()


#-#############################################
# Desc: executes SQL query to an open connection
# Param: (MySQL query) to execute
# returns: (query_id) for fetching results etc
function query($sql) {
	// do query
	$this->query_id = @mysql_query($sql, $this->link_id);

	if (!$this->query_id) {
		$this->oops("<b>MySQL Query fail:</b> $sql");
		return 0;
	}
	
	$this->affected_rows = @mysql_affected_rows($this->link_id);

	return $this->query_id;
}#-#query()


#-#############################################
# desc: fetches and returns results one line at a time
# param: query_id for mysql run. if none specified, last used
# return: (array) fetched record(s)
function fetch_array($query_id=-1) {
	// retrieve row
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}

	if (isset($this->query_id)) {
		$record = @mysql_fetch_assoc($this->query_id);
	}else{
		$this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
	}

	return $record;
}#-#fetch_array()


#-#############################################
# desc: returns all the results (not one row)
# param: (MySQL query) the query to run on server
# returns: assoc array of ALL fetched results
function fetch_all_array($sql) {
	$query_id = $this->query($sql);
	$out = array();
        while ($row = $this->fetch_array($query_id)){
                $out[] = $row;
        }
        $this->free_result($query_id);
	return $out;
}#-#fetch_all_array()

#-#############################################
# desc: returns all the results (not one row)
# param: (MySQL query) the query to run on server
# param: (Int) if 1 returns unformated the fetch_array
# returns: assoc array of ALL fetched results
function fetch_array_unformat($sql) {
	$query_id = $this->query($sql);
	$out = mysql_fetch_array($query_id);
        $this->free_result($query_id);
	return $out;
}#-#fetch_all_array()

#-#############################################
# desc: returns one result
# param: (MySQL query) the query to run on server
# returns: assoc array of ALL fetched results
function fetch_result($sql) {
	$query_id = $this->query($sql);
        $out = mysql_fetch_row($result); 
	$this->free_result($query_id);
	return $out;
}#-#fetch_result()


#-#############################################
# desc: frees the resultset
# param: query_id for mysql run. if none specified, last used
function free_result($query_id=-1) {
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}
	if($this->query_id!=0 && !@mysql_free_result($this->query_id)) {
		$this->oops("Result ID: <b>$this->query_id</b> could not be freed.");
	}
}#-#free_result()


#-#############################################
# desc: does a query, fetches the first row only, frees resultset
# param: (MySQL query) the query to run on server
# returns: array of fetched results
function query_first($query_string) {
	$query_id = $this->query($query_string);
	$out = $this->fetch_array($query_id);
	$this->free_result($query_id);
	return $out;
}#-#query_first()


#-#############################################
# desc: does an update query with an array
# param: table (no prefix), assoc array with data (doesn't need escaped), where condition
# returns: (query_id) for fetching results etc
function query_update($table, $data, $where='1') {
	$q="UPDATE `".$this->pre.$table."` SET ";

	foreach($data as $key=>$val) {
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
		else $q.= "`$key`='".$this->escape($val)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}#-#query_update()


#-#############################################
# desc: does an insert query with an array
# param: table (no prefix), assoc array with data
# returns: id of inserted record, false if error
function query_insert($table, $data) {
	$q="INSERT INTO `".$this->pre.$table."` ";
	$v=''; $n='';

	foreach($data as $key=>$val) {
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		//$this->free_result();
		return mysql_insert_id($this->link_id);
	}
	else return false;

}#-#query_insert()

/*function insert_id($table) {
	$q="SELECT * FROM `".$this->pre.$table."` ";

	foreach($data as $key=>$val) {
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		//$this->free_result();
		return mysql_insert_id($this->link_id);
	}
	else return false;

}*/#-#insert_id()


#-#############################################
# desc: throw an error message
# param: [optional] any custom error to display
function oops($msg='') {
	if($this->link_id>0){
		$this->error=mysql_error($this->link_id);
		$this->errno=mysql_errno($this->link_id);
	}
	else{
		$this->error=mysql_error();
		$this->errno=mysql_errno();
	}
	?>
		<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr><th colspan=2>Database Error</th></tr>
		<tr><td align="right" valign="top">Message:</td><td><?php echo $msg; ?></td></tr>
		<?php if(!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.$this->error.'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<?php if(!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="'.$_SERVER['REQUEST_URI'].'">'.$_SERVER['REQUEST_URI'].'</a></td></tr>'; ?>
		<?php if(!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
		</table>
	<?php
}#-#oops()

/**
 * Private calls to database
 */

#-#############################################
# desc: returns product name
# param: [optional] any custom error to display  //ERROR CHECK
function getProductName($productId){
    $sql = "select title from pc_counter_product where product_id = '".$this->escape($productId)."'";
    $out = $this->fetch_result($sql);
    return $out;
}
#-#############################################
# desc: returns category name of deal
# param: [optional] any custom error to display  //ERROR CHECK
function getCategoryName($categoryId){
    $sql = "select id, category_name from pc_counter_manage_categories where is_active = '1' and id = '".$this->escape($categoryId)."'";
    $out = $this->fetch_result($sql);
    return $out;
}
#-#############################################
# desc: returns SEO links to the page
# param: [optional] any custom error to display  //ERROR CHECK
function getSEOLinks($precisedLink, $linkPage){
    if(empty($precisedLink)){
        $sql = "select * from pc_counter_manage_content where is_active = '1' and page_name = '".$this->escape($linkPage)."'";
    }else{
        $sql = "select * from pc_counter_manage_content where is_active = '1' and page_name = '".$this->escape($linkPage)."' and content_id = '".$this->escape($precisedLink)."'";
    }
    $out = $this->fetch_array_unformat($sql);
    return $out;
}
#-#############################################
# desc: returns page title
# param: [optional] any custom error to display  //ERROR CHECK
function getPageTitle($linkPage,$pageLink,$precisedLink,$subCategory,$category){
//    $sql = "select * from  pc_counter_top_title where link_name = '".$this->escape($linkPage)."' and is_active = '1'";
      $sql = "select * from  pc_counter_manage_content where content_name = '".$this->escape($linkPage)."' and is_active = '1'";
	if($pageLink == "deal_store_subcategory.php")
	{	
		if($precisedLink=="category")
		{
			if(isset($subCategory))
			{
				$subcatArr = explode(',',$subCategory);
				if(count($subcatArr)>1)
					$sql = "select title, title_name, title_desc, meta_tag, meta_content from pc_counter_manage_categories where is_active = '1' and id = '".$this->escape($category)."'";
				else 
					$sql = "select title, title_name, title_desc, meta_tag, meta_content from pc_counter_manage_categories where is_active = '1' and id = '".$this->escape($subCategory)."'";		
			}
			else 
			{
				$sql = "select title, title_name, title_desc, meta_tag, meta_content from pc_counter_manage_categories where is_active = '1' and id = '".$this->escape($category)."'";
			}
		}
	}	
    
    $out = $this->fetch_array_unformat($sql);
    return $out;
}
#-#############################################
# desc: returns products
# param: [optional] any custom error to display  //ERROR CHECK
function getLastOnlineDeals(){
	$sql = "select product_id, deal_sources_id,deal_type, title, image_url, actual_price, description, deal_url,deal_price
            from ".$this->escape(TABLE_PRODUCT)." where deal_coupon = 'd' and is_active = 1 and deal_price >= '5' order by rand() DESC limit 0,100";
       
        $out  = $this->fetch_all_array($sql);
        
	return $out;
}
#-#############################################
# desc: returns deal_source name
# param: [optional] any custom error to display  //ERROR CHECK
function dealSourceName($rowId){
	$sql = "select deal_source_name from ".MANAGE_DEAL_SOURCE." where deal_source_id = ".$this->escape($rowId);

        $out  = $this->fetch_array_unformat($sql);

	return $out;
}

#-#############################################
# desc: returns products
# param: [optional] any custom error to display  //ERROR CHECK
function getNewestOnlineCoupons(){
        $sql = "select product_id, deal_sources_id,deal_type, title, image_url, actual_price, description, deal_url,deal_price
							from ".TABLE_PRODUCT." where deal_coupon = 'c' and is_active = 1 order by product_id desc limit 0, 9";

        $out  = $this->fetch_array_unformat($sql);

	return $out;
}

}//CLASS Database
###################################################################################################

?>