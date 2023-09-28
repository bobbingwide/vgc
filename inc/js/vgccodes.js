document.querySelector('input.submit_pc').addEventListener('click', function () {
    var band = null;
    band = setbands();
    event.preventDefault();
    adjustPricesofSelectedOptions( band );
    if ( band !== 'delivery_band_not_set') {
        reSetupDefaultAddons(band);
        //reSetupDefaultAddons = alreadyDone;

    }
    enableOrDisableAddToCart( band );
});

/**
 * Pre Add to cart submission.
 *
 * Enable all checkboxes that have been disabled before allowing the form to be submitted.
 */
document.querySelector( 'button#btn-add-to-cart').addEventListener( 'click', function( e) {
   //alert( "button clicked");
   var checkboxes = document.querySelectorAll('input[type="checkbox"]' );
   //console.log( checkboxes );
   for ( var i = 0; i < checkboxes.length; i++ ) {
        var checkbox = checkboxes[i];
        if ( checkbox.checked ) {
            checkbox.disabled = false;
        } else {
            checkbox.disabled = true;
        }
   }
   //e.preventDefault();
});

function alreadyDone() {

}


/**
 * Sets the delivery band code given the post code.
 *
 */
function setbands() {
    var postcode = document.getElementById('postcode').value;
    postcode = postcode.toUpperCase();
    postcode = postcode.trim();
    var band = 'delivery_band_not_set';
    if ( postcode) {
        band = get_delivery_band_code(postcode);
    }
    console.log( band);
    setClasses( band, 'delivery_wrapper' );
    setClasses( band, 'removal_wrapper' );
    setClasses( band, 'base_wrapper');
    return band;
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

/**
 * Adjusts prices of selected options after a postcode change.
 *
 * When the user changes the postcode, and presses View Options, some prices may change depending on the post code band for the post code.
 * These changes need to be reflected in the Current Cart items.
 *
 * The logic needs to cater for both a price change and an option no longer being available.
 * The question is, do we start from the cart items or the options?
 * I think the answer is from the cart items.
 * There will nearly always be fewer cart items than options.
 */
function adjustPricesofSelectedOptions( band ) {
    // Get the cart session Minilist to adjust.
    var currentCartSessionMinilist = document.querySelectorAll(".current-cart-session .items .minilist");
    console.log(currentCartSessionMinilist);
    for ( var i = 0; i < currentCartSessionMinilist.length; i++ ) {
        // get the ID of each item.
        var itemId = currentCartSessionMinilist[i].id;
        // We only need to worry about the options which are affected by the postcode band
        // base-type: #base_wrapper
        // delivery:  #delivery_wrapper
        // builing_removal_*: #removal_wrapper
        if ( 'base-type' === itemId )  {
            setPriceForCheckedItem( currentCartSessionMinilist[i],'#base_wrapper', band);
        } else if ( 'delivery' === itemId ) {
            setPriceForCheckedItem( currentCartSessionMinilist[i],'#delivery_wrapper', band );
        } else if (itemId.startsWith( 'building_removal_' )) {
            removeRemovalBasedOnBand( currentCartSessionMinilist[i], band);
        }
    }
}

/**
 * Updates the price for the checked item.
 *
 * If there aren't any checked items and/or there's no price field
 * then we remove the item from the minilist
 * otherwise we update the price with the visible price
 *
 * @param itemId
 * @param band
 */
function setPriceForCheckedItem( item, itemId, band) {
    var checkboxes = document.querySelectorAll('.section-addon-wrap'+ itemId + ' .' + band + ' ' + 'input[type="checkbox"]');
    console.log( checkboxes );
    var addonPrice = null;
    for ( var i = 0; i < checkboxes.length; i++ ) {
        var checkbox = checkboxes[i];
        if ( checkbox.checked ) {
            addonPrice =  getVisiblePriceForItem( checkbox.parentNode.parentNode, band );
        }
    }
    if ( null === addonPrice ) {
        console.log('Remove item from minilist:' + itemId);
        removeItemFromMinilist( item );
    } else {
        console.log('Update price:' + itemId);
        updatePriceInMinilist( item, addonPrice );
    }
}

/**
 * Gets the price that's displayed for the item.
 *
 * @param startNode
 * @param band
 * @returns price
 */
function getVisiblePriceForItem( startNode, band ) {
    var addon = startNode.querySelector( '.addon-price .price.' +band  );
    //console.log( addon );
    var price = null;
    if ( addon ) {
        price = getPriceValue( addon );
    }
    return price;
}

/**
 * Gets the value for the price field.
 *
 * This strips any leading £ sign and ensures the value is formatted with 2 decimal places.
 * @param item
 * @returns value rounded to 2 decimal places
 */
function getPriceValue( item ) {
    var value = item.innerText;
    value = value.replace( '£', '');
    value = parseFloat(value).toFixed(2);
    return value;
}

/**
 * Sets the price value for an item in the minilist.
 *
 * prices in the minilist are prefixed with £.
 * @param item
 * @param addonPrice
 */
function setPriceValue( item, addonPrice ) {
    var itemPrice = item.querySelector( '.price');
    itemPrice.innerText = '£' + addonPrice;
}

/**
 * Remove building_removal items based on band.
 *
 * The building_removal item could be
 * - building_removal_removal-and-taking-away-of-timber-building
 * - building_removal_removal-of-greenhouses
 *
 * Note:
 * - Building removal costs don't vary based on postcode band
 * - The option isn't available for bands 4 and 0.
 *
 * @param item
 * @param band
 */
function removeRemovalBasedOnBand( item, band ) {
    if ( band === 'delivery_band_1' || band === 'delivery_band_2' || band === 'delivery_band_3 ' )  {
        console.log( "Leave item on minilist" + item.id );
    } else {
        console.log( 'Remove item from minilist' + item.id );
        removeItemFromMinilist( item );
    }
}

/**
 * Removes the item from the minilist.
 *
 * Unlike removeAddonItemFromCartSession() this logic doesn't call runRequiredAddonValidation()
 * and it subtracts the current price of the item from the cart total.
 *
 * @param item
 */
function removeItemFromMinilist( item ) {
    var itemPriceValue = getItemPriceValue( item );
    adjustCurrentPriceValue( itemPriceValue );
    listItemParent = item.parentNode;
    while(listItemParent.firstChild) {
        listItemParent.removeChild(listItemParent.firstChild);
    }
}

/**
 * Gets the price for the item.
 *
 * @param item
 * @returns
 */
function getItemPriceValue( item ) {
    var itemPrice = item.querySelector( '.price');
    var itemPriceValue = getPriceValue( itemPrice );
    console.log( itemPriceValue );
    return itemPriceValue;
}

/**
 * Updates the price in the minilist.
 *
 * @param item
 * @param addonPrice
 */
function updatePriceInMinilist( item, addonPrice ) {
    var currentItemPriceValue = getItemPriceValue( item );
    if ( addonPrice !== currentItemPriceValue ) {
        console.log( "Needs updating: " + item.id );
        adjustCurrentPriceValue( currentItemPriceValue - addonPrice );
        setPriceValue( item, addonPrice );
    } else {
        console.log("No change necessary:" + item.id );
    }
}

/**
 * Adjusts the current price of the product.
 *
 * This is the field prefixed "Cart Total:"
 * The adjustment is subtracted from the current price.
 *
 * @param adjustment
 */
function adjustCurrentPriceValue( adjustment ) {
    var currentPriceField = document.querySelector(".baseprice");
    var currentPriceValue = getPriceValue( currentPriceField );
    var newValue = currentPriceValue - adjustment;
    // Q. Does this need parseFloat? A. No: But it does need 2 decimal places.
    currentPriceField.innerText = newValue.toFixed(2);
}

function reSetupDefaultAddons( band ) {
    var sectionRequired = document.querySelectorAll('.section-addon-wrap.delivery .addon-select-required' + '.' +band);
    var blocks  = [];
    // Get the cart session container to add items to
    var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
    // Loop through each section
    for(var i = 0; i < sectionRequired.length; i++) {
        // For that section, get the blocks means each addon block
        blocks = sectionRequired[i].querySelectorAll(".block" + ' .' +band);
        // Loop through all the blocks // Addon options
        for(var b = 0; b < blocks.length; b++) {
            /*
            * Handle what happens when the code finds a checkbox
            */
            var checkbox = blocks[b].querySelector('input[type="checkbox"]');
            if(checkbox) {
                if(b == 0) {
                    checkbox.checked = true;
                    checkbox.disabled = true;
                    var addonPrice = getVisibleAddonPrice(blocks[b] ); //.querySelector('.addon-price .price').textContent).toFixed(2);
                    var addonName = blocks[b].querySelector('.addon-name').textContent;
                    var addonID = blocks[b].querySelector('.checkbox-container input[type="checkbox"]').name;
                    var item = currentCartSessionContainer.querySelector('#'+stripRandChar(addonID));
                    if ( item ) {
                        removeItemFromMinilist( item );
                    }
                    addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
                } else {
                    checkbox.checked = false;
                    checkbox.disabled = false;
                }
            }
            /*
            * Handle what happens when the code finds a select box
            */
            var select = blocks[b].querySelector('select');
            if(select) {
                if(b == 0) {
                    select.selectedIndex = 1;
                    var addonID = select.name;
                    var addonPrice = parseFloat(select[1].attributes[1].nodeValue).toFixed(2);
                    var addonName = select[select.selectedIndex].value;
                    var item = currentCartSessionContainer.querySelector('#'+stripRandChar(addonID));
                    if ( item ) {
                        removeAddonItemFromCartSession(addonID, addonPrice);
                    }
                    addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
                } else {
                    select.selectedIndex = 0;
                }
            }
        }
    }

}