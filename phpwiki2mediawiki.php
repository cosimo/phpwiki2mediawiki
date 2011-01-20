<?php

  //
  // Original version from:
  //
  // http://www.webforce.co.nz/phpwiki2mediawiki.php.txt
  //

  $phpwiki_content = file_get_contents('php://stdin');

  // Add a newline to make pattern matching easier
  $t = "\n" . $phpwiki_content . "\n";

  // Convert !!!foo to === foo ==
  $t = preg_replace("/\n!!!\s*(.*?)(\r?\n)/","\n== $1 ==$2",$t);
  $t = preg_replace("/\n!!\s*(.*?)(\r?\n)/","\n=== $1 ===$2",$t);
  $t = preg_replace("/\n!\s*(.*?)(\r?\n)/","\n==== $1 ====$2",$t);

  // Convert %%% to newline
  $t = preg_replace("/%%%/","<br>",$t);

  // Convert strong (__)
  $t = preg_replace("/__([^\n]+?)__/","'''$1'''",$t);

  // Convert em
  $t = preg_replace("/_([^\n]+?)_/","''$1''",$t);

  // Convert strong
  $t = preg_replace("/\*([^\n]+?)\*/","'''$1'''",$t);

  // Convert <verbatim> to <nowiki>
  $t = preg_replace("/<verbatim>(.*?)<\/verbatim>/s","<pre>$1</pre>",$t);

  // Convert definitions
  $t = preg_replace("/\n(.*?):\s*?\n\s{2,}([^\s]*?)/","\n; $1 : $2",$t);

  // Convert single indents
  $t = preg_replace("/\n {2,}([^\s]*?)/","\n: $1",$t);

  // Convert WikiWord to [[WikiWord]]
  $t = preg_replace("/(?<![[:alnum:]])((?:[[:upper:]][[:lower:]]+){2,})(?![[:alnum:]])/","[$1]",$t);

  // Convert [[WikiWord]] to [[Wiki Word]]
  $t = preg_replace("/(\[.*?[[:lower:]])([[:upper:]].*?\])/","$1 $2",$t);

  // Convert [foo] to [[foo]]
  $t = preg_replace("/\[([^|]+?)\]/","[[$1]]",$t);

  // Convert http://foo to [http://foo]
  //$t = preg_replace("/(\s*)([a-z]+:\/\/[^\s]+)/","$1[$2]",$t);

  // Convert [[http://foo]] to [http://foo]
  $t = preg_replace("/\[\[([a-z]+:\/\/.+?)\]\]/","$1",$t);  

  // Convert links [Foo|http://foo] to [http://foo foo]
  $t = preg_replace("/\[([^|\n]+?) *\| *(.+?) *\]/","[$2 $1]",$t);

  // Convert links [[http://foo foo]] to [http://foo foo]
  $t = preg_replace("/\[\[([a-z]+:\/\/.+?\s+.+?)\]\]/","[$1]",$t);

  // Convert 
  //$t = preg_replace("//","",$t);

  // Strip the first newline
  $t = substr($t,1);

  echo $t;
?>

