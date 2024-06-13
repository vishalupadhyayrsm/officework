<?php
$directory = '/path/to/your/folder';

$keywords = ['keyword1', 'keyword2', 'keyword3'];

function searchKeywordsInFile($filePath, $keywords)
{
    $fileContents = file_get_contents($filePath);
    foreach ($keywords as $keyword) {
        if (strpos($fileContents, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
        while (($file = readdir($dh)) !== false) {
            // Skip '.' and '..'
            if ($file != '.' && $file != '..') {
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                // Check if it's a file
                if (is_file($filePath)) {
                    // Search for keywords in the file
                    if (searchKeywordsInFile($filePath, $keywords)) {
                        echo "Keyword found in: " . $filePath . "\n";
                    }
                }
            }
        }
        closedir($dh);
    } else {
        echo "Unable to open directory: " . $directory;
    }
} else {
    echo "The provided path is not a directory: " . $directory;
}
