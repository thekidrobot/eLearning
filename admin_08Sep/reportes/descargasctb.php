<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "descargas", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "descargas_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "descargas_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "descargas_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "descargas_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "descargas_orderby", TRUE);

// Table level SQL
define("EW_REPORT_TABLE_REPORT_COLUMN_FLD", "Date_Format(videosvistos.fecha, '%c/%Y')", TRUE); // Column field
define("EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE", "", TRUE); // Column date type
define("EW_REPORT_TABLE_REPORT_SUMMARY_FLD", "(`cantidad`)", TRUE); // Summary field
define("EW_REPORT_TABLE_REPORT_SUMMARY_TYPE", "COUNT", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_CAPTIONS", "", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_NAMES", "", TRUE);
define("EW_REPORT_TABLE_REPORT_COLUMN_VALUES", "", TRUE); // Column values
$EW_REPORT_TABLE_SQL_FROM = "(videos Inner Join videosvistos On videos.Idvideo = videosvistos.Idvideo) Inner Join usuarios On videosvistos.IdUsuario = usuarios.IdUsuario";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT videos.nombre AS `nombre`, usuarios.Usuario AS `Usuario`, <DistinctColumnFields> FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "videos.nombre, usuarios.Usuario";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "videos.nombre ASC, usuarios.Usuario ASC";
$EW_REPORT_TABLE_DISTINCT_SQL_SELECT = "SELECT DISTINCT Date_Format(videosvistos.fecha, '%c/%Y') FROM (videos Inner Join videosvistos On videos.Idvideo = videosvistos.Idvideo) Inner Join usuarios On videosvistos.IdUsuario = usuarios.IdUsuario";
$EW_REPORT_TABLE_DISTINCT_SQL_WHERE = "";
$EW_REPORT_TABLE_DISTINCT_SQL_ORDERBY = "Date_Format(videosvistos.fecha, '%c/%Y')";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "videos.nombre", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `nombre` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT <DistinctColumnFields> FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_GROUPBY_AGG = "";
$af_nombre = NULL; // Popup filter for nombre
$af_Usuario = NULL; // Popup filter for Usuario
$af_fecha = NULL; // Popup filter for fecha
$af_mes = NULL; // Popup filter for mes
$af_cantidad = NULL; // Popup filter for cantidad
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 3; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Field fecha

$sv1_fecha = ""; $sv1d_fecha = "";
$sv2_fecha = ""; $sv2d_fecha = "";
$so1_fecha = ""; $so1d_fecha = "";
$so2_fecha = ""; $so2d_fecha = "";
$sc_fecha = ""; $scd_fecha = "";

// Custom filters
$ewrpt_CustomFilters = array();
?>
<?php

// Static group variables
$x_nombre = NULL;
$o_nombre = NULL;
$t_nombre = NULL;
$g_nombre = NULL;
$ft_nombre = 200;
$rf_nombre = NULL;
$rt_nombre = NULL;
$x_Usuario = NULL;
$o_Usuario = NULL;
$t_Usuario = NULL;
$g_Usuario = NULL;
$ft_Usuario = 201;
$rf_Usuario = NULL;
$rt_Usuario = NULL;

// Column variables
$x_mes = NULL;
$ft_mes = 200;
$rf_mes = NULL;
$rt_mes = NULL;

// Summary variables
$x_cantidad = NULL;
$rowsmry = NULL; // row summary
?>
<?php

// Filter
$sFilter = "";
$sButtonImage = "";
$sDivDisplay = FALSE;

// Get sort
$sSort = getSort();

// Set up groups per page dynamically
SetUpDisplayGrps();

// Popup values and selections
// Load default filter values

LoadDefaultFilters();

// Set up popup filter
SetupPopup();

// Extended filter
$sExtendedFilter = "";

// Get dropdown values
GetExtendedFilterValues();

// Set up custom filters
SetupCustomFilters();

// Build extended filter
$sExtendedFilter = GetExtendedFilter();
if ($sExtendedFilter <> "") {
	if ($sFilter <> "")
  		$sFilter = "($sFilter) AND ($sExtendedFilter)";
	else
		$sFilter = $sExtendedFilter;
}

// Load columns to array
GetColumns();

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
	if ($sFilter <> "")
  		$sFilter = "($sFilter) AND ($sPopupFilter)";
	else
		$sFilter = $sPopupFilter;
}

// Check if filter applied
$bFilterApplied = CheckFilter();

// Get total group count
$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_GROUP, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, "", $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
$nTotalGrps = GetGrpCnt($sSql);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Show header
$bShowFirstHeader = ($nTotalGrps > 0);

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get total groups
$rsgrp = GetGrpRs($sSql, $nStartGrp, $nDisplayGrps);

// Init detail recordset
$rs = NULL;
?>
<?php include "phprptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "/";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<script type="text/javascript">

function ewrpt_ValidateExtFilter(form_obj) {
var elm = form_obj.sv1_fecha;
if (elm && !ewrpt_CheckEuroDate(elm.value)) {
	if (!ewrpt_OnError(elm, "Incorrect date, format = dd/mm/yyyy - Fecha"))
		return false;
}
var elm = form_obj.sv2_fecha;
if (elm && !ewrpt_CheckEuroDate(elm.value)) {
	if (!ewrpt_OnError(elm, "Incorrect date, format = dd/mm/yyyy - Fecha"))
		return false;
}
	return true;
}
</script>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";

// popup fields
</script>
<!-- Table container (begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top container (begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
Descargas
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="descargasctb.php?export=excel">Export to Excel</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="descargasctb.php?cmd=reset">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top container (end) -->
<tr>
	<!-- Left container (begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- left slot -->
	</div></td>
	<!-- Left container (end) -->
	<!-- Center container (report) (begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- crosstab report starts -->
<div id="report_crosstab">
<?php if (@$sExport == "") { ?>
<?php
if (EW_REPORT_FILTER_PANEL_OPTION == 2 || (EW_REPORT_FILTER_PANEL_OPTION == 3 && $bFilterApplied) || $sFilter == "0=101") {
	$sButtonImage = "phprptimages/collapse.gif";
	$sDivDisplay = "";
} else {
	$sButtonImage = "phprptimages/expand.gif";
	$sDivDisplay = " style=\"display: none;\"";
}
?>
<a href="javascript:ewrpt_ToggleFilterPanel();" style="text-decoration: none;"><img id="ewrptToggleFilterImg" src="<?php echo $sButtonImage ?>" alt="" width="9" height="9" border="0"></a><span class="phpreportmaker">&nbsp;Filters</span><br /><br />
<div id="ewrptExtFilterPanel"<?php echo $sDivDisplay ?>>
<!-- Search form (begin) -->
<form name="fdescargascrosstabfilter" id="fdescargascrosstabfilter" action="descargasctb.php" class="ewForm" onSubmit="return ewrpt_ValidateExtFilter(this);">
<table class="ewRptExtFilter">
	<tr>
		<td><span class="phpreportmaker">Fecha</span></td>
		<td><span class="ewRptSearchOpr">between<input type="hidden" name="so1_fecha" id="so1_fecha" value="BETWEEN"></span></td>
		<td>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpreportmaker">
<input type="text" name="sv1_fecha" id="sv1_fecha" value="<?php echo ewrpt_HtmlEncode($sv1_fecha) ?>"<?php echo ($sClearExtFilter == 'descargas_fecha') ? " class=\"ewInputCleared\"" : "" ?>>
<img src="phprptimages/calendar.png" id="csv1_fecha" alt="" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "sv1_fecha", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "csv1_fecha" // ID of the button
})
</script>
</span></td>
				<td><span class="ewRptSearchOpr" id="btw1_fecha" name="btw1_fecha">&nbsp;and&nbsp;</span></td>
				<td><span class="phpreportmaker" id="btw1_fecha" name="btw1_fecha">
<input type="text" name="sv2_fecha" id="sv2_fecha" value="<?php echo ewrpt_HtmlEncode($sv2_fecha) ?>"<?php echo ($sClearExtFilter == 'descargas_fecha') ? " class=\"ewInputCleared\"" : "" ?>>
<img src="phprptimages/calendar.png" id="csv2_fecha" alt="" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "sv2_fecha", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "csv2_fecha" // ID of the button
})
</script>
</span></td>
			</tr></table>			
		</td>
	</tr>
</table>
<table class="ewRptExtFilter">
	<tr>
		<td><span class="phpreportmaker">
			<input type="Submit" name="Submit" id="Submit" value="Search">&nbsp;
			<input type="Reset" name="Reset" id="Reset" value="Reset">&nbsp;
		</span></td>
	</tr>
</table>
</form>
<!-- Search form (end) -->
</div>
<br />
<?php } ?>
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="descargasctb.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="descargasctb.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="descargasctb.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="descargasctb.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="descargasctb.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php if ($bShowFirstHeader) { // Show header ?>
	<thead>
	<!-- Table header -->
	<tr class="ewTableRow">
		<td colspan="2" nowrap><div class="phpreportmaker">Cantidad (COUNT)&nbsp;</div></td>
		<td class="ewRptColHeader" colspan="<?php echo @$ncolspan; ?>" nowrap>
			Mes
		</td>
	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td class="ewRptGrpHeader1">
		Nombre
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Nombre</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td class="ewRptGrpHeader2">
		Usuario
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Usuario</td>
			</tr></table>
		</td>
<?php } ?>
<!-- Dynamic columns begin -->
	<?php
	$cntval = count($val);
	for ($iy = 1; $iy < $cntval; $iy++) {
		if ($col[$iy][2]) {
			$x_mes = $col[$iy][1];
	?>
		<td class="ewTableHeader" valign="top">
<?php echo ewrpt_ViewValue($x_mes) ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
	</thead>
<?php } // End show header ?>
	<tbody>
<?php
if ($nTotalGrps > 0) {

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps)) {
	$nStopGrp = $nTotalGrps;
}

// Navigate
$grpvalue = "";
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
	GetGrpRow(1);
	$nGrpCount = 1;
}
while ($rsgrp && !$rsgrp->EOF) {

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_nombre, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_nombre, EW_REPORT_DATATYPE_STRING);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, "", $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	while ($rs && !$rs->EOF) {
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$g_nombre = $x_nombre;
		if ($x_nombre <> "" && $o_nombre == $x_nombre && !ChkLvlBreak(1)) {
			$g_nombre = "&nbsp;";
		} elseif (is_null($x_nombre)) {
			$g_nombre = EW_REPORT_NULL_LABEL;
		} elseif ($x_nombre == "") {
			$g_nombre = EW_REPORT_EMPTY_LABEL;
		}
		$g_Usuario = $x_Usuario;
		if ($x_Usuario <> "" && $o_Usuario == $x_Usuario && !ChkLvlBreak(2)) {
			$g_Usuario = "&nbsp;";
		} elseif (is_null($x_Usuario)) {
			$g_Usuario = EW_REPORT_NULL_LABEL;
		} elseif ($x_Usuario == "") {
			$g_Usuario = EW_REPORT_EMPTY_LABEL;
		}
?>
	<!-- Data -->
	<tr>
		<!-- Nombre -->
		<td class="ewRptGrpField1"><?php $t_nombre = $x_nombre; $x_nombre = $g_nombre; ?>
<?php echo ewrpt_ViewValue($x_nombre) ?>
<?php $x_nombre = $t_nombre; ?></td>
		<!-- Usuario -->
		<td class="ewRptGrpField2"><?php $t_Usuario = $x_Usuario; $x_Usuario = $g_Usuario; ?>
<?php echo ewrpt_ViewValue($x_Usuario) ?>
<?php $x_Usuario = $t_Usuario; ?></td>
<!-- Dynamic columns begin -->
	<?php
		$rowsmry = 0;
		$cntval = count($val);
		for ($iy = 1; $iy < $cntval; $iy++) {
			if ($col[$iy][2]) {
				$rowval = $val[$iy];
				$rowsmry = ewrpt_SummaryValue($rowsmry, $rowval, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
				$x_cantidad = $val[$iy];
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cantidad) ?>
</td>
	<?php
			}
		}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_nombre = $x_nombre;
		$o_Usuario = $x_Usuario;

		// Get next record
		GetRow(2);
?>
<?php
	} // End detail records loop

	// Save old group values
	$o_fecha = $x_nombre; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
?>
<?php
}
?>
	</tbody>
	<tfoot>
	<!-- Grand Total -->
	<tr class="ewRptGrandSummary">
	<td colspan="2">Grand Total</td>
<!-- Dynamic columns begin -->
	<?php 

	// aggregate sql
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_AGG, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY_AGG, "", "", $sFilter, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rsagg = $conn->Execute($sSql);
	if ($rsagg && !$rsagg->EOF) $rsagg->MoveFirst();

//	echo "record count: " . $rsagg->RecordCount() . "<br>";
	$rowsmry = 0;

	// Use data from recordset directly
	for ($iy = 1; $iy <= $ncol; $iy++) {
		if ($col[$iy][2]) {
			$rowval = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$iy+0-1] : 0;

//echo "rowval: $rowval<br>";
			$rowsmry = ewrpt_SummaryValue($rowsmry, $rowval, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
			$x_cantidad = $rowval;
	?>
		<!-- <?php echo $col[$iy][1]; ?> -->
		<td>
<?php echo ewrpt_ViewValue($x_cantidad) ?>
</td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
</td></tr></table>
</div>
<!-- Crosstab report ends -->
<?php if (@$sExport == "") { ?>
	</div><br /></td>
	<!-- Center container (report) (end) -->
	<!-- Right container (begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- right slot -->
	</div></td>
	<!-- Right container (end) -->
</tr>
<!-- Bottom container (begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- bottom slot -->
	</div><br /></td></tr>
<!-- Bottom container (end) -->
</table>
<!-- Table container (end) -->
<?php } ?>
<?php

// Close recordset and connection
if ($rs)
	$rs->Close();
$conn->Close();

// Display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/footer.php"; ?>
<?php

// Get column values
function GetColumns() {
	global $conn;
	global $EW_REPORT_TABLE_SQL_SELECT;
	global $EW_REPORT_TABLE_SQL_SELECT_AGG;
	global $EW_REPORT_TABLE_DISTINCT_SQL_SELECT;
	global $EW_REPORT_TABLE_DISTINCT_SQL_WHERE;
	global $EW_REPORT_TABLE_DISTINCT_SQL_ORDERBY;
	global $sFilter, $sSort;
	global $ncol, $col, $val, $valcnt, $cnt, $smry, $smrycnt, $ncolspan;
	global $sel_mes;

	// Build SQL
	//$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_DISTINCT_SQL_SELECT, $EW_REPORT_TABLE_DISTINCT_SQL_WHERE, "", "", $EW_REPORT_TABLE_DISTINCT_SQL_ORDERBY, $sFilter, @$sSort);

	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_DISTINCT_SQL_SELECT, $EW_REPORT_TABLE_DISTINCT_SQL_WHERE, "", "", $EW_REPORT_TABLE_DISTINCT_SQL_ORDERBY, "", "");

	// Load recordset
	$rscol = $conn->Execute($sSql);

	// Get distinct column count
	$ncol = ($rscol) ? $rscol->RecordCount() : 0;
	if ($ncol == 0) {
		$rscol->Close();
		echo "No distinct column values for sql: " . $sSql . "<br />";
		exit();
	}

	// 1st dimension = no of groups (level 0 used for grand total)
	// 2nd dimension = no of distinct values

	$nGrps = 2;
	$col = ewrpt_Init2DArray($ncol+1, 2, NULL);
	$val = ewrpt_InitArray($ncol+1, NULL);
	$valcnt = ewrpt_InitArray($ncol+1, NULL);
	$cnt = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);
	$smry = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);
	$smrycnt = ewrpt_Init2DArray($ncol+1, $nGrps+1, NULL);

	// Reset summary values
	ResetLevelSummary(0);
	$colcnt = 0;
	while (!$rscol->EOF) {
		if (is_null($rscol->fields[0])) {
			$wrkValue = "";
			$wrkCaption = EW_REPORT_NULL_LABEL;
		} elseif ($rscol->fields[0] == "") {
			$wrkValue = "";
			$wrkCaption = EW_REPORT_EMPTY_LABEL;
		} else {
			$wrkValue = $rscol->fields[0];
			$wrkCaption = $rscol->fields[0];
		}
		$colcnt++;
		$col[$colcnt][0] = $wrkValue; // value
		$col[$colcnt][1] = $wrkCaption; // caption
		$col[$colcnt][2] = TRUE; // column visible
		$rscol->MoveNext();
	}
	$rscol->Close();

	// Get active columns
	if (!is_array($sel_mes)) {
		$ncolspan = $ncol;
	} else {
		$ncolspan = 0;
		$cntcol = count($col);
		for ($i = 0; $i < $cntcol; $i++) {
			$bSelected = FALSE;
			$cntsel = count($sel_mes);
			for ($j = 0; $j < $cntsel; $j++) {

//				if (trim($sel_mes[$j]) == trim($col[$i][0])) {
				if (ewrpt_CompareValue($sel_mes[$j], $col[$i][0], $GLOBALS["ft_mes"])) {
					$ncolspan++;
					$bSelected = TRUE;
					break;
				}
			}
			$col[$i][2] = $bSelected;
		}
	}

	// Update crosstab sql
	$sSqlFlds = "";
	for ($colcnt = 1; $colcnt <= $ncol; $colcnt++) {
		$sFld = ewrpt_CrossTabField(EW_REPORT_TABLE_REPORT_SUMMARY_TYPE, EW_REPORT_TABLE_REPORT_SUMMARY_FLD, EW_REPORT_TABLE_REPORT_COLUMN_FLD, EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE, $col[$colcnt][0], "'", "C" . $colcnt);
		if ($sSqlFlds <> "")
			$sSqlFlds .= ", ";
		$sSqlFlds .= $sFld;
	}
	$EW_REPORT_TABLE_SQL_SELECT = str_replace("<DistinctColumnFields>", $sSqlFlds, $EW_REPORT_TABLE_SQL_SELECT);
	$EW_REPORT_TABLE_SQL_SELECT_AGG = str_replace("<DistinctColumnFields>", $sSqlFlds, $EW_REPORT_TABLE_SQL_SELECT_AGG);

	// Update chart sql if Y Axis = Column Field
	$sSqlChtFld = "";
	for ($i = 0; $i < $ncol; $i++) {
		if ($col[$i+1][2]) {
			$sChtFld = ewrpt_CrossTabField("SUM", EW_REPORT_TABLE_REPORT_SUMMARY_FLD, EW_REPORT_TABLE_REPORT_COLUMN_FLD, EW_REPORT_TABLE_REPORT_COLUMN_DATE_TYPE, $col[$i+1][0], "'");
			if ($sSqlChtFld != "") $sSqlChtFld .= "+";
			$sSqlChtFld .= $sChtFld;
		}
	}
}

// Get group count
function GetGrpCnt($sql) {
	global $conn;

	//echo "sql (GetGrpCnt): " . $sql . "<br>";
	$rsgrpcnt = $conn->Execute($sql);
	$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
	return $grpcnt;
}

// Get group rs
function GetGrpRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
}

// Get group row values
function GetGrpRow($opt) {
	global $rsgrp;
	if (!$rsgrp)
		return;
	if ($opt == 1) { // Get first group
		$rsgrp->MoveFirst();
	} else { // Get next group
		$rsgrp->MoveNext();
	}
	if ($rsgrp->EOF) {
		$GLOBALS['x_nombre'] = "";
	} else {
		$GLOBALS['x_nombre'] = $rsgrp->fields('nombre');
	}
}

// Get row values
function GetRow($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	if (!$rs->EOF) {
		$GLOBALS['x_Usuario'] = $rs->fields('Usuario');
		$cntval = count($val);
		for ($ix = 1; $ix < $cntval; $ix++)
			$val[$ix] = $rs->fields[$ix+2-1];
	} else {
		$GLOBALS['x_Usuario'] = "";
	}
}

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return (is_null($GLOBALS["x_nombre"]) && !is_null($GLOBALS["o_nombre"])) ||
			(!is_null($GLOBALS["x_nombre"]) && is_null($GLOBALS["o_nombre"])) ||
			($GLOBALS["x_nombre"] <> $GLOBALS["o_nombre"]);
		case 2:
			return (is_null($GLOBALS["x_Usuario"]) && !is_null($GLOBALS["o_Usuario"])) ||
			(!is_null($GLOBALS["x_Usuario"]) && is_null($GLOBALS["o_Usuario"])) ||
			($GLOBALS["x_Usuario"] <> $GLOBALS["o_Usuario"]) || ChkLvlBreak(1); // Recurse upper level
	}
}

// Accummulate summary
function AccumulateSummary() {
	global $val, $cnt, $smry;
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 0; $iy < $cnty; $iy++) {
			$valwrk = $val[$ix];
			$cnt[$ix][$iy]++;
			$smry[$ix][$iy] = ewrpt_SummaryValue($smry[$ix][$iy], $valwrk, EW_REPORT_TABLE_REPORT_SUMMARY_TYPE);
		}
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {

	// Clear summary values
	global $nRecCount, $cnt, $smry, $smrycnt;
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = $lvl; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy] = 0;
			$smry[$ix][$iy] = 0;
		}
	}

	// Reset record count
	$nRecCount = 0;
}

// Set up starting group
function SetUpStartGroup() {
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Exit if no groups
	if ($nDisplayGrps == 0)
		return;

	// Check for a 'start' parameter
	if (@$_GET[EW_REPORT_TABLE_START_GROUP] != "") {
		$nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$_GET["pageno"] != "") {
		$nPageNo = $_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];	
		}
	} else {
		$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];
	}

	// Check if correct start group counter
	if (!is_numeric($nStartGrp) || $nStartGrp == "") { // Avoid invalid start group counter
		$nStartGrp = 1; // Reset start group counter
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (intval($nStartGrp) > intval($nTotalGrps)) { // Avoid starting group > total groups
		$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to last page first group
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (($nStartGrp-1) % $nDisplayGrps <> 0) {
		$nStartGrp = intval(($nStartGrp-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to page boundary
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	}
}

// Set up popup
function SetupPopup() {
	global $conn, $sFilter;

	// Process post back form
	if (count($_POST) > 0) {
		$sName = @$_POST["popup"]; // Get popup form name
		if ($sName <> "") {
			$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
			if ($cntValues > 0) {
				$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
				if (trim($arValues[0]) == "") // Select all
					$arValues = EW_REPORT_INIT_VALUE;
				if (!ewrpt_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
					if (HasSessionFilterValues($sName))
						$GLOBALS["sClearExtFilter"] = $sName; // Clear extended filter for this field
				}
				$_SESSION["sel_$sName"] = $arValues;
				$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
				$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
				ResetPager();
			}
		}

	// Get 'reset' command
	} elseif (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}

	// Load selection criteria to array
}

// Reset pager
function ResetPager() {
	global $nStartGrp;

	// Reset start position (reset command)
	$nStartGrp = 1;
	$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}

// Check if any column values is present
function HasColumnValues(&$rs) {
	global $col;
	$cntcol = count($col);
	for ($i = 1; $i < $cntcol; $i++) {
		if ($col[$i][2]) {
			if ($rs->fields[2+$i-1] <> 0) return TRUE;
		}
	}
	return FALSE;
}
?>
<?php

// Set up number of groups displayed per page
function SetUpDisplayGrps() {
	global $nDisplayGrps, $nStartGrp;
	$sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // display all groups
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 3; // Non-numeric, load default
			}
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

		// Reset start position (reset command)
		$nStartGrp = 1;
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
		} else {
			$nDisplayGrps = 3; // Load default
		}
	}
}
?>
<?php

// Get extended filter values
function GetExtendedFilterValues() {
}

// Return extended filter
function GetExtendedFilter() {
	$sFilter = "";
	$bPostBack = (count($_POST) > 0);
	$bRestoreSession = TRUE;
	$bSetupFilter = FALSE;

	// Reset extended filter if filter changed
	if ($bPostBack) {

	// Reset search command
	} elseif (@$_GET["cmd"] == "reset") {

		// Load default values
		// Field fecha

		SetSessionFilterValues($GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"], 'fecha');
		$bSetupFilter = TRUE;
	} else {

		// Field fecha
		if (GetFilterValues($GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"], 'fecha')) {
			$bSetupFilter = TRUE;
			$bRestoreSession = FALSE;
		}
	}

	// Restore session
	if ($bRestoreSession) {

		// Field fecha
		GetSessionFilterValues($GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"], 'fecha');
	}

	// Build SQL
	// Field fecha

	BuildExtendedFilter($sFilter, 'fecha', 'videosvistos.fecha', EW_REPORT_DATATYPE_DATE, 7, $GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"]);

	// Save parms to session
	// Field fecha

	SetSessionFilterValues($GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"], 'fecha');

	// Setup filter
	if ($bSetupFilter) {
	}
	return $sFilter;
}

// Get drop down value from querystring
function GetDropDownValue(&$sv, $parm) {
	if (count($_POST) > 0)
		return FALSE; // Skip post back
	if (isset($_GET["sv_$parm"])) {
		$sv = ewrpt_StripSlashes($_GET["sv_$parm"]);
		return TRUE;
	}
	return FALSE;
}

// Get filter values from querystring
function GetFilterValues(&$sv1, &$so1, &$sc, &$sv2, &$so2, $parm) {
	if (count($_POST) > 0)
		return; // Skip post back
	$got = FALSE;
	if (isset($_GET["sv1_$parm"])) {
		$sv1 = ewrpt_StripSlashes($_GET["sv1_$parm"]);
		$got = TRUE;
	}
	if (isset($_GET["so1_$parm"])) {
		$so1 = ewrpt_StripSlashes($_GET["so1_$parm"]);
		$got = TRUE;
	}
	if (isset($_GET["sc_$parm"])) {
		$sc = ewrpt_StripSlashes($_GET["sc_$parm"]);
		$got = TRUE;
	}
	if (isset($_GET["sv2_$parm"])) {
		$sv2 = ewrpt_StripSlashes($_GET["sv2_$parm"]);
		$got = TRUE;
	}
	if (isset($_GET["so2_$parm"])) {
		$so2 = ewrpt_StripSlashes($_GET["so2_$parm"]);
		$got = TRUE;
	}
	return $got;
}

// Set default ext filter
function SetDefaultExtFilter($parm, $so1, $sv1, $sc, $so2, $sv2) {
	$GLOBALS["sv1d_$parm"] = $sv1; // Default ext filter value 1
	$GLOBALS["sv2d_$parm"] = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
	$GLOBALS["so1d_$parm"] = $so1; // Default search operator 1
	$GLOBALS["so2d_$parm"] = $so2; // Default search operator 2 (if operator 2 is enabled)
	$GLOBALS["scd_$parm"] = $sc; // Default search condition (if operator 2 is enabled)
}

// Apply default ext filter
function ApplyDefaultExtFilter($parm) {
	$GLOBALS["sv1_$parm"] = $GLOBALS["sv1d_$parm"];
	$GLOBALS["sv2_$parm"] = $GLOBALS["sv2d_$parm"];
	$GLOBALS["so1_$parm"] = $GLOBALS["so1d_$parm"];
	$GLOBALS["so2_$parm"] = $GLOBALS["so2d_$parm"];
	$GLOBALS["sc_$parm"] = $GLOBALS["scd_$parm"];
}

// Check if Text Filter applied
function TextFilterApplied($parm) {
	return (strval($GLOBALS["sv1_$parm"]) <> strval($GLOBALS["sv1d_$parm"]) ||
		strval($GLOBALS["sv2_$parm"]) <> strval($GLOBALS["sv2d_$parm"]) ||
		(strval($GLOBALS["sv1_$parm"]) <> "" &&
			strval($GLOBALS["so1_$parm"]) <> strval($GLOBALS["so1d_$parm"])) ||
		(strval($GLOBALS["sv2_$parm"]) <> "" &&
			strval($GLOBALS["so2_$parm"]) <> strval($GLOBALS["so2d_$parm"])) ||
		strval($GLOBALS["sc_$parm"]) <> strval($GLOBALS["scd_$parm"]));
}

// Check if Non-Text Filter applied
function NonTextFilterApplied($parm) {
	if (is_array($GLOBALS["svd_$parm"]) && is_array($GLOBALS["sv_$parm"])) {
		if (count($GLOBALS["svd_$parm"]) <> count($GLOBALS["sv_$parm"]))
			return TRUE;
		else
			return (count(array_diff($GLOBALS["svd_$parm"], $GLOBALS["sv_$parm"])) <> 0);
	}
	else {
		$v1 = strval($GLOBALS["svd_$parm"]);
		if ($v1 == EW_REPORT_INIT_VALUE)
			$v1 = "";
		$v2 = strval($GLOBALS["sv_$parm"]);
		if ($v2 == EW_REPORT_INIT_VALUE || $v2 == EW_REPORT_ALL_VALUE)
			$v2 = "";
		return ($v1 <> $v2);
	}
}

// Load selection from a filter clause
function LoadSelectionFromFilter($parm, $filter, &$sel) {
	$sel = "";
	if ($filter <> "") {

//		$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_" . strtoupper($parm) . "_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_" . strtoupper($parm) . "_SQL_ORDERBY"], $filter, "");
		$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_" . strtoupper($parm) . "_SQL_SELECT"], "", "", "", $GLOBALS["EW_REPORT_FIELD_" . strtoupper($parm) . "_SQL_ORDERBY"], $filter, "");
		ewrpt_LoadArrayFromSql($sSql, $sel);
	}
}

// Get dropdown value from session
function GetSessionDropDownValue(&$sv, $parm) {
	GetSessionValue($sv, 'sv_descargas_' . $parm);
}

// Get filter values from session
function GetSessionFilterValues(&$sv1, &$so1, &$sc, &$sv2, &$so2, $parm) {
	GetSessionValue($sv1, 'sv1_descargas_' . $parm);
	GetSessionValue($so1, 'so1_descargas_' . $parm);
	GetSessionValue($sc, 'sc_descargas_' . $parm);
	GetSessionValue($sv2, 'sv2_descargas_' . $parm);
	GetSessionValue($so2, 'so2_descargas_' . $parm);
}

// Get value from session
function GetSessionValue(&$sv, $sn) {
	if (isset($_SESSION[$sn]))
		$sv = $_SESSION[$sn];
}

// Set dropdown value to session
function SetSessionDropDownValue($sv, $parm) {
	$_SESSION['sv_descargas_' . $parm] = $sv;
}

// Set filter values to session
function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
	$_SESSION['sv1_descargas_' . $parm] = $sv1;
	$_SESSION['so1_descargas_' . $parm] = $so1;
	$_SESSION['sc_descargas_' . $parm] = $sc;
	$_SESSION['sv2_descargas_' . $parm] = $sv2;
	$_SESSION['so2_descargas_' . $parm] = $so2;
}

// Check if has Session filter values
function HasSessionFilterValues($parm) {
	return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EW_REPORT_INIT_VALUE) ||
		(@$_SESSION['sv1_' . $parm] <> "" && @$_SESSION['sv1_' . $parm] <> EW_REPORT_INIT_VALUE) ||
		(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EW_REPORT_INIT_VALUE));
}

// Dropdown filter exist
function DropDownFilterExist($FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal, $FldOpr) {
	$sWrk = "";
	BuildDropDownFilter($sWrk, $FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal, $FldOpr);
	return ($sWrk <> "");
}

// Build dropdown filter
function BuildDropDownFilter(&$FilterClause, $FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal, $FldOpr) {
	$sSql = "";
	if (is_array($FldVal)) {
		foreach ($FldVal as $val) {
			$sWrk = getDropDownfilter($FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $val, $FldOpr);
			if ($sWrk <> "") {
				if ($sSql <> "")
					$sSql .= " OR " . $sWrk;
				else
					$sSql = $sWrk;
			}
		}
	} else {
		$sSql = getDropDownfilter($FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal, $FldOpr);
	}
	if ($sSql <> "") {
		if ($FilterClause <> "") $FilterClause = "(" . $FilterClause . ") AND ";
		$FilterClause .= "(" . $sSql . ")";
	}
}

function getDropDownfilter($FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal, $FldOpr) {
	$sWrk = "";
	if ($FldVal == EW_REPORT_NULL_VALUE) {
		$sWrk = $FldExpression . " IS NULL";
	} elseif ($FldVal == EW_REPORT_EMPTY_VALUE) {
		$sWrk = $FldExpression . " = ''";
	} else {
		if (substr($FldVal, 0, 2) == "@@") {
			$sWrk = CustomFilter($FldName, $FldExpression, $FldVal);
		} else {
			if ($FldVal <> "" && $FldVal <> EW_REPORT_INIT_VALUE && $FldVal <> EW_REPORT_ALL_VALUE) {
				if ($FldDataType == EW_REPORT_DATATYPE_DATE && $FldOpr <> "") {
					$sWrk = DateFilterString($FldOpr, $FldVal, $FldDataType);
				} else {
					$sWrk = FilterString("=", $FldVal, $FldDataType);
				}
			}
			if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
		}
	}
	return $sWrk;
}

// Register custom filter
function RegisterCustomFilter($FldName, $FilterName, $DisplayName, $FldExpression, $FunctionName) {
	global $ewrpt_CustomFilters;
	if (!is_array($ewrpt_CustomFilters))
		$ewrpt_CustomFilters = array();
	$ewrpt_CustomFilters[] = array($FldName, $FilterName, $DisplayName, $FldExpression, $FunctionName);
}

// Custom filter
function CustomFilter($FldName, $FldExpression, $FldVal) {
	global $ewrpt_CustomFilters;
	$sWrk = "";
	$sParm = substr($FldVal, 2);
	if (is_array($ewrpt_CustomFilters)) {
		$cntf = count($ewrpt_CustomFilters);
		for ($i = 0; $i < $cntf; $i++) {
			if ($ewrpt_CustomFilters[$i][0] == $FldName && $ewrpt_CustomFilters[$i][1] == $sParm) {
				$sFld = $ewrpt_CustomFilters[$i][3];
				$sFn = $ewrpt_CustomFilters[$i][4];
				$sWrk = $sFn($sFld);
				break;
			}
		}
	}
	return $sWrk;
}

// Extended filter exist
function ExtendedFilterExist($FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal1, $FldOpr1, $FldCond, $FldVal2, $FldOpr2) {
	$sExtWrk = "";
	BuildExtendedFilter($sExtWrk, $FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal1, $FldOpr1, $FldCond, $FldVal2, $FldOpr2);
	return ($sExtWrk <> "");
}

// Build extended filter
function BuildExtendedFilter(&$FilterClause, $FldName, $FldExpression, $FldDataType, $FldDateTimeFormat, $FldVal1, $FldOpr1, $FldCond, $FldVal2, $FldOpr2) {
	$sWrk = "";
	$FldOpr1 = strtoupper(trim($FldOpr1));
	if ($FldOpr1 == "") $FldOpr1 = "=";
	$FldOpr2 = strtoupper(trim($FldOpr2));
	if ($FldOpr2 == "") $FldOpr2 = "=";
	$wrkFldVal1 = $FldVal1;
	$wrkFldVal2 = $FldVal2;
	if ($FldDataType == EW_REPORT_DATATYPE_BOOLEAN) {
		if ($wrkFldVal1 <> "") $wrkFldVal1 = ($wrkFldVal1 == "1") ? EW_REPORT_TRUE_STRING : EW_REPORT_FALSE_STRING;
		if ($wrkFldVal2 <> "") $wrkFldVal2 = ($wrkFldVal2 == "1") ? EW_REPORT_TRUE_STRING : EW_REPORT_FALSE_STRING;
	} elseif ($FldDataType == EW_REPORT_DATATYPE_DATE) {
		if ($wrkFldVal1 <> "") $wrkFldVal1 = ewrpt_UnFormatDateTime($wrkFldVal1, $FldDateTimeFormat);
		if ($wrkFldVal2 <> "") $wrkFldVal2 = ewrpt_UnFormatDateTime($wrkFldVal2, $FldDateTimeFormat);
	}
	if ($FldOpr1 == "BETWEEN") {
		$IsValidValue = ($FldDataType <> EW_REPORT_DATATYPE_NUMBER ||
			($FldDataType == EW_REPORT_DATATYPE_NUMBER && is_numeric($wrkFldVal1) && is_numeric($wrkFldVal2)));
		if ($wrkFldVal1 <> "" && $wrkFldVal2 <> "" && $IsValidValue)
			$sWrk = $FldExpression . " BETWEEN " . ewrpt_QuotedValue($wrkFldVal1, $FldDataType) .
				" AND " . ewrpt_QuotedValue($wrkFldVal2, $FldDataType);
	} elseif ($FldOpr1 == "IS NULL" || $FldOpr1 == "IS NOT NULL") {
		$sWrk = $FldExpression . " " . $wrkFldVal1;
	} else {
		$IsValidValue = ($FldDataType <> EW_REPORT_DATATYPE_NUMBER ||
			($FldDataType == EW_REPORT_DATATYPE_NUMBER && is_numeric($wrkFldVal1)));
		if ($wrkFldVal1 <> "" && $IsValidValue && ewrpt_IsValidOpr($FldOpr1, $FldDataType))
			$sWrk = $FldExpression . FilterString($FldOpr1, $wrkFldVal1, $FldDataType);
		$IsValidValue = ($FldDataType <> EW_REPORT_DATATYPE_NUMBER ||
			($FldDataType == EW_REPORT_DATATYPE_NUMBER && is_numeric($wrkFldVal2)));
		if ($wrkFldVal2 <> "" && $IsValidValue && ewrpt_IsValidOpr($FldOpr2, $FldDataType)) {
			if ($sWrk <> "")
				$sWrk .= " " . (($FldCond == "OR") ? "OR" : "AND") . " ";
			$sWrk .= $FldExpression . FilterString($FldOpr2, $wrkFldVal2, $FldDataType);
		}
	}
	if ($sWrk <> "") {
		if ($FilterClause <> "") $FilterClause .= " AND ";
		$FilterClause .= "(" . $sWrk . ")";
	}
}

// Return filter string
function FilterString($FldOpr, $FldVal, $FldType) {
	if ($FldOpr == "LIKE" || $FldOpr == "NOT LIKE") {
		return " " . $FldOpr . " " . ewrpt_QuotedValue("%$FldVal%", $FldType);
	} elseif ($FldOpr == "STARTS WITH") {
		return " LIKE " . ewrpt_QuotedValue("$FldVal%", $FldType);
	} else {
		return " $FldOpr " . ewrpt_QuotedValue($FldVal, $FldType);
	}
}

// Return date search string
function DateFilterString($FldOpr, $FldVal, $FldType) {
	$wrkVal1 = DateVal($FldOpr, $FldVal, 1);
	$wrkVal2 = DateVal($FldOpr, $FldVal, 2);
	if ($wrkVal1 <> "" && $wrkVal2 <> "") {
		return " BETWEEN " . ewrpt_QuotedValue($wrkVal1, $FldType) . " AND " . ewrpt_QuotedValue($wrkVal2, $FldType);
	} else {
		return "";
	}
}

// Return date value
function DateVal($FldOpr, $FldVal, $ValType) {

	// Compose date string
	switch (strtolower($FldOpr)) {
	case "year":
		if ($ValType == 1) {
			$wrkVal = "$FldVal-01-01";
		} elseif ($ValType == 2) {
			$wrkVal = "$FldVal-12-31";
		}
		break;
	case "quarter":
		list($y, $q) = explode("|", $FldVal);
		if (intval($y) == 0 || intval($q) == 0) {
			$wrkVal = "0000-00-00";
		} else {
			if ($ValType == 1) {
				$m = ($q - 1) * 3 + 1;
				$m = str_pad($m, 2, "0", STR_PAD_LEFT);
				$wrkVal = "$y-$m-01";
			} elseif ($ValType == 2) {
				$m = ($q - 1) * 3 + 3;
				$m = str_pad($m, 2, "0", STR_PAD_LEFT);
				$wrkVal = "$y-$m-" . ewrpt_DaysInMonth($y, $m);
			}
		}
		break;
	case "month":
		list($y, $m) = explode("|", $FldVal);
		if (intval($y) == 0 || intval($m) == 0) {
			$wrkVal = "0000-00-00";
		} else {
			if ($ValType == 1) {
				$m = str_pad($m, 2, "0", STR_PAD_LEFT);
				$wrkVal = "$y-$m-01";
			} elseif ($ValType == 2) {
				$m = str_pad($m, 2, "0", STR_PAD_LEFT);
				$wrkVal = "$y-$m-" . ewrpt_DaysInMonth($y, $m);
			}
		}
		break;
	case "day":
		$wrkVal = str_replace("|", "-", $FldVal);
	}

	// Add time if necessary
	if (preg_match('/(\d{4}|\d{2})-(\d{1,2})-(\d{1,2})/', $wrkVal)) { // date without time
		if ($ValType == 1) {
			$wrkVal .= " 00:00:00";
		} elseif ($ValType == 2) {
			$wrkVal .= " 23:59:59";
		}
	}

	// Check if datetime
	if (preg_match('/(\d{4}|\d{2})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})/', $wrkVal)) { // datetime
		$DateVal = $wrkVal;
	} else {
		$DateVal = "";
	}
	return $DateVal;
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_descargas_$parm"] = "";
	$_SESSION["rf_descargas_$parm"] = "";
	$_SESSION["rt_descargas_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_descargas_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_descargas_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_descargas_$parm"];
}

// Load default value for filters
function LoadDefaultFilters() {

	/**
	* Set up default values for non Text filters
	*/

	/**
	* Set up default values for extended filters
	* function SetDefaultExtFilter($parm, $so1, $sv1, $sc, $so2, $sv2)
	* Parameters:
	* $parm - Field name
	* $so1 - Default search operator 1
	* $sv1 - Default ext filter value 1
	* $sc - Default search condition (if operator 2 is enabled)
	* $so2 - Default search operator 2 (if operator 2 is enabled)
	* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
	*/

	// Field fecha
	SetDefaultExtFilter('fecha', 'BETWEEN', NULL, 'AND', '=', NULL);
	ApplyDefaultExtFilter('fecha');

	/**
	* Set up default values for popup filters
	* NOTE: if extended filter is enabled, use default values in extended filter instead
	*/
}

// Check if filter applied
function CheckFilter() {

	// Check fecha text filter
	if (TextFilterApplied("fecha"))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field fecha
	$sExtWrk = "";
	$sWrk = "";
	BuildExtendedFilter($sExtWrk, 'fecha', 'videosvistos.fecha', EW_REPORT_DATATYPE_DATE, 7, $GLOBALS["sv1_fecha"], $GLOBALS["so1_fecha"], $GLOBALS["sc_fecha"], $GLOBALS["sv2_fecha"], $GLOBALS["so2_fecha"]);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fecha<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Show Filters
	if ($sFilterList <> "")
		echo "CURRENT FILTERS:<br />$sFilterList";
}

/**
 * Regsiter your Custom filters here
 */

// Setup custom filters
function SetupCustomFilters() {

	// 1. Register your custom filter below (see example)
	// 2. Write your custom filter function (see example fucntions: GetLastMonthFilter, GetStartsWithAFilter)

}

/**
 * Write your Custom filters here
 */

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression) {
	$today = getdate();
	$lastmonth = mktime(0, 0, 0, $today['mon']-1, 1, $today['year']);
	$sVal = date("Y|m", $lastmonth);
	$sWrk = $FldExpression . " BETWEEN " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 1), EW_REPORT_DATATYPE_DATE) .
		" AND " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 2), EW_REPORT_DATATYPE_DATE);
	return $sWrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression) {
	return $FldExpression . " LIKE 'A%'";
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_descargas_nombre"] = "";
			$_SESSION["sort_descargas_Usuario"] = "";
		}

	// Check for an Order parameter
	} elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
		$sSortSql = "";
		$sSortField = "";
		$sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
		if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
			$sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
		} else {
			$sOrderType = "";
		}
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
