document.querySelector('input.submit_pc').addEventListener('click', function () {
    setbands();
    event.preventDefault();
});

/**
 * Sets the delivery band code given the post code.
 *
 */
function setbands() {
    var postcode = document.getElementById('postcode').value;
    postcode = postcode.toUpperCase();
    postcode = postcode.trim();
    if ( postcode) {
        var band = get_delivery_band_code(postcode);
    } else {
        var band = 'delivery_band_not_set';
    }
    console.log( band);
    setClasses( band, 'delivery_wrapper' );
    setClasses( band, 'removal_wrapper' );
}

function get_delivery_band_code( postcode ) {
    var bandcode = 'delivery_excluded';
    if (vgccodes.excluded.includes(postcode))
        return bandcode;
    //let index = 0;
    bandcode = 'delivery_band_0';
    for ( let index = 0; index < vgccodes.postcodes.length; index++) {
        let bandcodes = vgccodes.postcodes[ index];
        console.log( bandcodes);
        if (bandcodes.includes(postcode)) {
            bandcode = 'delivery_band_' + (index + 1);
        }
    }

    return bandcode;
}

function setClasses( band, $wrapper_id ) {
    var delivery_wrapper = document.getElementById( $wrapper_id);
    if ( delivery_wrapper ) {
        // Unset current classes
        // Add new band
        console.log(delivery_wrapper.classList);
        delivery_wrapper.classList.remove('delivery_band_not_set');
        delivery_wrapper.classList.remove('delivery_band_0');
        delivery_wrapper.classList.remove('delivery_band_1');
        delivery_wrapper.classList.remove('delivery_band_2');
        delivery_wrapper.classList.remove('delivery_band_3');
        delivery_wrapper.classList.remove('delivery_band_4');
        delivery_wrapper.classList.remove('delivery_excluded');

        console.log(delivery_wrapper.classList);
        delivery_wrapper.classList.add(band);
        console.log(delivery_wrapper.classList);
        //delivery_wrapper.setAttribute( 'class', 'delivery_wrapper.classList);
    }

}