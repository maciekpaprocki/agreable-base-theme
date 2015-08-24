<?php
class AgreableImageService {

  /**
   * Timber creates resized images in the Twig templates. However,
   * these do not get updated when new crops as made.
   */
  public static function delete_timber_resized_images() {

    // Gather POST data from the crop resize
    $post_id = $_POST['post'];
    $crop_name = $_POST['size'];
    if (!$image_metadata = wp_get_attachment_metadata($post_id)) {
      throw new \Exception('Unable to get attachment from ID');
    }

    $crop_metadata = $image_metadata['sizes'][$crop_name];

    $crop_file = $crop_metadata['file'];

    $crop_width = $crop_metadata['width'];

    $crop_height = $crop_metadata['height'];

    // get the filename without file extension
    $crop_size_string = $crop_width . 'x' . $crop_height;

    $crop_fileNoExtension = substr($crop_file, 0, strpos($crop_file, $crop_size_string) + strlen($crop_size_string));

    $crop_file_no_extension_hyphen = $crop_fileNoExtension . '-';

    $upload_directory = wp_upload_dir();

    $upload_path = $upload_directory['path'];

    $dh  = opendir($upload_path);
    while (false !== ($upload_filename = readdir($dh))) {

      $upload_filename_no_extension_hyphen = substr($upload_filename, 0, strlen($crop_file_no_extension_hyphen));

      if ($upload_filename_no_extension_hyphen === $crop_file_no_extension_hyphen) {
        // Remove Timber resize image
        unlink($upload_path . '/' . $upload_filename);
      }
    }
    closedir($dh);
  }
}