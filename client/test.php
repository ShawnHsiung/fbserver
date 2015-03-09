<!DOCTYPE html>
<html>
<head>
<script src="http://cdnjs.cloudflare.com/ajax/libs/knockout/2.3.0/knockout-min.js"></script>
<script src="http://code.jquery.com/jquery.min.js"></script>
<link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="http://getbootstrap.com/dist/js/bootstrap.js"></script>
<meta charset=utf-8 />
<title>JS Bin</title>


</head>
<body>
  
    <select  id="sss">
    <option>Select group </option>
    <option>Select 1 </option>  
    <option>Select 2 </option>
</select>
  <script> 

$(document).ready(function() {
            $('#sss').change(function() {
                console.log($(this).val());             
            });
        });


</script>
</body>
</html>