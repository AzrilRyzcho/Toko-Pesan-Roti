<?php
$im = imagecreatetruecolor(1200, 1200);
$bg = imagecolorallocate($im, 240, 230, 210);
$text = imagecolorallocate($im, 74, 51, 25);
imagefill($im, 0, 0, $bg);
for ($i = 0; $i < 50; $i++) {
    imagestring($im, 5, 50, 50 + ($i * 20), "BUKTI TRANSFER SAMPLE TEST IMAGE 500KB - ROW $i", $text);
}
imagejpeg($im, __DIR__ . '/proof_500kb.jpg', 95);
imagedestroy($im);
echo "Created: " . realpath(__DIR__ . '/proof_500kb.jpg') . " (" . round(filesize(__DIR__ . '/proof_500kb.jpg') / 1024) . " KB)\n";
