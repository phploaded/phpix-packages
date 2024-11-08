<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Page Title</title>
<style type="text/css">
body{
margin:0;
padding:0;
font:11px verdana;
background-color:#ddd;
}

.content{
background-color:#fff;
border:1px solid gray;
padding:50px;
margin:50px auto;
max-width:950px;
box-shadow:0 0 4px #000;
}

.pass{color:green;}
.fail{color:red;}

h1{
text-align:center;
padding-bottom:10px;
border-bottom:1px solid #ddd;
}
</style>
</head>
<body><div class="content"><h1>PHPix update maker</h1><?php

// Array of filenames to check
$fileArray = ['changelog.html', 'ignore.txt'];

// Flag to track missing file status
$allFilesExist = true;

// Loop through each file in the array
foreach ($fileArray as $file) {
    if (!file_exists($file)) {
        // Set flag to false and display error for missing file
        echo '<p class="fail">Error: File <b>'.$file.'</b> not found.</p>';
        $allFilesExist = false;
        break; // Stop further checks
    }
}


if ($allFilesExist) {

$originalFolder = '../phpix-old';
$modifiedFolder = '../phpix';
$outputFile = 'modified_files.txt';
$ignoreFile = 'ignore.txt';

// Function to recursively get normalized file hashes for a directory
function getNormalizedFileHashes($dir, $ignorePatterns) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($dir . DIRECTORY_SEPARATOR, '', $file->getPathname());

            // Skip files that match any ignore pattern
            if (shouldIgnore($relativePath, $ignorePatterns)) {
                continue;
            }

            // Get normalized content and calculate hash
            $normalizedContent = normalizeFileContent($file->getPathname());
            $files[$relativePath] = hash('sha256', $normalizedContent);
        }
    }

    return $files;
}

// Function to normalize file content
function normalizeFileContent($filePath) {
    $content = file_get_contents($filePath);

    // Normalize line endings to LF
    $content = str_replace(["\r\n", "\r"], "\n", $content);

    // Remove trailing whitespace and extra newlines
    $lines = array_map('rtrim', explode("\n", $content));
    $content = implode("\n", array_filter($lines, 'strlen'));

    return $content;
}

// Function to check if a file should be ignored based on patterns
function shouldIgnore($filePath, $patterns) {
    foreach ($patterns as $pattern) {
        // Replace * with a regex pattern that matches any character(s)
        $regexPattern = '/^' . str_replace(['*', '/'], ['.*', '\/'], $pattern) . '$/';

        if (preg_match($regexPattern, $filePath)) {
            return true;
        }
    }
    return false;
}

// Read ignore patterns from ignore.txt
$ignorePatterns = file($ignoreFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Get normalized file hashes for original and modified folders
$originalFiles = getNormalizedFileHashes($originalFolder, $ignorePatterns);
$modifiedFiles = getNormalizedFileHashes($modifiedFolder, $ignorePatterns);

// Open the output file for writing
$fileHandle = fopen($outputFile, 'w');

if ($fileHandle) {
    // Compare files in the modified folder with those in the original folder
    foreach ($modifiedFiles as $path => $newHash) {
        if (isset($originalFiles[$path])) {
            $oldHash = $originalFiles[$path];
            // Check if file content (hash) differs from the original
            if ($oldHash !== $newHash) {
                fwrite($fileHandle, "$path - edited\n");
            }
        } else {
            // If file is not in the original folder, treat as a new file
            fwrite($fileHandle, "$path - NEW\n");
        }
    }

    fclose($fileHandle);
    echo "<p>Comparison complete. Modified files list saved to <b>$outputFile</b>.</p>";
} else {
    echo '<p class="fail">Unable to write to <b>'.$outputFile.'</b></p>';
}


// Function to recursively delete all files and folders in a directory
function deleteDirectoryContents($dir) {
    if (!is_dir($dir)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
        } else {
            unlink($item->getPathname());
        }
    }
}

// Delete all contents in the 'updates' directory before starting
$updatesDir = __DIR__ . '/updates';
deleteDirectoryContents($updatesDir);

// Ensure the 'updates' directory itself exists
if (!is_dir($updatesDir)) {
    mkdir($updatesDir, 0777, true);
    echo "Directory created: $updatesDir<br>";
}

// Source and destination base paths
$sourcePath = realpath('../phpix') . '/'; // Absolute path to the source folder
$destinationPath = $updatesDir . '/'; // Destination path is 'updates' folder

// Read paths from modified_files.txt
$pathsFile = $outputFile;
if (!file_exists($pathsFile)) {
    die('<p class="fail">Error: <b>'.$outputFile.'</b> not found.</p>');
}
$paths = file($pathsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($paths === false) {
    die('<p class="pass">Error reading <b>'.$outputFile.'</b>.');
}

// Read filenames to ignore from ignore.txt
$ignoreFile = 'ignore.txt';
$ignoreList = [];
if (file_exists($ignoreFile)) {
    $ignoreList = file($ignoreFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($ignoreList === false) {
        die("Error reading ignore.txt.<br>");
    }
}

// Function to check if a filename matches any wildcard or exact pattern in the ignore list
function shouldIgnoreFile($filename, $ignoreList) {
    foreach ($ignoreList as $pattern) {
        // Check for exact match
        if ($pattern === $filename) {
            return true;
        }
        // Check for wildcard match (e.g., xthumb-*)
        if (strpos($pattern, '*') !== false) {
            $regex = '/^' . str_replace('*', '.*', preg_quote($pattern, '/')) . '$/';
            if (preg_match($regex, $filename)) {
                return true;
            }
        }
    }
    return false;
}

// Loop through each path to create folders and copy files
foreach ($paths as $path) {
	$npath = explode(" - ", $path);
    // Remove the prefix 'D:/localhost/htdocs/' and normalize directory separators
    $cleanPath = str_replace('\\', '/', $npath[0]);
    $cleanPath = str_replace('D:/localhost/htdocs/phpix/', '', $cleanPath); // Ensure only phpix prefix is removed

    // Get the base filename for checking against the ignore list
    $baseFileName = basename($cleanPath);

    // Skip copying if the file is in the ignore list or matches a wildcard pattern
    if (shouldIgnoreFile($baseFileName, $ignoreList)) {
        echo "<span style=\"color:red;\">File ignored: $baseFileName</span><br>";
        continue;
    }

    // Build the full source and destination paths
    $fullSourcePath = $sourcePath . $cleanPath;
    $fullDestPath = $destinationPath . $cleanPath;

    // Check if it's a directory (without an extension)
    if (pathinfo($cleanPath, PATHINFO_EXTENSION) == '') {
        // Create the directory if it doesn't exist
        if (!is_dir($fullDestPath)) {
            mkdir($fullDestPath, 0777, true);
            echo "Directory created: $fullDestPath\n";
        }
    } else {
        // Check if the file exists before copying
        if (file_exists($fullSourcePath)) {
            // Ensure the parent directory exists before copying the file
            $dir = dirname($fullDestPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            // Copy the file
            if (copy($fullSourcePath, $fullDestPath)) {
                echo '<p class="pass">File copied: <b>'.$fullSourcePath.'</b> to '.$fullDestPath.'</p>';
            } else {
                echo '<p class="fail">Failed to copy file: <b>'.$fullSourcePath.'</b></p>';
            }
        } else {
            echo '<p class="fail">Source file does not exist: <b>'.$fullSourcePath.'</b></p>';
        }
    }
} 


$jsonURL = 'https://raw.githubusercontent.com/phploaded/phpix-packages/main/phpix-updates/updates.json';
$jdata = json_decode(file_get_contents($jsonURL), true);
$old = $jdata['latest'];
if(is_numeric($old)){
$new = $old + 0.01;
} else {
die('<p class="fail">Failed during version check!</p>');
}

$time = time();
$date = date("l, d-m-Y, h:i:s a");
$sdate = date("l, d-m-Y, h:i:s a", 1603041199);

// Define the PHP code as a string
$php_code = <<<PHP
<?php 

\$software_version = '$new';
\$software_date = '1603041199'; /* $sdate */
\$software_updated = '$time'; /* $date */
\$software_jsonURL = 'https://raw.githubusercontent.com/phploaded/phpix-packages/main/phpix-updates/updates.json';
\$software_zipURL = 'https://raw.githubusercontent.com/phploaded/phpix-packages/main/phpix-updates/';

?>
PHP;

// Define the filename for the new PHP file
$filename = 'updates/phpix-info.php';

// Create the file and write the PHP code to it
if (file_put_contents($filename, $php_code) !== false) {
    echo '<p class="pass">File <b>'.$filename.'</b> has been created successfully.</p>';
} else {
    echo '<p class="fail">Failed to create <b>'.$filename.'</b> .</p>';
}


// create changelog folder
$newFolderPath = 'updates' . DIRECTORY_SEPARATOR . 'changelog';
if (!is_dir($newFolderPath)) {
    mkdir($newFolderPath, 0777, true);
}

// copy changelog file into changelog folder
if(copy('changelog.html', 'updates/changelog/'.$new.'.html')){
echo '<p class="pass">changelog.html copied as <b>'.$new.'.html</b> successfully.</p>';
} else {
echo '<p class="fail"><b>changelog.html</b> FAILED to copy.</p>';
}

// copy patch.php file

$patchFile = 'updates/patch.php';

if(file_exists('patch.php')){
	
	if(copy('patch.php', $patchFile)){
	echo '<p class="pass">SQL <b>patch file</b> copied successfully.</p>';
	} else {
	echo '<p class="fail">SQL <b>patch file</b> FAILED to copy.</p>';
	}
$updateType = 'stable';
} else {
	echo'<p>No patch file was found</p>';
    $file = fopen($patchFile, 'w');
    if ($file) {
        fwrite($file, "<?php\n\n?>"); // Add opening and closing PHP tags
        fclose($file);
        echo '<p class="pass">Blank file was created.</p>';
    } else {
        echo '<p class="fail">Unable to create blank patch file.</p>';
    }
$updateType = 'normal'; // without patch file
}

// zipping to the inside path of updates folder
// Define the folder to be zipped
$folderPath = 'updates';
$zipFileName = $new.'.zip';

// deleting existing file
if(file_exists($zipFileName)){
unlink($zipFileName);
echo '<p>Existing file <b>'.$zipFileName.'</b> was deleted.</p>';
}

// Initialize ZipArchive class
$zip = new ZipArchive();
if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    // Function to add files to zip
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        // Skip directories (they would be added automatically)
        if (!$file->isDir()) {
            // Get the relative path from the updates folder
            $filePath = $file->getPathname();
            $relativePath = substr($filePath, strlen($folderPath) + 1);

            // Add current file to zip with the relative path
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Close and save zip file
    $zip->close();
    echo '<p class="pass">Folder <b>updates</b> has been zipped successfully into <b>'.$zipFileName.'</b></p>';
} else {
    echo '<p class="fail">Failed to create zip file.</p>';
}

// deleting modified_files.txt
if(file_exists($outputFile)){
unlink($outputFile);
echo '<p>File list <b>'.$outputFile.'</b> was deleted.</p>';
}


// updating json file
if($updateType=='stable'){
$jdata['stable'][] = "".$new."";
}

	$jdata['latest'] = "".$new."";
	$jdata['released'] = "".time()."";
	$htmlContent = file_get_contents('changelog.html');
	$jdata['info'] = strip_tags($htmlContent);

    $ujFile = fopen('updates.json', 'w');
    if ($ujFile) {
        fwrite($ujFile, json_encode($jdata, true)); // Add opening and closing PHP tags
        fclose($ujFile);
        echo '<p class="pass"><b>updates.json</b> file was created with <b>'.$updateType.'</b> tag.</p>';
    } else {
        echo '<p class="fail">Unable to create <b>updates.json</b> file.</p>';
    }


} // end if all files found
?>
</div>
</body>
</html>