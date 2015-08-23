<?php
class AgreableImageService {

  /**
   * Timber creates resized images in the Twig templates. However,
   * these do not get updated when new crops as made.
   */
  public static function delete_timber_resized_images($image_id) {

    // Gather POST data from the crop resize
    var_dump($_POST);
    $crop_name = $_POST['size'];
    var_dump($crop_name);

    if (!$image_metadata = wp_get_attachment_metadata($image_id)) {
      throw new \Exception('Unable to get attachment from ID');
    }

    var_dump($image_metadata);

    $crop_metadata = $image_metadata['sizes'][$crop_name];
    var_dump($crop_metadata);

    $crop_file = $crop_metadata['file'];
    var_dump($crop_file);

    $crop_width = $crop_metadata['width'];
    var_dump($crop_width);

    $crop_height = $crop_metadata['height'];
    var_dump($crop_height);

    // get the filename without file extension
    $crop_fileNoExtension = substr($crop_name, 0, strpos($crop_name, $crop_width . 'x' . $crop_height) -1);
    var_dump($crop_fileNoExtension);

    $crop_file_no_extension_hyphen = $crop_fileNoExtension . '-';
    var_dump($crop_file_no_extension_hyphen);

    $upload_directory = wp_upload_dir();
    var_dump($upload_directory);

    $upload_base = $upload_directory['baseurl'];
    var_dump($upload_base);

    $dh  = opendir($upload_base);
    while (false !== ($upload_filename = readdir($dh))) {
      var_dump($upload_filename);

      $upload_filename_no_extension_hyphen = substr($upload_filename, 0, strlen($crop_file_no_extension_hyphen));
      var_dump($upload_filename_no_extension_hyphen);

      if ($upload_filename_no_extension_hyphen === $crop_file_no_extension_hyphen) {
        var_dump('YES - FILE IS TIMBER RESIZE');
        // Remove Timber resize image
        unlink($upload_base . '/' . $upload_filename);
      } else {
        var_dump('no');
      }
    }
    closedir($dh);
  }
}