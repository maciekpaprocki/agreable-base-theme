jQuery(function() {
  console.log('Agreable - admin JS')

  function listenForOptionsCheckbox() {
    console.log('Agreable - listening for options checkbox')
    jQuery(document).on('click', '.agreable-options-controller input[type=checkbox]', function() {
      var showOptions = $(this).is(':checked')
      var $parent = $(this).parents('.acf-fields').eq(0)
      if (showOptions) {
        $parent.addClass('agreable-options-enabled')
      } else {
        $parent.removeClass('agreable-options-enabled')
      }
    })
  }

  listenForOptionsCheckbox()
})