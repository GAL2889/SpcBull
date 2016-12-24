﻿<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>jQuery Multi Select Dropdown with Checkboxes</title>
    <link rel="stylesheet" href="css/bootstrap-3.1.1.min.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="js/bootstrap-2.3.2.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
</head>
<body>
    <form id="form1">
    <div style="padding:20px;">
        <select id="chkveg" multiple="multiple">
			                <option value="cheese">Cheese</option>
			                <option value="tomatoes">Tomatoes</option>
			                <option value="mozarella">Mozzarella</option>
			                <option value="mushrooms">Mushrooms</option>
			                <option value="pepperoni">Pepperoni</option>
			                <option value="onions">Onions</option>
			            </select><br /><br />
			            <input type="button" id="btnget" value="Get Selected Values" />
			            	<script type="text/javascript">
			            	    $(function() {
			            	        $('#chkveg').multiselect({
			            	            includeSelectAllOption: true
			            	        });
			            	        $('#btnget').click(function() {
			            	        alert($('#chkveg').val());
			            	        })
			            	    });
			</script>
			<script type="text/javascript">
			    $(document).ready(function() {
			    $('#chkveg').multiselect();
			    });
</script>
    </div>
    </form>
</body>
</html>
