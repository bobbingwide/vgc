/*
  * Run this function on page load and add any required fields to the current cart session
*/
(function setupDefaultAddons() {
  var sectionRequired = document.querySelectorAll('.section-addon-wrap.main .addon-select-required');
  var blocks  = [];
  // Get the cart session container to add items to
  var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
  // Loop through each section
  for(var i = 0; i < sectionRequired.length; i++) {
    // For that section, get the blocks means each addon block
    blocks = sectionRequired[i].querySelectorAll(".block");
    // Loop through all the blocks // Addon options
    for(var b = 0; b < blocks.length; b++) {
      /*
      * Handle what happens when the code finds a checkbox
      */
      var checkbox = blocks[b].querySelector('input[type="checkbox"]');
      if(checkbox) {
        if(b == 0) {
          checkbox.checked = true;
          var addonPrice = getVisibleAddonPrice(blocks[b]); //.querySelector('.addon-price .price').textContent).toFixed(2);
          var addonName = blocks[b].querySelector('.addon-name').textContent;      
          var addonID = blocks[b].querySelector('.checkbox-container input[type="checkbox"]').name;
          addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
        } else {
          checkbox.checked = false;
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
          addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
        } else {
          select.selectedIndex = 0;
        }
      }
    }
  }


  /*
  * Make sure all the non-required addons are unchecked on page load to not confuse the customer or incase they went to checkout and came back and some addons are still checked
  */
  (function uncheckNonRequiredAddons() {
    var sectionNonRequired = document.querySelectorAll('.section-addon-wrap .addon-non-required');
    var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
    var blocks  = [];
    for(var i = 0; i < sectionNonRequired.length; i++) {
      blocks = sectionNonRequired[i].querySelectorAll(".block");
      // Loop through all the blocks // Addon options
      for(var b = 0; b < blocks.length; b++) {
        var select = blocks[b].querySelector('select');
        if(select) {
          select.selectedIndex = 0;
        }
        var checkbox = blocks[b].querySelector('input[type="checkbox"]');
        if(checkbox) {
          checkbox.checked = false;
        }
      }
    }
  })();

  
  /*
  * Toggle each section as hidden first then show
  */
  var acc = document.getElementsByClassName("toggle-next");
  for (var i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }  
})();

/*
* Code for calculating the addons added to the current cart session
*/
function addAddonToCart(event, type) {
  // On click of the checkbox get the container to add addon items to
  var currentCartSessionContainer = document.querySelector(".current-cart-session .items");
  // Get the addon name
  var addonName = event.target.parentNode.parentNode.querySelector('.addon-name').innerText;
  // Check if this section is a required section
  var currentSection = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
  // Get all the class names for the element and then convert to array
  var list = currentSection.classList;
  var array = [];
  for(var i = 0; i < list.length; i++) {
    array.push(list[i]);
  }
  // Check if the class name exists in the array // If true -> this is a required section
  // required OR select one only (like radio)
  if (array.indexOf('addon-select-required') > -1 && (array.indexOf('addon-select-radio') > -1)) {
    dealWithRequiredAddons(currentSection, event);
  }
  // Get the addon price
  if(type == "checkbox") {
    var addonPrice = getVisibleAddonPrice( event.target.parentNode.parentNode );
    // Get the addon ID
    var addonID = event.target.name;
    // If we are checking the checkbox add it to the current cart session list
    if(event.target.checked == true) {
      var item = currentCartSessionContainer.querySelector('#'+stripRandChar(addonID));
      if ( item ) {
        removeAddonItemFromCartSession(addonID, addonPrice);
      }
      addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
    }
    // Else we are removing it from the cart session list
    else {
      removeAddonItemFromCartSession(addonID, addonPrice);
    }
  }
  else {
    // It's a select box, lets get the price from the custom attribute
    dealWithMultiSelectBoxAddons(event, currentCartSessionContainer);
  }
}

/*
* Handle multi select box addons adding and removing into the cart
*/
function dealWithMultiSelectBoxAddons(event, currentCartSessionContainer) {
  var element = event.target;
  var index = event.target.selectedIndex;
  var addonID = event.target.name;
  var addonName = element.options[index].value
  var item = document.querySelector(".current-cart-session .items #"+stripRandChar(addonID));
  if(item) {
    addonPrice = item.querySelector(".price").innerText;
    addonPrice = addonPrice.replace("£", "");
    addonPrice = parseFloat(addonPrice).toFixed(2);
    removeAddonItemFromCartSession(addonID, addonPrice);
  }
  //if a dropdown select
  if(index > 0) {
    //this gets teh first data attribute rather than targeting ti by name
    var addonPrice = parseFloat(event.target[index].attributes[1].nodeValue);
    
    //this is how you do it.....
    var changeBaseSize = event.target[index].dataset.addsize;
    if(changeBaseSize)
    {
        document.getElementById("base_extra").value = changeBaseSize;
    }
    
    addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName);
  }
}


/**
  * Make sure the required addon sections have at least 1 addon selected
 *  Only applies to the main sections
  */
  function runRequiredAddonValidation() {
    var sectionRequired = document.querySelectorAll('.section-addon-wrap.main .addon-select-required');
    var blocks  = [];
    var addAddonToCartBtn = document.getElementById('btn-add-to-cart');
    addAddonToCartBtn.style = "cursor:pointer;";
    // Enable the add to cart button until the validation fails
    addAddonToCartBtn.removeAttribute('disabled');
    var validation = true;
    var i = 0;
    while(validation == true && i < sectionRequired.length) {
      // Keep a talley for this section
      var talley = [];
      // Get all the blocks / addons in this section
      blocks = sectionRequired[i].querySelectorAll(".block");
        for(var b = 0; b < blocks.length; b++) {
          // Handle addons which a checkbox
          var checkbox = blocks[b].querySelector('input[type="checkbox"]');
          if(checkbox) {
            var checked = checkbox.checked;
            if(checked) {
              talley.push(true);
            } else {
              talley.push(false);
            }
          }
          // Handle addons which a select box
          var select = blocks[b].querySelector('select');
          if(select) {
              var num = select.selectedIndex;
              if(num > 0) {
                talley.push(true);
              } else {
                talley.push(false);
              }
            }
          }
          if(!talley.includes(true)) {
            validation = false;
            if(addAddonToCartBtn) {
              addAddonToCartBtn.setAttribute('disabled', true);
              addAddonToCartBtn.style = "cursor: not-allowed";
              addAddonToCartBtn.title = "You must choose addons for the required fields marked with a *";
            }
          }
          i++;
        } 
      }


/*
* Add items into the cart
*/
function addAddonItemToCartSession(currentCartSessionContainer, addonID, addonPrice, addonName) {
  runRequiredAddonValidation();
  if ( null === addonPrice) {
    addonPrice = 0.00;
  }
  // Create the list item for the current cart session
  var itemToAdd = "<div class='text-left w-100 clearfix'><div id="+stripRandChar(addonID)+" class='d-flex minilist'><div class='minilist__name'>"+addonName+"</div><div class='price minilist__price'>£"+parseFloat(addonPrice).toFixed(2)+"</div></div></div>";
  // Insert the list item
  currentCartSessionContainer.insertAdjacentHTML('beforeend', itemToAdd);
  // Get the current subtotal or base price field
  var currentPriceField = document.querySelector(".baseprice");
  var currentPrice = parseFloat(currentPriceField.innerText).toFixed(2);
  // Calculate the total
  var total = parseFloat(currentPrice) + parseFloat(addonPrice);
  // Reinsert the total
  currentPriceField.innerText = parseFloat(total).toFixed(2);
}


/*
* Handle required addons
*/
function dealWithRequiredAddons(currentSection, event) {
  // Get all the checkboxes
  var checkboxes = currentSection.querySelectorAll('.addon-details input[type="checkbox"]');
  // Lets first loop through all the checkboxes
    for(var i = 0; i < checkboxes.length; i++) {
      // Unchecked all section checkboxes and then check the clicked checkbox
      // Find out which checkbox WAS checked
      if(checkboxes[i].checked == true && checkboxes[i] !== event.target) {
        // We now know which checkbox WAS checked
        var addonPrice = getVisibleAddonPrice( checkboxes[i].parentNode.parentNode );
        var addonID = checkboxes[i].name;
        removeAddonItemFromCartSession(addonID, addonPrice);
      }
      // Set all the checkboxes to false
      checkboxes[i].checked = false;
      event.target.checked = true;
    }
    // Now deal with any select boxes in the required addons section
    // Lets get all select boxes
    var select = currentSection.querySelectorAll('.addon-details select');
    for(var i = 0; i < select.length; i++) {
      if(select[i] !== event.target && select[i].selectedIndex > 0) {
        // Unset it so there is no option choosen
        var addonID = select[i].name;
        var index = select[i].selectedIndex;
        select[i].selectedIndex = 0;
        var addonPrice = parseFloat(select[i][index].attributes[1].nodeValue);
        removeAddonItemFromCartSession(addonID, addonPrice);
      }
  }
}

/*
* Handle removing items from the cart
*/
function removeAddonItemFromCartSession(addonID, addonPrice) {
  runRequiredAddonValidation();
  // Get the current subtotal or base price field
  var currentPriceField = document.querySelector(".baseprice");
  var currentPrice = parseFloat(currentPriceField.innerText);
  // Calculate the total
  var total = parseFloat(currentPrice).toFixed(2) - parseFloat(addonPrice).toFixed(2);
  // Reinsert the total
  currentPriceField.innerText = parseFloat(total).toFixed(2);

  // Remove the list item and subtract the price
  var listItem = document.querySelector('.current-cart-session .items #'+stripRandChar(addonID));
  if(listItem) {
    listItemParent = listItem.parentNode;
    while(listItemParent.firstChild) {
      listItemParent.removeChild(listItemParent.firstChild);
    }
  }
}

/*
* Strip any random characters that are going to affect dom selection
*/
function stripRandChar(addonID) {
  var pattern = /[&|:|/|(|)|*|%|'|]/g;
  var newID = addonID.replace(pattern, "");
  return newID;
}

/**
 * Gets the visible addon price
 *
 * @param startNode
 * @return price - formatted with 2 decimal places
 */
function getVisibleAddonPrice( startNode ) {
  var prices = startNode.querySelectorAll('.addon-price .price');
  //console.log( prices );
  var price = null;
  for (let i = 0; i < prices.length; i++) {
    if ( isNotDeliveryPrice( prices[i] ) || !isHidden( prices[i] )) {
      price = prices[i].innerText;
      //console.log( price);
      price = parseFloat( price).toFixed( 2 );
    }
  }
  if ( price === null ) {
    //console.log( "No visible price!" );
    //console.log( startNode );
  }
  return price;
}

/**
 * Returns true if this price is not a `delivery` price.
 *
 * Note: `delivery` is the class name used where the price varies by post code delivery band.
 *
 * @param el
 * @returns {boolean}
 */
function isNotDeliveryPrice( el ) {
  var classList = el.classList;
  //console.log( classList );
  var contains = classList.contains( 'delivery');
  return !contains;
}

/**
 * Returns true if the element is hidden.
 *
 * @param el
 * @returns {boolean}
 */
function isHidden(el) {
  var style = window.getComputedStyle(el);
  console.log( style );
  return ((style.display === 'none') || (style.visibility === 'hidden'));
}