<?php
$tmp = sys_get_temp_dir();
echo "Temp dir: " . $tmp . "\n";
echo "Is writable: " . (is_writable($tmp) ? 'YES' : 'NO') . "\n";

$testFile = $tmp . DIRECTORY_SEPARATOR . 'test_write_' . time() . '.tmp';
$written = @file_put_contents($testFile, 'test');
if ($written !== false) {
    echo "File write success to: " . $testFile . "\n";
    @unlink($testFile);
} else {
    echo "FAILED to write to: " . $testFile . "\n";
}

$userTemp = getenv('TEMP') ?: getenv('TMP');
echo "User TEMP env: " . $userTemp . "\n";
