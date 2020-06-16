<?php
  $page_title = 'Series Links';
  include_once './head.php';
  if (isset($_GET["uuid"])) {
    $uuid = $_GET["uuid"];
    $url = "$urlp/api/idnode/delete?uuid=$uuid";
    file_get_contents($url);
  }
  echo "
    <div id='layout'>
     <div id='banner'>
      <table>
        <tr>
	  <td class='col_title'><div id='mobmenu'>&#9776;</div> <h1>Series Links</h1></td>
	</tr>
      </table>
     </div>
     <div id='wrapper'>
      <div id='content'>
       <table class='list'>
	<tr class='heading'>
	  <td class='col_value'><h2>Timers</h2></td>
	  <td class='col_value'><h2>Recs</h2></td>
	  <td class='col_channel'><h2>Channel</h2></td>
	  <td class='col_name'><h2>Name</h2></td>
	  <td class='wideonly col_channel'><h2>Link</h2></td>
	  <td class='col_delete'></td>
	</tr>
  ";
        $links = get_links();
	$channels = get_channels();
	$cname = array();
	foreach ($channels as $c) {
	    $cname[$c["uuid"]] = $c["name"];
	}
	$recordings = get_recordings(-1);
	$rcnt = array();
	$tcnt = array();
	foreach($recordings as $r) {
	    $autorec = $r['autorec'];
	    if ($r["sched_status"] == "scheduled") {
		if (isset($tcnt[$autorec])) $tcnt[$autorec]++;
		else $tcnt[$autorec] = 1;
	    }
	    else {
		if (isset($rcnt[$autorec])) $rcnt[$autorec]++;
		else $rcnt[$autorec] = 1;
	    }
	}
	foreach($links as $l) {
	    $channelname = $cname[$l["channel"]];
	    if (isset($rcnt[$l['uuid']])) $recs = $rcnt[$l['uuid']];
	    else $recs = 0;
	    if (isset($tcnt[$l['uuid']])) $timers = $tcnt[$l['uuid']];
	    else $timers = 0;
	    $title = stripslashes($l['title']);
	    $crid = substr(strstr($l['serieslink'], '//'), 2);
	    echo "
      <tr class='row_alt'>
	<td class='col_value'>$timers</td>
	<td class='col_value'>$recs</td>
	<td class='col_channel'>$channelname</td>
	<td class='col_name'>$title</td>
	<td class='wideonly col_channel'>$crid</td>
	<td class='col_delete'><a href='links.php?uuid={$l['uuid']}'><img src='images\delete.png'></a></td>
      </tr>\n";
	}
 ?>
     </table>
    </div>
   </div>
  </div>
 </div>
</body>
</html>
