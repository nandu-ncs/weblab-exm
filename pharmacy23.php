<?php 
$conn= mysqli_connect('localhost', 'root', '', 'pharmacy');
if (!$conn) {
	die('Connection error : ' . mysqli_connect_error());
}
if(isset($_POST['add'])) {
	$sql="insert into medicine(medcode,medname,quantity,unitprice) values ('$_POST[medcode]','$_POST[medname]',$_POST[quantity],$_POST[unitprice])";
	$res= mysqli_query($conn, $sql);
	if($res) {
		echo "<script>alert('Medicine Added to Bill Successfully')</script>";
		echo "<script>window.location.href=window.location.href</script>";    
	}    
}
$sql="select * from medicine";
$res= mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Management System</title>
	<style type="text/css">
		body {
			font-size: 18px;
		}
		.row {
			display: grid;
			grid-template-columns: repeat(12, 1fr);
			grid-gap: 10px;
		}
		.col-md-6 {
			grid-column: span 6;
		}
		.container {
			margin: 5% 10%;
			padding: 10px;
		}
		table {
			border-collapse: collapse;
		}
		.bill-table td,.bill-table th {
			border: solid 1px;
			padding: 10px;
		}
		.error {
			color: red;
			font-size: 15px;
			text-align: right;
			display: block;
		}
		.form-table th {
			vertical-align: top;
			padding-top: 18px;
			text-align: left;
		}
		input {
			height: 30px;
			width: 230px;
			border: inset;
			border-radius: 30px;
		}
		input[type="submit"] {
			display: block;
			margin: auto;
			background-color: lawngreen;
			width: 30%;
			font-weight: bold;
		}
		form {
			margin: auto;
			width: 70%;
			padding: 10px;
			border: outset 2px;
			border-radius: 10px;
			background-color: ghostwhite;
		}
	</style>
	<script type="text/javascript">
		function validation() {
			var  ch=0;
			if(document.addfrm.medcode.value=="") {
				document.getElementById('errmedcode').innerHTML="Enter medicine code!";
				err=1;
			} 
			else {
				document.getElementById('errmedcode').innerHTML="&nbsp;";
			}	
			if(document.addfrm.medname.value=="") {
				document.getElementById('errmedname').innerHTML="Enter medicine name!";
				err=1;
			} 
			else {
				document.getElementById('errmedname').innerHTML="&nbsp;";
			}	
			if(document.addfrm.quantity.value=="") {
				document.getElementById('errquantity').innerHTML="Enter quantity!";
				err=1;
			} 
			else {
				document.getElementById('errquantity').innerHTML="&nbsp;";
			}	
			if(document.addfrm.unitprice.value=="") {
				document.getElementById('errunitprice').innerHTML="Enter unit price!";
				err=1;
			} 
			else {
				document.getElementById('errunitprice').innerHTML="&nbsp;";
			}	
			if(err==0) 
				return true;
			else 
				return false;
		}
	</script>
</head>
<body>
	<div class="container">
		<h1 style="text-align: center;margin-bottom: 50px;">Pharmacy Management System</h1>
		<div class="row">
			<div class="col-md-6">
				<form method="post" action="" name="addfrm" onsubmit="return(validation())">
					<table cellpadding="10" cellspacing="8" align="center" class="form-table">
						<tr>
							<th colspan="2">
								<h2 style="text-align: center;">Add Medicine</h2>
							</th>
						</tr>
						<tr>
							<th>Medicine Code</th>
							<td><input type="number" name="medcode"><br><span id="errmedcode" class="error">&nbsp;</span></td>
						</tr>
						<tr>
							<th>Medicine Name</th>
							<td><input type="text" name="medname"><br><span id="errmedname" class="error">&nbsp;</span></td>
						</tr>
						<tr>
							<th>Quantity</th>
							<td><input type="number" name="quantity"><br><span id="errquantity" class="error">&nbsp;</span></td>
						</tr>
						<tr>
							<th>Unit Price</th>
							<td><input type="number" name="unitprice"><br><span id="errunitprice" class="error">&nbsp;</span></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="add" value="Add"></th>
						</tr>
					</table>
				</form>
			</div>
			<div class="col-md-6">
				<h2 style="text-align: center;">Bill</h2>
				<table class="bill-table" align="center">
					<tr>
						<th>#</th>
						<th>Medicine Code</th>
						<th>Medicine Name</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Amount</th>
					</tr>
					<?php
					$n=1;
					while($row=mysqli_fetch_assoc($res)) {
						?>
						<tr>
							<th><?php echo $n++?></th>
							<td><?php echo $row['medcode']?></td>
							<td><?php echo $row['medname']?></td>
							<td><?php echo $row['quantity']?></td>
							<td><?php echo $row['unitprice']?></td>
							<th><?php echo $row['quantity']*$row['unitprice']?></th>
						</tr>
						<?php
					}
					$sql="select sum(quantity*unitprice) as total from medicine";
					$res= mysqli_query($conn, $sql);
					$total=mysqli_fetch_assoc($res);
					?>
					<tr>
						<th colspan="5" style="text-align: left;"><h3 style="margin: 2px;">Total</h3></th>
						<th><h3 style="margin: 2px;"><?php echo $total['total'];?></h3></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>