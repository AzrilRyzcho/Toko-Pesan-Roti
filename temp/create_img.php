<?php
$im = imagecreatetruecolor(300, 300);
$bg = imagecolorallocate($im, 240, 230, 210);
$text = imagecolorallocate($im, 74, 51, 25);
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 50, 140, "BUKTI TRANSFER TEST", $text);
imagejpeg($im, __DIR__ . '/sample_proof.jpg');
imagedestroy($im);
echo "Created: " . realpath(__DIR__ . '/sample_proof.jpg') . " (" . filesize(__DIR__ . '/sample_proof.jpg') . " bytes)\n";
