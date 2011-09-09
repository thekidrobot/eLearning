<?
 include("session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta name="keywords" content="" />
 <meta name="description" content="" />
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <link rel="stylesheet" href="../css/style_admin.css"> 
 <link rel="stylesheet" href="../css/forms.css"> 
 <title><?=$website_name ?></title>
 
  <script language="javascript">
  function seleccionar_todo()
  {
   for (i=0;i<document.formProceso.elements.length;i++)
   if(document.formProceso.elements[i].type == "checkbox")
   document.formProceso.elements[i].checked=1
  } 
 
  function deseleccionar_todo()
  {
   for (i=0;i<document.formProceso.elements.length;i++)
   if(document.formProceso.elements[i].type == "checkbox")
   document.formProceso.elements[i].checked=0
  } 
 </script>
  
 <script language="javascript">
  function seleccionar_todo_usr()
  {
   for (i=0;i<document.f1.elements.length;i++)
   if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].id == "usuario")
   document.f1.elements[i].checked=1
  } 
 
  function deseleccionar_todo_usr()
  {
   for (i=0;i<document.f1.elements.length;i++)
   if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].id == "usuario")
   document.f1.elements[i].checked=0
  } 
 </script> 

 <script type="text/javascript" src="../js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
 <link href="../css/datepicker.css" rel="stylesheet" type="text/css" /> 

 <script language="javascript" src="../js/core.js"></script>
</head>