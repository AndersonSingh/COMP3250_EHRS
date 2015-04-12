function addRow(tableID,maxEntries) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < maxEntries){                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[1].cells[i].innerHTML;
		}
	}else{	   
	}
}


function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	
		if(rowCount > 2)
		{
			table.deleteRow(rowCount-2);
		}
		else
		{
			alert("Sorry, you cannot remove all the rows in the table.");
		}
	}
