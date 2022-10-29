$(document).ready(function() {

    $('#search-form').validate({
        // initialize the plugin
        groups: {// consolidate messages into one
            names: "professional location category"
        },
        rules: {
            professional: {
                require_from_group: [1, ".send"]
            },
            location: {
                require_from_group: [1, ".send"]
            },
            category: {
                require_from_group: [1, ".send"]
            }
        }
    });

    //  for your custom message
    jQuery.extend(jQuery.validator.messages, {
        require_from_group: jQuery.validator.format("Please enter either professional/location or category")
    });


//    $("#category").select2({
//        ajax: {
//            url: base_url + 'get-subcategory-json',
//            dataType: 'json',
//            delay: 250,
//            data: function(params) {
//                return {
//                    q: params.term // search term
//                };
//            },
//            processResults: function(data) {
//                // parse the results into the format expected by Select2.
//                // since we are using custom formatting functions we do not need to
//                // alter the remote JSON data
//                return {
//                    results: data
//                };
//            },
//            cache: true
//        },
//        minimumInputLength: 2,
//        placeholder: "Category",
//        allowClear: true
//    });

    $("#location").select2({
        ajax: {
            url: base_url + 'get-city-json',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function(data) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: "Any Location",
        allowClear: true
    });


});