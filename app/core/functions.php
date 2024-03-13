<?php 

defined('ROOTPATH') OR exit('Access Denied!');

// Function to check if required PHP extensions are loaded
check_extensions();

function check_extensions()
{
    // List of required PHP extensions
    $required_extensions = [
        'gd',
        'mysqli',
        'pdo_mysql',
        'pdo_sqlite',
        'curl',
        'fileinfo',
        'intl',
        'exif',
        'mbstring',
    ];

    // Array to store extensions that are not loaded
    $not_loaded = [];

    // Iterate through each required extension
    foreach ($required_extensions as $ext) {
        
        // Check if the extension is not loaded
        if (!extension_loaded($ext)) {
            $not_loaded[] = $ext;
        }
    }

    // If there are extensions not loaded, display a message and terminate the script
    if (!empty($not_loaded)) {
        // Show a message indicating which extensions need to be loaded
        show("Please load the following extensions in your php.ini file: <br>" . implode("<br>", $not_loaded));

        // Terminate the script
        die;
    }
}


function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    header("Location: " . ROOT."/".$path);
    die;
}

/** load image. if not exist, load placeholder **/
function get_image(mixed $file = '',string $type = 'post'):string
{

    $file = $file ?? '';
    if(file_exists($file))
    {
        return ROOT . "/". $file;
    }

    if($type == 'user'){
        return ROOT."/assets/images/user.webp";
    }else{
        return ROOT."/assets/images/no_image.jpg";
    }

}


/**
 * Returns pagination variables.
 * @return array An array containing pagination variables.
 */
function get_pagination_vars(): array
{
    // Initialize an array to store pagination variables
    $vars = [];

    // Get the 'page' parameter from the query string, default to 1 if not set
    $vars['page'] = $_GET['page'] ?? 1;

    // Ensure the 'page' parameter is an integer
    $vars['page'] = (int)$vars['page'];

    // Calculate the previous page; if 'page' is 1 or less, set to 1, otherwise, decrement by 1
    $vars['prev_page'] = $vars['page'] <= 1 ? 1 : $vars['page'] - 1;

    // Calculate the next page by incrementing the current page
    $vars['next_page'] = $vars['page'] + 1;

    // Return the array containing pagination variables
    return $vars;
}


/**
 * Saves or displays a saved message to the user.
 * @param string|null $msg   The message to be saved or displayed (optional).
 * @param bool         $clear Whether to clear the saved message after displaying (default: false).
 * @return string|bool If a message is provided, it is saved and returns true; if no message is provided but a saved message exists, returns the saved message (and clears it if $clear is true);  otherwise, returns false.
 *              
 */
function message(string $msg = null, bool $clear = false)
{
    // Initialize a session object
    $ses = new Core\Session();

    // If a message is provided, save it in the session
    if (!empty($msg)) {
        $ses->set('message', $msg);
    } else {
        // If no message is provided, check if a saved message exists in the session
        if (!empty($ses->get('message'))) {
            // Retrieve the saved message
            $msg = $ses->get('message');

            // If $clear is true, remove the saved message from the session
            if ($clear) {
                $ses->pop('message');
            }

            // Return the retrieved message
            return $msg;
        }
    }

    // If no message is provided and no saved message exists, return false
    return false;
}



/**
 * Return URL variables.
 * @param string|int $key The key representing the URL variable to retrieve.
 * @return mixed The value of the specified URL variable or null if not found.
 */
function URL($key): mixed
{
    // Get the 'url' parameter from the query string or default to 'home'
    $URL = $_GET['url'] ?? 'home';

    // Split the URL into an array of path segments
    $URL = explode("/", trim($URL, "/"));

    // Switch based on the provided key to return the corresponding URL variable
    switch ($key) {
        case 'page':
        case 0:
            return $URL[0] ?? null;
            break;
        case 'section':
        case 'slug':
        case 1:
            return $URL[1] ?? null;
            break;
        case 'action':
        case 2:
            return $URL[2] ?? null;
            break;
        case 'id':
        case 3:
            return $URL[3] ?? null;
            break;
        default:
            return null;
            break;
    }
}


/**
 * Displays input values after a page refresh.
 * @param string $key      The name attribute of the input field.
 * @param string $value    The value to compare against for checking.
 * @param string $default  The default value to compare against for a GET request (optional).
 * @return string Returns 'checked' if the condition is met, otherwise an empty string.
 */
function old_checked(string $key, string $value, string $default = ""): string
{
    // Check if the input field with the given key exists in the POST data
    if (isset($_POST[$key])) {
        // If the posted value matches the specified value, return 'checked'
        if ($_POST[$key] == $value) {
            return ' checked ';
        }
    } else {
        // If the request method is GET and the default value matches the specified value, return 'checked'
        if ($_SERVER['REQUEST_METHOD'] == "GET" && $default == $value) {
            return ' checked ';
        }
    }

    // If none of the conditions are met, return an empty string
    return '';
}



/**
 * Retrieves the value of a form input field from either $_POST or $_GET arrays.
 * @param string $key      The name attribute of the input field.
 * @param mixed  $default  The default value to return if the input field is not set (optional).
 * @param string $mode     The mode to determine whether to check $_POST or $_GET (default: 'post').
 * @return mixed The value of the input field if set; otherwise, the default value.
 */
function old_value(string $key, mixed $default = "", string $mode = 'post'): mixed
{
    // Select the appropriate array based on the mode
    $inputArray = ($mode == 'post') ? $_POST : $_GET;

    // Check if the input field with the given key exists in the selected array
    if (isset($inputArray[$key])) {
        // Return the value of the input field
        return $inputArray[$key];
    }

    // If the input field is not set, return the default value
    return $default;
}


/**
 * Generates the "selected" attribute for a dropdown option based on form data.
 * @param string $key      The name attribute of the dropdown field.
 * @param mixed  $value    The value to compare against for marking as selected.
 * @param mixed  $default  The default value to compare against (optional).
 * @param string $mode     The mode to determine whether to check $_POST or $_GET (default: 'post').
 * @return mixed The string "selected" if the condition is met; otherwise, an empty string.
 */
function old_select(string $key, mixed $value, mixed $default = "", string $mode = 'post'): mixed
{
    // Select the appropriate array based on the mode
    $inputArray = ($mode == 'post') ? $_POST : $_GET;

    // Check if the dropdown field with the given key exists in the selected array
    if (isset($inputArray[$key])) {
        // If the submitted value matches the specified value, return 'selected'
        if ($inputArray[$key] == $value) {
            return " selected ";
        }
    } else {
        // If the default value matches the specified value, return 'selected'
        if ($default == $value) {
            return " selected ";
        }
    }

    // If none of the conditions are met, return an empty string
    return "";
}



/**
 * Returns a user-readable date format.
 * @param mixed $date The input date to be formatted.
 * @return string The formatted date in the "jS M, Y" (e.g., "1st Jan, 2022") format.
 */
function get_date($date)
{
    // Use the date function to format the input date
    // "jS" - day of the month with ordinal suffix
    // "M" - abbreviated month name
    // "Y" - four-digit year
    return date("jS M, Y", strtotime($date));
}



/** converts image paths from relative to absolute **/
function add_root_to_images($contents)
{
    // Use a regular expression to find all image tags in the HTML content
    preg_match_all('/<img[^>]+>/', $contents, $matches);

    // Check if $matches is an array and has more than 0 elements
    if (is_array($matches) && count($matches) > 0) {
        
        // Iterate through each matched image tag
        foreach ($matches[0] as $match) {

            // Use another regular expression to extract the 'src' attribute from the image tag
            preg_match('/src="[^"]+/', $match, $matches2);

            // Check if the 'src' attribute does not contain 'http' (i.e., it is a relative path)
            if (!strstr($matches2[0], 'http')) {
                
                // Replace the relative 'src' attribute with an absolute path using the ROOT constant
                $contents = str_replace($matches2[0], 'src="'.ROOT.'/'.str_replace('src="',"",$matches2[0]), $contents);
            }
        }
    }

    // Return the modified HTML content
    return $contents;
}


/**
 * Converts images from text editor content to actual files
 * @param string $content The text editor content containing images
 * @param string $folder  The folder where the images will be saved
 * @return string The updated content with references to the new image files
 */
function remove_images_from_content($content, $folder = "uploads/")
{
    // Create the folder if it doesn't exist
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        file_put_contents($folder . "index.php", "Access Denied!");
    }

    // Remove images from content
    preg_match_all('/<img[^>]+>/', $content, $matches);
    $new_content = $content;

    if (is_array($matches) && count($matches) > 0) {
        // Assuming that there is a class named Image
        $image_class = new \Model\Image();

        foreach ($matches[0] as $match) {
            if (strstr($match, "http")) {
                // Ignore images with links already
                continue;
            }

            // Get the src attribute
            preg_match('/src="[^"]+/', $match, $matches2);

            // Get the data-filename attribute
            preg_match('/data-filename="[^\"]+/', $match, $matches3);

            if (strstr($matches2[0], 'data:')) {
                $parts = explode(",", $matches2[0]);
                $basename = $matches3[0] ?? 'basename.jpg';
                $basename = str_replace('data-filename="', "", $basename);

                // Generate a new filename
                $filename = $folder . "img_" . sha1(rand(0, 9999999999)) . $basename;

                // Replace the data URI with the new file path in the content
                $new_content = str_replace($parts[0] . "," . $parts[1], 'src="' . $filename, $new_content);

                // Save the base64-encoded image data to a file
                file_put_contents($filename, base64_decode($parts[1]));

                // Resize the image (assuming the Image class has a resize method)
                $image_class->resize($filename, 1000);
            }
        }
    }

    return $new_content;
}


/**
 * Deletes images from text editor content.
 * @param string $content      The original content containing HTML.
 * @param string $content_new  The new content for comparison (optional).
 * @return void
 */
function delete_images_from_content(string $content, string $content_new = ''): void
{
    // Delete images from content
    if (empty($content_new)) {
        // Extract all image tags from the original content
        preg_match_all('/<img[^>]+>/', $content, $matches);

        // Check if there are matches and proceed if any
        if (is_array($matches) && count($matches) > 0) {
            foreach ($matches[0] as $match) {
                // Extract the source (src) attribute value from the image tag
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                // Check if the file exists and unlink (delete) it
                if (file_exists($matches2[0])) {
                    unlink($matches2[0]);
                }
            }
        }
    } else {
        // Compare old content to new content and delete from old what isn't in the new
        preg_match_all('/<img[^>]+>/', $content, $matches);
        preg_match_all('/<img[^>]+>/', $content_new, $matches_new);

        $old_images = [];
        $new_images = [];

        // Collect old images
        if (is_array($matches) && count($matches) > 0) {
            foreach ($matches[0] as $match) {
                // Extract the source (src) attribute value from the image tag
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                // Check if the file exists and add it to the old images array
                if (file_exists($matches2[0])) {
                    $old_images[] = $matches2[0];
                }
            }
        }

        // Collect new images
        if (is_array($matches_new) && count($matches_new) > 0) {
            foreach ($matches_new[0] as $match) {
                // Extract the source (src) attribute value from the image tag
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                // Check if the file exists and add it to the new images array
                if (file_exists($matches2[0])) {
                    $new_images[] = $matches2[0];
                }
            }
        }

        // Compare and delete all files that don't appear in the new array
        foreach ($old_images as $img) {
            if (!in_array($img, $new_images)) {
                // Check if the file exists and unlink (delete) it
                if (file_exists($img)) {
                    unlink($img);
                }
            }
        }
    }
}


