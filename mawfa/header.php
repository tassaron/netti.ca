<?php

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
echo '<html><head>';
echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
echo '<meta name="description" content="An interdisciplinary arts club at the University of Windsor for musicians, artists, filmmakers, actors, and writers.">';
echo '<meta name="keywords" content="mawfa, windsor, uwindsor, university, ontario, canada, music, art, film, acting, bfa, writing, english, news">';
echo '<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">';
echo '<link rel="stylesheet" href="style.css" type="text/css">';

require 'settings.php';

if (empty($title))
{
	echo '<title>MAWFA</title></head>';
} elseif (empty($title2)) {
	echo '<title>MAWFA: ' . $title . '</title></head>';
} else {
	echo '<title>MAWFA: ' . $title . ': ' . $title2 . '</title></head>';
}

echo '<body>';

echo '<div id="bge1">';
echo '<div id="bge2">';
echo '<div id="bge3">';
echo '<div id="wrapper">';

echo '<div id="header">';
echo 'M A W F A<br>';
echo '<div class="subtitle"><strong>M</strong>usic, <strong>A</strong>rt, <strong>W</strong>riting, <strong>F</strong>ilm, and <strong>A</strong>cting</div>';
echo '</div>';

echo '<div id="user">';
echo 'placeholder';
echo '</div>';

echo '<div id="nav">';
echo '<p><br></p>';
echo '<table class="tabs"><tr>';

if ($title=="News") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">News</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa">News</a></td>';
}
if ($title=="Projects") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Projects</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/projects.php">Projects</a></td>';
}
if ($title=="About") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">About</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/about.php">About</a></td>';
}
if ($title=="Music") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Music</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/music">Music</a></td>';
}
if ($title=="Art") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Art</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/art">Art</a></td>';
}
if ($title=="Writing") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Writing</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/writing">Writing</a></td>';
}
if ($title=="Film") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Film</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/film">Film</a></td>';
}
if ($title=="Acting") {
	echo '<td style="border: 2px solid #FFFFFF; padding: 10px;">Acting</td>';
} else {
	echo '<td style="border: 2px solid #2B7233; padding: 10px;"><a href="/mawfa/acting">Acting</a></td>';
}

echo '</tr></table>';
echo '</div>';

echo '<div id="content">';

?>