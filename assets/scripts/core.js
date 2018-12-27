const s3spaces_loader = jQuery('.s3spaces__loader')
const s3spaces_message = jQuery('.s3spaces__message')
const s3spaces_test_connection = jQuery('.s3spaces__test__connection')

jQuery( function () {

  // check connection button
  s3spaces_test_connection.on( 'click', function () {

    console.log( 'Testing connection to DigitalOcean Spaces Container' )

    const data = {
      s3spaces_key: jQuery('input[name=s3spaces_key]').val(),
      s3spaces_secret: jQuery('input[name=s3spaces_secret]').val(),
      s3spaces_endpoint: jQuery('input[name=s3spaces_endpoint]').val(),
      s3spaces_container: jQuery('input[name=s3spaces_container]').val(),
      action: 's3spaces_test_connection'
    }

    s3spaces_loader.hide()

    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      data: data,
      dataType: 'html'
    }).done( function ( res ) {
      s3spaces_message.show()
      s3spaces_message.html('<br/>' + res)
      s3spaces_loader.hide()
      jQuery('html,body').animate({ scrollTop: 0 }, 1000)
    })

  })

})