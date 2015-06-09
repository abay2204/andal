<?php
    $array = array();
    $con=mysql_connect("localhost","root","apaajaboleh");
    $db=mysql_select_db("is",$con);
    $query=mysql_query("select * from leads");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['id'];
      $array[] = $row['sm'];
      $array[] = $row['open'];
      $array[] = $row['sales'];
    }
    echo json_encode($array);
?>