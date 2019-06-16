jQuery( function ( $ ) {
  init_lunapay_meta();
  $(".lunapay_customize_lunapay_donations_field input:radio").on("change", function() {
    init_lunapay_meta();
  });

  function init_lunapay_meta(){
    if ("enabled" === $(".lunapay_customize_lunapay_donations_field input:radio:checked").val()){
      $(".lunapay_api_key_field").show();
      $(".lunapay_collection_id_field").show();
      $(".lunapay_x_signature_key_field").show();
      $(".lunapay_description_field").show();
      $(".lunapay_reference_1_label_field").show();
      $(".lunapay_reference_1_field").show();
      $(".lunapay_reference_2_label_field").show();
      $(".lunapay_reference_2_field").show();
      $(".lunapay_collect_billing_field").show();
    } else {
      $(".lunapay_api_key_field").hide();
      $(".lunapay_collection_id_field").hide();
      $(".lunapay_x_signature_key_field").hide();
      $(".lunapay_description_field").hide();
      $(".lunapay_reference_1_label_field").hide();
      $(".lunapay_reference_1_field").hide();
      $(".lunapay_reference_2_label_field").hide();
      $(".lunapay_reference_2_field").hide();
      $(".lunapay_collect_billing_field").hide();
    }
  }
});