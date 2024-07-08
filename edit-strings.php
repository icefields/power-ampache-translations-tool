// original strings in english
$url = 'https://raw.githubusercontent.com/icefields/Power-Ampache-2/main/app/src/main/res/values/strings.xml';

// Function to load XML from URL and return SimpleXMLElement
function loadXMLFromURL($url) {
    $xmlString = file_get_contents($url);
    if ($xmlString !== false) {
        $xml = simplexml_load_string($xmlString);
        return $xml;
    } else {
        die('Error: Cannot load XML');
    }
}

// Function to save XML to a file
function saveXMLToFile($xml, $file) {
    if ($xml->asXML($file)) {
        return true;
    } else {
        return false;
    }
}

// Load XML from URL
$xml = loadXMLFromURL($url);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach($xml->string as $k => $v) {
        //echo $v['name']." - ".$v;     
    }

    foreach ($_POST as $key => $value) {
    if (strpos($key, 'string_') === 0) {
            $id = substr($key, 7); // Remove 'string_' prefix
        $newElem = ['string']
        echo "--".$xml->string['string'];
            if (isset($xml->$id)) {
            $xml->string[$id] = $value;
            }
        }
    }
    
    // Generate XML content
    $xmlContent = $xml->asXML();
    
        
    // Set headers for file download
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="strings.xml"');
    header('Content-Length: ' . strlen($xmlContent));
    
    // Output the XML content for download
    echo $xmlContent;
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Power Ampache 2 Translation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        textarea {
            width: 100%;
            height: 80px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Edit Strings</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php foreach ($xml->string as $index => $string): ?>
            <label for="string_<?php echo $string['name']; ?>"><?php echo htmlspecialchars($string['name']); ?>:</label><br>
            <textarea id="string_<?php echo $string['name']; ?>" name="string_<?php echo $string['name']; ?>"><?php echo htmlspecialchars($string); ?></textarea><br>
        <?php endforeach; ?>
        
        <input type="submit" value="Download">
    </form>
</body>
</html>

