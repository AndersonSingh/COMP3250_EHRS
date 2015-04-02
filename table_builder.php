<?php


function table_builder_vertical($table_name, $total_columns, $total_rows , $column_headings, $multi_data)
{
	$table = "";
	
	/* add the title to the top of the table. */
	$table .= "<div class=\"contenttitle radiusbottom0\">";
	$table .= "<h2 class=\"widgets\"><span>" . $table_name . "</span></h2>";
	$table .= "</div>";
	
	/* start building the table structure. */
	
	$table .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"stdtable\">";
	$table .= "<colgroup>";
	
	
	for($current_column = 0; $current_column < $total_columns; $current_column++)
	{
		if($current_column % 2 == 0)
		{
			$table .= "<col class=\"con0\" />";
		}
		else
		{
			$table .= "<col class=\"con1\" />";
		}
	}
	$table .= "</colgroup>";
	
	/* start adding the table header. */
	
	$table .= "<thead>";
	$table .= "<tr>";
	
	for($current_column = 0; $current_column < $total_columns; $current_column++)
	{
		if($current_column % 2 == 0)
		{
			$table .= "<th class=\"head0\">" . $column_headings[$current_column] . "</th>";
		}
		else
		{
			$table .= "<th class=\"head1\">" . $column_headings[$current_column] . "</th>";
		}
	}
	
	$table .= "</tr>";
	$table .= "</thead>";
	
	
	/*  start adding table footer. */
	$table .= "<tfoot>";
	$table .= "<tr>";
	
	for($current_column = 0; $current_column < $total_columns; $current_column++)
	{
		if($current_column % 2 == 0)
		{
			$table .= "<th class=\"head0\">" . $column_headings[$current_column] . "</th>";
		}
		else
		{
			$table .= "<th class=\"head1\">" . $column_headings[$current_column] . "</th>";
		}
	}
	
	$table .= "</tr>";
	$table .= "</tfoot>";
	
	/* start adding actual table data */

	$table .= "<tbody>";
	
	for($current_row = 0; $current_row < $total_rows; $current_row++)
	{
		$table .= "<tr>";
	
		for($current_column = 0; $current_column < $total_columns; $current_column++)
		{
			$table .= "<td>";
			
			$table .= $multi_data[$current_row][$current_column];
			
			$table .= "</td>";
		}
		
		$table .=" </tr>";
	}
	
	$table .= "</tbody>";
	$table .= "</table>";
	return $table;
}
?>